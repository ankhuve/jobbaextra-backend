<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedCompany extends Model
{
    protected $table = 'featured_companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
    ];

    /**
     * A user may create many jobs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function company()
    {
        return $this->belongsTo('App\User');
    }
}
