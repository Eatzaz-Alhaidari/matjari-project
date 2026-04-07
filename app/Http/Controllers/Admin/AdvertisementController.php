<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of advertisements (Pending & All).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Advertisement::with(['store', 'vendor']);

        if ($status === 'pending') {
            $query->where('status', 0);
        } elseif ($status === 'active') {
            $query->where('status', 1);
        }

        $advertisements = $query->latest()->paginate(10);

        return view('admin.advertisements.index', compact('advertisements', 'status'));
    }

    /**
     * Show the form for creating a new advertisement.
     */
    public function create()
    {
        $stores = \App\Models\Store::active()->orderBy('name')->get();
        return view('admin.advertisements.create', compact('stores'));
    }

    /**
     * Store a newly created advertisement (Admin version).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'target_url' => 'nullable|url',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        $data = $request->except('image');
        $data['is_admin'] = true;
        $data['status'] = 1; // Active directly if created by admin
        
        if ($request->filled('store_id')) {
            $store = \App\Models\Store::find($request->store_id);
            $data['vendor_id'] = $store->user_id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement = Advertisement::create($data);

        // Notify Vendor if assigned
        if ($advertisement->vendor) {
            $advertisement->vendor->notify(new \App\Notifications\NewAdvertisementNotification($advertisement));
        }

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'تم إنشاء الإعلان وتخصيصه بنجاح.');
    }

    /**
     * Show the form for editing the specified advertisement.
     */
    public function edit(Advertisement $advertisement)
    {
        $stores = \App\Models\Store::active()->orderBy('name')->get();
        return view('admin.advertisements.edit', compact('advertisement', 'stores'));
    }

    /**
     * Update the specified advertisement.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'target_url' => 'nullable|url',
            'store_id' => 'nullable|exists:stores,id',
            'status' => 'required|integer|in:0,1,2,3',
        ]);

        $data = $request->except('image');
        
        if ($request->filled('store_id')) {
            $store = \App\Models\Store::find($request->store_id);
            $data['vendor_id'] = $store->user_id;
        }

        if ($request->hasFile('image')) {
            if ($advertisement->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($advertisement->image);
            }
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->update($data);

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'تم تحديث بيانات الإعلان بنجاح.');
    }

    /**
     * Approve an advertisement.
     */
    public function approve(Advertisement $advertisement)
    {
        $advertisement->update(['status' => 1]);

        // Send Notification to Vendor
        if ($advertisement->vendor) {
            $advertisement->vendor->notify(new \App\Notifications\AdvertisementApprovedNotification($advertisement));
        }

        return redirect()->back()->with('success', 'تم الموافقة على العرض بنجاح وأصبح نشطاً.');
    }

    /**
     * Reject an advertisement.
     */
    public function reject(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $advertisement->update([
            'status' => 2,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send Notification to Vendor
        if ($advertisement->vendor) {
            $advertisement->vendor->notify(new \App\Notifications\AdvertisementRejectedNotification($advertisement));
        }

        return redirect()->back()->with('success', 'تم رفض العرض وإرسال السبب للتاجر.');
    }

    /**
     * Remove the specified resource from storage (Delete).
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return redirect()->back()->with('success', 'تم حذف العرض بنجاح.');
    }
}
