<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingModel extends Model
{
     use SoftDeletes;
    protected $table = 'tbl_settings';
    protected $primaryKey = 'setting_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'setting_id',
        'setting_garage_id',
        'setting_address',
        'setting_system_name',
        'setting_starting_year',
        'setting_phone_number',
        'setting_countrycode',
        'setting_countryisocode',
        'setting_email',
        'setting_country_id',
        'setting_state_id',
        'setting_city_id',
        'setting_zip',
        'setting_logo_image',
        'setting_cover_image',
        'setting_system_logo',
        'setting_paypal_id',
        'setting_date_format',
        'setting_website',
        'setting_tag_line',
        'setting_currancy',
        'setting_tax_1',
        'setting_tax_2',
        'setting_tax_3',
        'setting_labor_1',
        'setting_labor_2',
        'setting_labor_3',
        'setting_tax_number',
        'setting_show_tax_number',
        'setting_show_invoice_number',
        'setting_carmd_credits_remaining',
        'created_at',
        'updated_at',
        'deleted_at',
        'setting_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [];
}
