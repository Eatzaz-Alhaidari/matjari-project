<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeId = $this->route('id');

        return [
            'store_number' => [
                'nullable',
                'string',
                'max:50',
                $storeId ? 'unique:stores,store_number,' . $storeId : 'unique:stores,store_number',
            ],
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                $storeId ? 'unique:stores,slug,' . $storeId : 'unique:stores,slug',
            ],
            'slogan' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'commercial_registration' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'logo_path' => 'nullable|string',
            'cover_image_path' => 'nullable|string',
            'support_phone' => 'nullable|string|max:20',
            'support_email' => 'nullable|email|max:255',
            'shipping_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'accounting_system' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
