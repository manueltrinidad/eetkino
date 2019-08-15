<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    protected $fillable = [
        'name'
    ];

    public function films()
    {
        return $this->belongsToMany('App\Film')->withPivot('credit');
    }
}
