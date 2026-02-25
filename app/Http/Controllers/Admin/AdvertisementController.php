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
     * Remove the specified resource from storage (Reject/Delete).
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        // TODO: Send Notification to Vendor (Optional context for rejection)

        return redirect()->back()->with('success', 'تم حذف العرض بنجاح.');
    }
}
