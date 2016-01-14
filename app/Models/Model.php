<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['file', 'title', 'length', 'height', 'width', 'thickness', 'volume', 'surface', 'price',
        'state'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
