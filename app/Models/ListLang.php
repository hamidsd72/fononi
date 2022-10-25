<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ListLang extends Model
{
    protected $guarded = [ "id",'created_at','updated_at' ];

    public function activity()
    {
        return $this->morphOne('App\Models\Activity', 'activities');
    }
    public function langs()
    {
        return $this->hasMany('App\Models\Lang','item_id')->where('type','list_lang');
    }
    public function agent_langs()
    {
        return $this->hasMany('App\Models\UserAgentLang', 'lang_id');
    }
    public function user_create()
    {
        return $this->belongsTo('App\Models\User', 'create_user_id');
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
        });

    }
}