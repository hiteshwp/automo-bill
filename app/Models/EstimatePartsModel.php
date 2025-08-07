<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimatePartsModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_estimate_parts';
    protected $primaryKey = 'estimate_parts_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'estimate_parts_id',
        'estimate_parts_estimate_id',
        'estimate_parts_reference_id',
        'estimate_parts_reference_type',
        'estimate_parts_product_id',
        'estimate_parts_product_name',
        'estimate_parts_quantity',
        'estimate_parts_cost',
        'estimate_parts_markup',
        'estimate_parts_tax',
        'estimate_parts_total',
        'created_at',
        'updated_at',
        'deleted_at',
        'estimate_parts_status'
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
