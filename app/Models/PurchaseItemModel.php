<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_purchase_item';
    protected $primaryKey = 'purchase_item_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'purchase_item_id',
        'purchase_item_purchase_id',
        'purchase_item_product_id',
        'purchase_item_price',
        'purchase_item_qty',
        'purchase_item_total_amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'purchase_item_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'purchase_item_product_id');
    }
}
