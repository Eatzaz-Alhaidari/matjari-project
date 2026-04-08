<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the user's complaints.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $complaints
        ]);
    }

    /**
     * Store a newly created complaint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'order_id' => 'nullable|exists:orders,id',
            'image'    => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'image'   => $imagePath,
            'status' => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تقديم الشكوى بنجاح.',
            'data' => $complaint
        ], 201);
    }

    /**
     * Display the specified complaint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $complaint = Complaint::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$complaint) {
            return response()->json([
                'success' => false,
                'message' => 'Complaint not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $complaint
        ]);
    }
}
