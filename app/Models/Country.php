<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Country extends Model
{
    protected $guarded = [ "id",'created_at','updated_at' ];

    public function activity()
    {
        return $this->morphOne('App\Models\Activity', 'activities');
    }
    public function langs()
    {
        return $this->hasMany('App\Models\Lang','item_id')->where('type','country');
    }
    public function works()
    {
        return $this->hasMany('App\Models\JobWork','country_id');
    }

    public function user_create()
    {
        return $this->belongsTo('App\Models\User', 'create_user_id');
    }

    public function photo()
    {
        return $this->morphOne('App\Models\FilePhoto', 'pictures');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            if(count($item->langs))
            {
                foreach ($item->langs as $lang){
                    $lang->delete();
                }
            }
            if($item->photo)
            {
                if(is_file($item->photo->path))
                {
                    File::delete($item->photo->path);
                }
                $item->photo->delete();
            }
        });

    }
}