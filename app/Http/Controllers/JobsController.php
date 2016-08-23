<?php

namespace App\Http\Controllers;

use App\Job;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class JobsController extends Controller
{
    protected $auth;

    /**
     * Create a new Jobs controller instance.
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();

        $companies = User::where('role', 2)
            ->orWhere('role', 3)
            ->get()
            ->sortBy('name'); // only get users registered as company

        return view('dashboard.jobs', compact('jobs', 'companies'));
    }

    public function changeJobOwner(Requests\UpdateJobOwnerRequest $request)
    {
        $jobId = $request['jobId'];
        $userId = $request['company'];
        $job = Job::find($jobId);

        $oldOwner = $job->user_id;
        $newOwner = User::find($userId)->name;

        $job->user_id = $userId;
        $job->save();

        if($request->ajax()){
            $response = array(
                'status' => 'success',
                'jobId' => $jobId,
                'oldOwner' => $oldOwner,
                'newOwnerName' => $newOwner,
                'newOwnerId' => $userId
            );
            return response()->json($response);
        }

        return 'Uppdaterat.';
    }

    /**
     * Show a company's page with all of their created jobs.
     *
     * @param $company
     * @return View
     */
//    public function job($jobId)
//    {
//        $jobs = Job::where('user_id', $companyId)->get(); // get the company's job ads
//        $company = User::find($companyId);
//
//        return view('dashboard.company', compact('jobs', 'company'));
//    }
}
