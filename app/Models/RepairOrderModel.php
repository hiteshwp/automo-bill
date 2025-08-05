<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RepairOrderModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_repair_order';
    protected $primaryKey = 'repairorder_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'repairorder_id',
        'repairorder_booking_id',
        'repairorder_estimate_id',
        'repairorder_garage_id',
        'repairorder_customer_id',
        'repairorder_vehicle_id',
        'repairorder_order_date',
        'repairorder_notes',
        'repairorder_labor_total',
        'repairorder_parts_total',
        'repairorder_order_no',
        'repairorder_garage_employee',
        'repairorder_employee_email',
        'repairorder_employee_phone',
        'repairorder_amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'repairorder_status'
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
