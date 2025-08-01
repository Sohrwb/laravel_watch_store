<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'count',
        'total_price',
        'invoice_id',
    ];

    // هر آیتم متعلق به یک کاربر است
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // هر آیتم متعلق به یک محصول است
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // هر آیتم ممکن است به یک فاکتور متصل باشد (یا null)
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    
}
