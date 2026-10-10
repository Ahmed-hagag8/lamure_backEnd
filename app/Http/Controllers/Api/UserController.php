<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List all users (admin only).
     * Uses select to avoid loading password hashes.
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'phone', 'address', 'avatar', 'created_at'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($users);
    }

    /**
     * Get a single user.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::query()
            ->select(['id', 'name', 'email', 'role', 'phone', 'address', 'avatar', 'created_at'])
            ->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update user profile or role.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'role' => ['sometimes', 'in:ADMIN,SUPPLIER,CUSTOMER'],
        ]);

        $user->update($validated);

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role,
            'phone' => $user->phone,
            'address' => $user->address,
        ]);
    }

    /**
     * Delete a user.
     */
    public function destroy(string $id): JsonResponse
    {
        User::findOrFail($id)->delete();

        return response()->json(['ok' => true]);
    }
}
