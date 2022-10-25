<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class UserAgentLang extends Model
{
    protected $guarded = ["id", 'created_at', 'updated_at'];

    public function agent()
    {
        return $this->belongsTo('App\Models\UserAgent', 'agent_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function list_lang()
    {
        return $this->belongsTo('App\Models\ListLang', 'lang_id');
    }
    
}