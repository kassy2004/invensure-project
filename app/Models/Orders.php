<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['order_id', 'customer_id', 'product_id', 'warehouse', 'status'];
}
