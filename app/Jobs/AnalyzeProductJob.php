<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ProductQualityService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Product $product)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(ProductQualityService $service): void
    {
        Log::info("Starting AI Analysis for Product #{$this->product->id}");

        $result = $service->analyze($this->product);

        $this->product->update([
            'ai_status' => $result['status'],
            'ai_notes' => $result,
        ]);

        // Auto-inactivate if rejected
        if ($result['status'] === 'rejected') {
            $this->product->update(['status' => 'inactive']);
            Log::warning("Product #{$this->product->id} auto-inactivated due to AI rejection.");
        }

        Log::info("Completed AI Analysis for Product #{$this->product->id}. Status: {$result['status']}");
    }
}
