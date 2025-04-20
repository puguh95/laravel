<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'gender', 'phone', 'notes', 'item', 'amount', 'payment_no', 'status', 'checked_by'
    ];
    
}
