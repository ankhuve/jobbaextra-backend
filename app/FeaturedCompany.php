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
        'title',
        'subtitle',
        'description',
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

    /**
     * Check if the company has made a presentation yet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasPresentation()
    {
        if($this->title)
        {
            return true;
        }
        return false;
    }
}
