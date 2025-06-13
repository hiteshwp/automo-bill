<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_products';
    protected $primaryKey = 'product_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'product_supplier_id',
        'product_name',
        'product_garage_owner_id',
        'product_number',
        'product_description',
        'product_price',
        'product_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'product_status'
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
}
