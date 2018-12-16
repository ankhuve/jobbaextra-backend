<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedJob extends Model
{
    protected $table = 'job_shares';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id'
    ];

    /**
     * A job can be shared.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo('App\Job');
    }
}
