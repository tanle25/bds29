<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'parent_code', 'code');
    }

    public function realty_posts()
    {
        return $this->hasManyThrough(
            'App\Models\RealtyPost',
            'App\Models\Realty',
            'commune_code',
            'realty_id',
            'code',
            'id',
        );
    }
}