<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): View
    {
        $usersQuery = User::query();
        $usersQuery->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['super-admin', 'vendor']);
        });

        if (request()->filled('search')) {
            $searchTerm = request('search');
            $usersQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $users = $usersQuery->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['active', 'banned'])],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات العميل بنجاح!');
    }

    public function destroy(string $id) {}
}