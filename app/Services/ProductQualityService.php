<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductQualityService
{
    protected string $driver;
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->driver = config('ai-agent.default', 'openai');
        $this->apiKey = config("ai-agent.drivers.{$this->driver}.api_key");
        $this->model = config("ai-agent.drivers.{$this->driver}.model");
    }

    /**
     * Analyze product data (Name, Description, Image) using AI Vision.
     *
     * @param Product $product
     * @param string|null $temporaryImagePath
     * @return array
     */
    public function analyze(Product $product, ?string $temporaryImagePath = null): array
    {
        try {
            $imagePath = $temporaryImagePath ?: storage_path('app/public/' . $product->image);

            if (!$imagePath || !file_exists($imagePath)) {
                return [
                    'status' => 'rejected',
                    'reason' => 'صورة المنتج مفقودة أو غير صالحة. يرجى رفع صورة حقيقية.',
                    'mismatch_type' => 'unclear',
                    'suggestions' => 'يرجى رفع صورة واضحة للمنتج.'
                ];
            }

            $base64Image = base64_encode(file_get_contents($imagePath));
            $mimeType = mime_content_type($imagePath);
            $prompt = $this->getPrompt($product);

            if ($this->driver === 'gemini') {
                return $this->analyzeWithGemini($prompt, $base64Image, $mimeType);
            }

            return $this->analyzeWithOpenAI($prompt, $base64Image, $mimeType);

        } catch (\Exception $e) {
            Log::error("ProductQualityService Exception ({$this->driver}): " . $e->getMessage());

            // If OpenAI fails and we have Gemini configured, try fallback
            if ($this->driver === 'openai' && config('ai-agent.drivers.gemini.api_key')) {
                Log::info("Attempting fallback to Gemini due to OpenAI failure.");
                try {
                    $this->driver = 'gemini';
                    $this->apiKey = config('ai-agent.drivers.gemini.api_key');
                    $this->model = config('ai-agent.drivers.gemini.model');
                    return $this->analyze($product, $temporaryImagePath);
                } catch (\Exception $fallbackEx) {
                    Log::error("Gemini Fallback failed: " . $fallbackEx->getMessage());
                }
            }

            return [
                'status' => 'failed_service',
                'reason' => 'عذراً، نظام الفحص الآلي غير متاح حالياً. سيتم مراجعة طلبك يدوياً.',
                'mismatch_type' => 'unclear',
                'suggestions' => 'يرجى المحاولة لاحقاً أو انتظار مراجعة الإدارة.'
            ];
        }
    }

    protected function analyzeWithOpenAI(string $prompt, string $base64Image, string $mimeType): array
    {
        $response = Http::timeout(60)->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => $this->model ?: 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $prompt],
                        ['type' => 'image_url', 'image_url' => ['url' => "data:{$mimeType};base64,{$base64Image}"]]
                    ],
                ],
            ],
            'response_format' => ['type' => 'json_object'],
            'max_tokens' => 500,
        ]);

        if ($response->failed()) {
            throw new \Exception('OpenAI API Error: ' . ($response->json('error.message') ?? $response->body()));
        }

        $result = json_decode($response->json('choices.0.message.content'), true);
        return $this->formatResult($result);
    }

    protected function analyzeWithGemini(string $prompt, string $base64Image, string $mimeType): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::timeout(60)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $base64Image
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'response_mime_type' => 'application/json',
            ]
        ]);

        if ($response->failed()) {
            throw new \Exception('Gemini API Error: ' . ($response->json('error.message') ?? $response->body()));
        }

        $content = $response->json('candidates.0.content.parts.0.text');
        $result = json_decode($content, true);

        return $this->formatResult($result);
    }

    protected function formatResult(?array $result): array
    {
        return [
            'status' => $result['status'] ?? 'needs_edit',
            'reason' => $result['reason'] ?? 'فشل في تحليل المنتج.',
            'mismatch_type' => $result['mismatch_type'] ?? 'unclear',
            'suggestions' => $result['suggestions'] ?? 'يرجى مراجعة بيانات المنتج.'
        ];
    }

    /**
     * Get the custom prompt for the AI Agent.
     */
    protected function getPrompt(Product $product): string
    {
        return "
        You are an AI Product Quality Validator for a professional E-commerce store.
        Your task is ONLY to verify the match between the product name, description, and the provided image.

        Product Details:
        - Name: \"{$product->name}\"
        - Description: \"{$product->description}\"

        Verification Logic:
        1. Does the image represent the product mentioned in the name?
        2. Does the description match the image?
        3. Are there any clear contradictions? (e.g. Name says 'Laptop' but Image is a 'Bag').

        Decisions:
        - approved: If name, description, and image all match accurately.
        - rejected: If there is a clear mismatch or contradiction.
        - needs_edit: If the image is unclear or of very poor quality.

        Output Format (STRICT JSON ONLY):
        {
          \"status\": \"approved | rejected | needs_edit\",
          \"reason\": \"A clear, professional explanation in Arabic language\",
          \"mismatch_type\": \"name_vs_image | description_vs_image | unclear\",
          \"suggestions\": \"Specific and actionable steps in Arabic language\"
        }
        ";
    }
}
