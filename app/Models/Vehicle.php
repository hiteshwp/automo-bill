<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_vehicles';
    protected $primaryKey = 'id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'customer_id',
        'garage_id',
        'vin',
        'chassisno',
        'number_plate',
        'modelyear',
        'modelname',
        'modelbrand',
        'lastservice',
        'created_at',
        'updated_at',
        'deleted_at',
        'vehicle_status'
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
