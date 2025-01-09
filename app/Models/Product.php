<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',

        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'brand_id',
        'description',
        'created_by',
        'updated_by',

        'discount_id',
        'cost_price',
        'sale_price',
        'discounted_sale_price',

        'barcode',
        'sku',
        'quantity',
        'alert_quantity',

        'is_returnable',
        'return_validity',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'sub_category_id' => 'integer',
        'sub_sub_category_id' => 'integer',
        'brand_id' => 'integer',
        'deleted_at' => 'timestamp',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'discount_id' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subSubCategory(): BelongsTo
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function productPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function productVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }
}
