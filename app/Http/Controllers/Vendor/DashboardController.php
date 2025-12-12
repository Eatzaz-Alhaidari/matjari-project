<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // حالياً، لا نحتاج لإرسال أي بيانات.
        // سنضيف الإحصائيات لاحقاً.
        return view('vendor.dashboard');
    }
}
