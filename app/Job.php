<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'work_place',
        'type',
        'county',
        'municipality',
        'description',
        'latest_application_date',
        'contact_email',
        'external_link',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A job may be profiled.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobs()
    {
        return $this->hasOne('App\ProfiledJob');
    }
}
