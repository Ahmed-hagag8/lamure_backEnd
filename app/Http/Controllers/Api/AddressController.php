<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(string $userId): JsonResponse
    {
        $addresses = Address::where('user_id', $userId)->latest()->get();
        return response()->json($addresses);
    }

    public function store(Request $request, string $userId): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'nullable|string',
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'is_default' => 'boolean'
        ]);

        if (!empty($validated['is_default'])) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
        }

        $address = Address::create(array_merge($validated, ['user_id' => $userId]));
        return response()->json($address, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $address = Address::findOrFail($id);
        
        $validated = $request->validate([
            'label' => 'nullable|string',
            'full_name' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'street_address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'is_default' => 'boolean'
        ]);

        if (!empty($validated['is_default'])) {
            Address::where('user_id', $address->user_id)->update(['is_default' => false]);
        }

        $address->update($validated);
        return response()->json($address);
    }

    public function destroy(string $id): JsonResponse
    {
        Address::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}
