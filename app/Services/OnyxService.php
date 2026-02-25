<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class OnyxService
{
    public function createOrder($data)
    {
        Log::info('OnyxService createOrder called', $data);
        // TODO: Implement actual Onyx API call

        // Simulate success response from Onyx
        return [
            'success' => true,
            'onyx_ref' => 'ONX-' . rand(10000, 99999)
        ];
    }
}