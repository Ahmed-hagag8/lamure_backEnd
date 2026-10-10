<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * List products with eager-loaded relations (prevents N+1).
     * Supports: ?category=slug&search=term&limit=N
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->withRelations()
            ->active();

        if ($categorySlug = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($supplierId = $request->query('supplierId')) {
            $query->where('supplier_id', $supplierId);
        }

        if ($search = $request->query('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $limit = min((int) $request->query('limit', 50), 100);

        $products = $query
            ->limit($limit)
            ->get();

        return response()->json($this->transformCollection($products));
    }

    /**
     * Get a single product by ID with relations.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::withRelations()->findOrFail($id);

        return response()->json($this->transformProduct($product));
    }

    /**
     * Create a new product.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['numeric', 'min:0', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['array'],
            'images.*' => ['string', 'url'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'brand' => ['nullable', 'string'],
            'categoryId' => ['required', 'uuid', 'exists:categories,id'],
            'supplierId' => ['required', 'uuid', 'exists:users,id'],
            'isActive' => ['boolean'],
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount' => $validated['discount'] ?? 0,
            'stock' => $validated['stock'],
            'images' => $validated['images'] ?? [],
            'size' => $validated['size'] ?? null,
            'color' => $validated['color'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'is_active' => $validated['isActive'] ?? true,
            'category_id' => $validated['categoryId'],
            'supplier_id' => $validated['supplierId'],
        ]);

        $product->load(['category:id,name,slug', 'supplier:id,name']);

        return response()->json($this->transformProduct($product), 201);
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'discount' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'images' => ['sometimes', 'array'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'brand' => ['nullable', 'string'],
            'categoryId' => ['sometimes', 'uuid', 'exists:categories,id'],
            'isActive' => ['sometimes', 'boolean'],
        ]);

        $data = [];
        if (isset($validated['name'])) {
            $data['name'] = $validated['name'];
        }
        if (isset($validated['description'])) {
            $data['description'] = $validated['description'];
        }
        if (isset($validated['price'])) {
            $data['price'] = $validated['price'];
        }
        if (isset($validated['discount'])) {
            $data['discount'] = $validated['discount'];
        }
        if (isset($validated['stock'])) {
            $data['stock'] = $validated['stock'];
        }
        if (isset($validated['images'])) {
            $data['images'] = $validated['images'];
        }
        if (array_key_exists('size', $validated)) {
            $data['size'] = $validated['size'];
        }
        if (array_key_exists('color', $validated)) {
            $data['color'] = $validated['color'];
        }
        if (array_key_exists('brand', $validated)) {
            $data['brand'] = $validated['brand'];
        }
        if (isset($validated['categoryId'])) {
            $data['category_id'] = $validated['categoryId'];
        }
        if (isset($validated['isActive'])) {
            $data['is_active'] = $validated['isActive'];
        }

        $product->update($data);
        $product->load(['category:id,name,slug', 'supplier:id,name']);

        return response()->json($this->transformProduct($product));
    }

    /**
     * Delete a product.
     */
    public function destroy(string $id): JsonResponse
    {
        Product::findOrFail($id)->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Transform a product model to the DTO expected by the frontend.
     *
     * @param Product $product
     * @return array<string, mixed>
     */
    private function transformProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => (float) $product->price,
            'discount' => (float) $product->discount,
            'stock' => $product->stock,
            'rating' => (float) $product->rating,
            'reviewCount' => $product->review_count,
            'images' => $product->images ?? [],
            'size' => $product->size,
            'color' => $product->color,
            'brand' => $product->brand,
            'isActive' => $product->is_active,
            'categoryId' => $product->category_id,
            'categoryName' => $product->category->name ?? '',
            'categorySlug' => $product->category->slug ?? '',
            'supplierId' => $product->supplier_id,
            'supplierName' => $product->supplier->name ?? '',
        ];
    }

    /**
     * Transform a collection of products.
     *
     * @return array<int, array<string, mixed>>
     */
    private function transformCollection($products): array
    {
        return $products->map(fn (Product $p) => $this->transformProduct($p))->all();
    }
}
