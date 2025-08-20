<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
     use SoftDeletes;
    protected $table = 'tbl_booking';
    protected $primaryKey = 'booking_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_id',
        'booking_garage_id',
        'booking_vehicle_id',
        'booking_customer_id',
        'booking_date',
        'booking_time',
        'booking_date_time',
        'booking_details',
        'booking_sms_template',
        'booking_google_event_id',
        'booking_google_event_summary',
        'booking_google_event_start',
        'booking_google_event_end',
        'booking_is_service',
        'booking_is_covidsafe',
        'booking_from',
        'created_at',
        'updated_at',
        'deleted_at',
        'booking_status'
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
