<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EstimateModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_estimate';
    protected $primaryKey = 'estimate_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'estimate_id',
        'estimate_booking_id',
        'estimate_estimate_no',
        'estimate_garage_id',
        'estimate_customer_id',
        'estimate_vehicle_id',
        'estimate_date',
        'estimate_notes',
        'estimate_labor_total',
        'estimate_parts_total',
        'estimate_tax',
        'estimate_total',
        'estimate_total_inctax',
        'estimate_carOwnerApproval',
        'created_at',
        'updated_at',
        'deleted_at',
        'estimate_status'
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
