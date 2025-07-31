<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'status',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    // هر فاکتور متعلق به یک کاربر است
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // یک فاکتور چندین آیتم دارد
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
