<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'store_number' => $this->store_number,
            'name' => $this->name,
            'slug' => $this->slug,
            'slogan' => $this->slogan,
            'description' => $this->description,
            'commercial_registration' => $this->commercial_registration,
            'address' => $this->address,
            'logo_path' => $this->logo_path,
            'cover_image_path' => $this->cover_image_path,
            'support_phone' => $this->support_phone,
            'support_email' => $this->support_email,
            'shipping_policy' => $this->shipping_policy,
            'return_policy' => $this->return_policy,
            'accounting_system' => $this->accounting_system,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
