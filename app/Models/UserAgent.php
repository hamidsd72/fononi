<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class UserAgent extends Model
{
    protected $guarded = ["id", 'created_at', 'updated_at'];

    public function activity()
    {
        return $this->morphOne('App\Models\Activity', 'activities');
    }

    public function agent_langs() 
    {
        return $this->hasMany('App\Models\UserAgentLang', 'agent_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function agent_level()
    {
        return $this->belongsTo('App\Models\User', 'level_id');
    }
    public function agent_level_request()
    {
        return $this->belongsTo('App\Models\User', 'level_request_id');
    }
    public function marital()
    {
        return $this->belongsTo('App\Models\Marital', 'marital_id');
    }
    public function status_job()
    {
        return $this->belongsTo('App\Models\StatusJob', 'job_status_id');
    }
    public function education()
    {
        return $this->belongsTo('App\Models\EducationList', 'education_id');
    }
    public function introduction()
    {
        return $this->belongsTo('App\Models\Introduction', 'introduction_id');
    }

    public function cv_file()
    {
        return $this->morphOne('App\Models\FileArchive', 'archives');
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            if ($item->cv_file) {
                if (is_file($item->cv_file->path)) {
                    File::delete($item->cv_file->path);
                }
                $item->cv_file->delete();
            }
        });

    }
}