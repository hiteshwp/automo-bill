<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstimateLaborModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_estimate_labor';
    protected $primaryKey = 'estimate_labor_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'estimate_labor_id',
        'estimate_labor_reference_id',
        'estimate_labor_estimate_id',
        'estimate_labor_reference_type',
        'estimate_labor_item',
        'estimate_labor_rate',
        'estimate_labor_hours',
        'estimate_labor_cost',
        'estimate_labor_tax',
        'estimate_labor_total',
        'created_at',
        'updated_at',
        'deleted_at',
        'estimate_labor_status'
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
