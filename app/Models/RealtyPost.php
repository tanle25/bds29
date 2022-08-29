<?php

namespace App\Models;

use App\Models\Realty;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class RealtyPost extends Model
{
    use \Spatie\Tags\HasTags;

    protected $table = 'realty_posts';

    protected $append = ['thumb', 'type_name', 'status_name', 'link'];

    protected $fillable = [
        'title',
        'slug',
        'type',
        'price',
        'description',
        'realty_id',
        'contact_name',
        'contact_address',
        'contact_phone_number',
        'contact_email',
        'rank',
        'open_at',
        'close_at',
        'created_by',
        'price_type',
    ];

    public function realty()
    {
        return $this->belongsTo(Realty::class, 'realty_id', 'id');
    }

    public function images()
    {
        # code...
        return $this->hasMany(Image::class,'realty_post_id','id');
    }

    protected function getThumbAttribute()
    {
        if($this->images->count() > 0){
            $image =  $this->images->first()->link;
            // foreach (explode(',', $this->realty->house_image ?? '') as $item) {
            //     if ($item != null) {
            //         return Str::replaceLast('/', '/thumbs/', $item);
            //     }
            // }
            // Log::alert(Str::replaceLast('/', '/thumbs/', $image));
            return Str::replaceLast('/', '/thumbs/', $image);
        }
        return '';
       
    }

    protected function getTypeNameAttribute()
    {
        switch ($this->type) {
            case '1':
                return "Bán";
            case '2':
                return "Cho thuê";
        }
        return 'Không xác định';
    }

    protected function getStatusNameAttribute()
    {
        switch ($this->type) {
            case '1':
                return "Tin chưa duyệt";
            case '2':
                return "Tin đã kiểm định";
            case '3':
                return "Tin đã đăng";
            case '3':
                return "Tin rác";
        }
        return 'Không xác định';
    }

    public function scopePriceBetween(Builder $query, $price_start, $price_end): Builder
    {
        return $query->whereBetween('price', [$price_start, $price_end]);
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id')->select(['id','name','email','phone_number','profile_image_path']);
    }

    public function payment()
    {
        return $this->hasOne('App\Models\RealtyPostPayment', 'realty_post_id', 'id');
    }

    public function featured_by()
    {
        return $this->belongsToMany('App\Models\User', 'user_featured_posts', 'realty_post_id', 'user_id');
    }

    public function getLinkAttribute()
    {
        $slug = $this->slug;
        $district = $this->district()->slug;
        $type = $this->type == 1? 'ban' : 'cho-thue';
        return url($type.'/'.$district.'/'.$slug);
        // return route('customer.realty_post.show', $this->slug);
    }
}