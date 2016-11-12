<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'logo_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'categories' => 'array',
    ];

    /**
     * A user may create many jobs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    /**
     *
     * Returns how many jobs the company has created.
     *
     * @return bool
     */
    public function numJobs()
    {
        $jobs = $this->jobs()->get();
        return(count($jobs));
    }


    /**
     *
     * Check if company has created any jobs.
     *
     * @return bool
     */
    public function hasJobs()
    {
        if($this->numJobs() > 0)
        {
            return true;
        }
        return false;
    }


    /**
     *
     * Check if company has an uploaded logotype.
     *
     * @return bool
     */
    public function hasLogo()
    {
        if($this->logo_path)
        {
            return true;
        }
        return false;
    }

    /**
     *
     * Check if user has an uploaded CV.
     *
     * @return bool
     */
    public function hasCV()
    {
        if($this->cv_path)
        {
            return true;
        }
        return false;
    }


    /**
     *
     * Get the user's uploaded CV if the user has one.
     *
     * @return bool
     */
    public function getCVLink()
    {
        if($this->hasCV())
        {
            $pathToCVFolder = 'user-cvs/';
            $disk = Storage::disk('s3');
            $fileName = $this->cv_path;

            // if the file exists
            if($disk->exists($pathToCVFolder . $fileName)){
                $url = $disk->url($pathToCVFolder . $fileName);
                return $url;
            } else{
                return false;
            }
        }
        return false;
    }



    /**
     *
     * Check if company is paying.
     *
     * @return bool
     */
    public function isPaying()
    {
        if($this->paying && $this->paid_until > \Carbon\Carbon::now())
        {
            return true;
        }
        return false;
    }


    /**
     *
     * Check if company is featured.
     *
     * @return bool
     */
    public function isFeatured()
    {
        $isFeatured = FeaturedCompany::where([
            ['company_id', '=', $this->id],
            ['end_date', '>=', \Carbon\Carbon::now()],
        ])->get();
        if(!$isFeatured->isEmpty())
        {
            return true;
        };
        return false;
    }

    /**
     *
     * Check if company previously has been featured.
     *
     * @return bool
     */
    public function hasBeenFeatured()
    {
        $isFeatured = FeaturedCompany::where([
            ['company_id', '=', $this->id],
            ['end_date', '<', \Carbon\Carbon::now()],
        ])->get();
        if(!$isFeatured->isEmpty())
        {
            return true;
        };
        return false;
    }


    /**
     *
     * If the company is featured, return the FeaturedCompany model,
     * otherwise return false.
     *
     * @return mixed
     */
    public function featured()
    {
//        return $this->hasOne('App\FeaturedCompany');
        if($this->isFeatured())
        {
            $featuredObj = FeaturedCompany::where('company_id', $this->id)->first();
            return $featuredObj;
        }
        return false;
    }
}

