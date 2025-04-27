<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'uuid', 'status_id', 'reference',
        'name', 'gender', 'phone',
        'notes', 'item', 'amount',
        'payment_no', 'status', 'checked_by',
        'order_id', 'payment_url', 'email',
        'payment_name',
    ];

    public function status(){
        return $this->belongsTo(Status::class);
    }
    
}
