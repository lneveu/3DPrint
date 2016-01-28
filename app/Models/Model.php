<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['file', 'user_id', 'title', 'length', 'height', 'width', 'unit', 'volume', 'surface', 'price',
        'scale','scale_min', 'scale_max', 'state'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
