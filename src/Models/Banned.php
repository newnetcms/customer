<?php

namespace Newnet\Customer\Models;

use Illuminate\Database\Eloquent\Model;

class Banned extends Model
{
    protected $table = 'customer__banneds';

    protected $fillable = [
        'customer_id',
        'reason',
        'expired_at',
        'is_forever',
        'user_ban_id',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
