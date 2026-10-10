<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Get reviews for a product.
     */
    public function index(string $productId): JsonResponse
    {
        $reviews = Review::with('user:id,name')
            ->where('product_id', $productId)
            ->latest()
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'rating' => $r->rating,
                    'text' => $r->comment,
                    'name' => $r->user->name,
                    'date' => $r->created_at->diffForHumans(),
                ];
            });

        return response()->json($reviews);
    }

    /**
     * Store a new review.
     */
    public function store(Request $request, string $productId): JsonResponse
    {
        $validated = $request->validate([
            'userId' => ['required', 'uuid', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'text' => ['required', 'string', 'max:1000'],
        ]);

        $product = Product::findOrFail($productId);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $validated['userId'],
            'rating' => $validated['rating'],
            'comment' => $validated['text'],
        ]);

        // Update product statistics
        $product->increment('review_count');
        $averageRating = Review::where('product_id', $product->id)->avg('rating');
        $product->update(['rating' => $averageRating]);

        $review->load('user:id,name');

        return response()->json([
            'id' => $review->id,
            'rating' => $review->rating,
            'text' => $review->comment,
            'name' => $review->user->name,
            'date' => $review->created_at->diffForHumans(),
        ], 201);
    }
}
