<?php

namespace App;

use Carbon\Carbon;
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

    /**
     * A job has one owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A job may be profiled.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profiledJob()
    {
        return $this->hasOne('App\ProfiledJob');
    }

    /**
     * Is the job currently profiled?
     *
     * @return bool
     */
    public function isCurrentlyProfiled()
    {
        return count($this->profiledJob) && ($this->profiledJob->end_date > Carbon::now()) ? true : false;
    }

    /**
     * Has the job been profiled?
     *
     * @return bool
     */
    public function hasBeenProfiled()
    {
        return count($this->profiledJob) && ($this->profiledJob->end_date < Carbon::now());
    }
}
