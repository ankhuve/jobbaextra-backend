<?php

namespace App\Http\Controllers;

use App\Events\JobCreated;
use App\FeaturedCompany;
use App\Http\Requests\UpdateJobRequest;
use App\Job;
use App\ProfiledJob;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\View;
use Illuminate\Support\Facades\Response;
use stdClass;

class DashboardController extends Controller
{

    protected $auth;
    protected $company;

    /**
     * Create a new Dashboard controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'guest']);
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $users = User::where('role', 2)
            ->orWhere('role', 3)
            ->latest()
            ->get(); // only get users registered as company

        return view('dashboard.index', compact('users'));
    }

    /**
     * Show a company's page with all of their created jobs.
     *
     * @param $company
     * @return View
     */
    public function company($companyId)
    {
        $jobs = Job::where('user_id', $companyId)->get(); // get the company's job ads
        $company = User::find($companyId);

        return view('dashboard.company', compact('jobs', 'company'));
    }


    public function users()
    {
        $users = User::where([
            ['role', '=', '1'],
//            ['cv_path', '!=', 'null'],
        ])
            ->orderBy('cv_path', 'desc')
            ->paginate(25); // paginate the users
//            ->get(); // only get users registered as users

        $filters = $this->getApiFiltersArray();

        $allFilters = [];

        if(!empty($filters)){
            foreach ($filters as $filter) {
                $filterArray = [];
                $options = $filter->soklista->sokdata;
                $filterName = $filter->soklista->listnamn;
                foreach ($options as $option) {
                    $filterArray[$option->id] = $option->namn;
                }
                $allFilters[$filterName] = $filterArray;
            }
        }

        return view('dashboard.users', compact('users', 'allFilters'));
    }

    /**
     * Download a user's CV if the user has uploaded one.
     *
     * @param $userId
     * @return bool
     */
    public function download($userId)
    {
        $user = User::find($userId);
        $pathToCVFolder = 'user-cvs/';
        $disk = Storage::disk('s3');
        $fileName = $user->cv_path;
        $path = $pathToCVFolder . $fileName;

        // if the file exists
        if($disk->exists($path)){
            $file =  $disk->readStream($path);

            // returns array of metadata for the file
            $metadata =  $disk->getDriver()->getMetadata($path);

            // returns mimetype
            $mimetype =  $metadata['mimetype'];

            // returns filesize
            $size =  $metadata['size'];

            return Response::stream(function() use($file) {
                fpassthru($file);
            }, 200, [
                "Content-Type" => $mimetype,
                "Content-Length" => $size,
                "Content-disposition" => "attachment; filename=\"" .basename($path) . "\"",
            ]);

        } else{
            return false;
        }
    }

    /**
     * Show the edit job form.
     *
     * @param $companyId
     * @param null $jobId
     * @return View
     */
    public function editJob($companyId, $jobId = null)
    {
//        $counties = [
//            '10' => 'Blekinge län',
//            '20' => 'Dalarnas län',
//            '9' => 'Gotlands län',
//            '21' => 'Gävleborgs län',
//            '13' => 'Hallands län',
//            '23' => 'Jämtlands län',
//            '6' => 'Jönköpings län',
//            '8' => 'Kalmar län',
//            '7' => 'Kronobergs län',
//            '25' => 'Norrbottens län',
//            '12' => 'Skåne län',
//            '1' => 'Stockholms län',
//            '4' => 'Södermanlands län',
//            '3' => 'Uppsala län',
//            '17' => 'Värmlands län',
//            '24' => 'Västerbottens län',
//            '22' => 'Västernorrlands län',
//            '19' => 'Västmanlands län',
//            '14' => 'Västra Götalands ',
//            '18' => 'Örebro län',
//            '5' => 'Östergötlands län',
//            '90' => 'Ospecificerad arbetsort'
//        ];

        $filters = $this->getApiFiltersArray();

        $allFilters = [];

        if(!empty($filters)){
            foreach ($filters as $filter) {
                $filterArray = [];
                $options = $filter->soklista->sokdata;
                $filterName = $filter->soklista->listnamn;
                foreach ($options as $option) {
                    $filterArray[$option->id] = $option->namn;
                }
                $allFilters[$filterName] = $filterArray;
            }
        }

        $company = User::find($companyId);
        if($jobId){
            $job = Job::find($jobId);
            return view('dashboard.company.edit', compact('company', 'job', 'allFilters'));
        } else{
            return view('dashboard.company.create', compact('company', 'allFilters'));
        }
    }

    /**
     * Update an existing job.
     *
     * @param $companyId
     * @param null $jobId
     * @param UpdateJobRequest $request
     * @return View
     */
    public function saveJob($companyId, $jobId = null, UpdateJobRequest $request)
    {
        if($jobId){
            $job = Job::find($jobId);
        } else{
            $job = Job::create();

        }

        $jobId = $job->id;

        $job->title = $request['title'];
        $job->work_place = $request['work_place'];
        $job->type = json_encode($request->input('type'));
        $job->county = $request['county'];
        $job->municipality = $request['municipality'];
        $job->description = $request['description'];
        $job->latest_application_date = $request['latest_application_date'];
        $job->contact_email = $request['contact_email'];
        $job->external_link = $request['external_link'];

        if($request['profiled'] && $request['profiled-end'] && ($job->hasBeenProfiled() || $job->isCurrentlyProfiled()))
        {
            // Set a new end and start date for the profiled job
            $job->profiledJob->end_date = $request['profiled-end'];
            $job->profiledJob->start_date = Carbon::now()->toDateString();

            // If we have a custom title for the profiled job that is not the same as the job's.
            if($request['profiled_title'] && ($request['profiled_title'] != $job->title))
            {
                $job->profiledJob->title = $request['profiled_title'];
            }else
            {
                $job->profiledJob->title = null;
            }

            $job->profiledJob->save();

        } elseif($request['profiled'] && !$job->hasBeenProfiled())
        {
            // Create a new profiled job
            $profiledJob = ProfiledJob::create([
                'company_id' => $companyId,
                'job_id' => $jobId,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => $request['profiled-end']
            ]);

            // If we have a custom title for the profiled job that is not the same as the job's.
            if($request['profiled_title'] && ($request['profiled_title'] != $job->title))
            {
                $profiledJob->title = $request['profiled_title'];
            }

            $profiledJob->save();
        } else{
            $profiledJob = ProfiledJob::where('job_id', $jobId);
            $profiledJob->delete();
        }

        $job->save();

        $request->session()->flash('status', 'Uppdaterat!');

        return($this->editJob($companyId, $jobId));

//        return view('dashboard.company.edit', compact('company', 'job'));
    }

    /**
     * Create a new job.
     *
     * @param $companyId
     * @param UpdateJobRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveNewJob($companyId, UpdateJobRequest $request)
    {
        $company = User::find($companyId);

        $job = $company->jobs()->create([
            'title' => $request['title'],
            'work_place' => $request['work_place'],
            'type' => json_encode($request->input('type')),
            'county' => $request['county'],
            'municipality' => $request['municipality'],
            'description' => nl2br($request['description']),
            'latest_application_date' => $request['latest_application_date'],
            'contact_email' => $request['contact_email'],
            'external_link' => $request['external_link'],
        ]);

        if($request['profiled'])
        {
            // Create a new profiled job
            $profiledJob = ProfiledJob::create([
                'company_id' => $companyId,
                'job_id' => $job->id,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => $request['profiled-end']
            ]);

            // If we have a custom title for the profiled job that is not the same as the job's.
            if($request['profiled_title'] && ($request['profiled_title'] != $job->title))
            {
                $profiledJob->title = $request['profiled_title'];
            }

            $profiledJob->save();
        }


        $job->published_at = Carbon::now();

        $job->save();

        $request->session()->flash('status', 'Sparat! Du kan nu skapa ett nytt jobb om du vill.');

        event(new JobCreated($job, $request));

        return back();

//        return view('dashboard.company.edit', compact('company', 'job'));
    }


    public function getApiFiltersArray()
    {
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);
        $searchOptions = array();

        // län
        $results = $client->get('platsannonser/soklista/lan', [
            'headers' => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ])->getBody()->getContents();
        $results = json_decode($results);
        array_push($searchOptions, $results);

        // yrkesområden
        $results = $client->get('platsannonser/soklista/yrkesomraden', [
            'headers' => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ])->getBody()->getContents();
        $results = json_decode($results);
        $results->soklista->sokdata = $this->addCustomJobTypes($results->soklista->sokdata);

        array_push($searchOptions, $results);
        return $searchOptions;
    }

    private function addCustomJobTypes(array $afJobTypesArray)
    {
        $customJobTypes = array();

        // Övrigt
        $type = new stdClass();
        $type->id = '9000';
        $type->namn = 'Övrigt';
        array_push($customJobTypes, $type);

        // Add all the custom job types
        foreach ($customJobTypes as $type){
            array_push($afJobTypesArray, $type);
        }

        $afJobTypesArray = array_values(array_sort($afJobTypesArray, function ($value) {
            return $value->namn;
        }));

        return $afJobTypesArray;
    }

    public function getNewJobsCountForDays($numDays)
    {
        $counts = [];
        for($i = 0; $i < $numDays; $i++){
            $date = Carbon::today()->addDays(-$i);
            $count = Job::whereRaw('date(published_at) = ?', [$date])->count();

            $dateAndMonthStr = $date->day . "/" . $date->month;
            array_push($counts, [$dateAndMonthStr => $count]);
        }

        $counts = array_reverse($counts);
        return $counts;
    }

    public function getNewUsersCountForDays($numDays)
    {
        $counts = [];
        for($i = 0; $i < $numDays; $i++){
            $date = Carbon::today()->addDays(-$i);
            $count = User::whereRaw('date(created_at) = ?', [$date])->count();

            $dateAndMonthStr = $date->day . "/" . $date->month;
            array_push($counts, [$dateAndMonthStr => $count]);
        }

        $counts = array_reverse($counts);
        return $counts;
    }
}
