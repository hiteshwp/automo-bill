<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'tbl_countries'; // Define the custom table name

    protected $fillable = ['name', 'code', 'phonecode'];

    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }
}
