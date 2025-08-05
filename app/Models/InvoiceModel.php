<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_invoices';
    protected $primaryKey = 'invoice_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'invoice_id',
        'invoice_repairorder_id',
        'invoice_estimate_id',
        'invoice_booking_id',
        'invoice_no',
        'invoice_type',
        'invoice_garage_id',
        'invoice_customer_id',
        'invoice_vehicle_id',
        'invoice_date',
        'invoice_notes',
        'invoice_labor_total',
        'invoice_parts_total',
        'invoice_tax',
        'invoice_total',
        'invoice_total_inctax',
        'invoice_paid_amount',
        'invoice_payment_status',
        'created_at',
        'updated_at',
        'deleted_at',
        'invoice_status'
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
