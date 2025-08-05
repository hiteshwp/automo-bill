<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_purchase';
    protected $primaryKey = 'purchase_id'; // This is optional if your primary key is already `id`, but include it for clarity

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'purchase_id',
        'purchase_date',
        'purchase_garage_owner_id',
        'purchase_number',
        'purchase_supplier_id',
        'purchase_supplier_name',
        'purchase_supplier_mobile',
        'purchase_supplier_email',
        'purchase_supplier_address',
        'created_at',
        'updated_at',
        'deleted_at',
        'purchase_status'
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

    public function items()
    {
        return $this->hasMany(PurchaseItemModel::class, 'purchase_item_purchase_id');
    }
}
