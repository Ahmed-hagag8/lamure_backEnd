<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property float $price
 * @property float $discount
 * @property int $stock
 * @property float $rating
 * @property int $review_count
 * @property array|null $images
 * @property string|null $size
 * @property string|null $color
 * @property string|null $brand
 * @property bool $is_active
 * @property string $category_id
 * @property string $supplier_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount', 'stock',
        'rating', 'review_count', 'images', 'size', 'color', 'brand',
        'is_active', 'category_id', 'supplier_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'rating' => 'decimal:2',
            'stock' => 'integer',
            'review_count' => 'integer',
            'is_active' => 'boolean',
            'images' => 'array',
        ];
    }

    /**
     * Category this product belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Supplier who listed this product.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    /**
     * Order items containing this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Reviews for this product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculate discounted price.
     */
    public function getDiscountedPriceAttribute(): float
    {
        return round($this->price * (1 - $this->discount / 100), 2);
    }

    /**
     * Scope: only active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: low stock (≤10 units).
     */
    public function scopeLowStock(Builder $query, int $threshold = 10): Builder
    {
        return $query->where('stock', '<=', $threshold);
    }

    /**
     * Scope: eager-load common relations to prevent N+1.
     */
    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['category:id,name,slug', 'supplier:id,name']);
    }
}
