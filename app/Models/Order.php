<?php

namespace App\Models;

class Order extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'model_id', 'user_id', 'quantity', 'sub_total', 'shipping_costs', 'total'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function model()
    {
        return $this->belongsTo('App\Models\Model');
    }
}
