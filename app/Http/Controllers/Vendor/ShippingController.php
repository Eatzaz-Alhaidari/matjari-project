<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * Display a listing of shipments for the vendor's orders.
     */
    public function index()
    {
        $storeId = Auth::user()->store->id;

        $shippings = Shipment::whereHas('order', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })
            ->with(['order.user'])
            ->latest()
            ->paginate(15);

        return view('vendor.shipping.index', compact('shippings'));
    }
}
