<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingAddressController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('addresses')
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->select(
                'addresses.*',
                'users.name as user_name',
                'users.phone as user_phone'
            );

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('users.name', 'like', "%{$q}%")
                    ->orWhere('addresses.city', 'like', "%{$q}%")
                    ->orWhere('users.phone', 'like', "%{$q}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('addresses.city', $request->city);
        }

        $addresses = $query->orderByDesc('addresses.created_at')->paginate(20);

        $cities = DB::table('addresses')->distinct()->pluck('city');

        return view('admin.shipping-addresses.index', compact('addresses', 'cities'));
    }

    public function destroy($id)
    {
        DB::table('addresses')->where('id', $id)->delete();
        return redirect()->route('admin.shipping-addresses.index')
            ->with('success', 'تم حذف العنوان بنجاح.');
    }
}
