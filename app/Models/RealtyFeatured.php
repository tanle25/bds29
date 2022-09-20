<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealtyFeatured extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function reltyPost()
    {
        # code...
        return $this->hasOne(RealtyPost::class,'id','realty_post_id');
    }
}
