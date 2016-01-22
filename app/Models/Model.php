<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['file', 'user_id', 'title', 'length', 'height', 'width', 'thickness', 'volume', 'surface', 'price',
        'state'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
