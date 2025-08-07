<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'businessname',
        'mobilenumber',
        'email',
        'password',
        'taxnumber',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'zip',
        'website',
        'user_type',
        'garage_owner_id',
        'user_join_date',
        'user_left_date',
        'countryisocode',
        'countrycode'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin() {
        return $this->user_type === 'Super Admin';
    }

    public function isGarageOwner() {
        return $this->user_type === 'Garage Owner';
    }

    public function subscription()
    {
        return $this->hasOne(\App\Models\Subscription::class);
    }

    public function hasActiveSubscription()
    {
        $sub = $this->subscription;

        return $sub &&
            $sub->status === 'active' &&
            $sub->start_date <= now() &&
            $sub->end_date >= now();
    }

}
