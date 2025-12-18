<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Advertisement::where('store_id', auth()->user()->store->id)
            ->with(['store']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('start_date', 'like', "%{$search}%");
            });
        }

        if ($request->has('search_date') && $request->search_date != '') {
            $query->whereDate('start_date', $request->search_date);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $advertisements = $query->latest()->paginate(10);

        return view('vendor.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'target_url' => 'nullable|url',
        ]);

        $data = $request->except('image');
        $data['store_id'] = auth()->user()->store->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        Advertisement::create($data);

        return redirect()->route('vendor.advertisements.index')
            ->with('success', 'تم إضافة الإعلان بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        // التأكد من أن الإعلان ينتمي لمتجر البائع
        if ($advertisement->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بعرض هذا الإعلان');
        }

        return view('vendor.advertisements.show', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        // التأكد من أن الإعلان ينتمي لمتجر البائع
        if ($advertisement->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الإعلان');
        }

        return view('vendor.advertisements.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        // التأكد من أن الإعلان ينتمي لمتجر البائع
        if ($advertisement->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الإعلان');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'target_url' => 'nullable|url',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->update($data);

        return redirect()->route('vendor.advertisements.index')
            ->with('success', 'تم تعديل الإعلان بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        // التأكد من أن الإعلان ينتمي لمتجر البائع
        if ($advertisement->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بحذف هذا الإعلان');
        }

        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return redirect()->route('vendor.advertisements.index')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }

    public function toggleStatus(Advertisement $advertisement)
    {
        // التأكد من أن الإعلان ينتمي لمتجر البائع
        if ($advertisement->store_id !== auth()->user()->store->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الإعلان');
        }

        $advertisement->status = $advertisement->status === 'active' ? 'inactive' : 'active';
        $advertisement->save();

        $message = $advertisement->status === 'active' ? 'تم تفعيل الإعلان بنجاح' : 'تم تعطيل الإعلان بنجاح';

        return redirect()->route('vendor.advertisements.index')
            ->with('success', $message);
    }
}
