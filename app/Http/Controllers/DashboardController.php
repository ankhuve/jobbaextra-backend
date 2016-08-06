<?php

namespace App\Http\Controllers;

use App\FeaturedCompany;
use App\Job;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\View;

class DashboardController extends Controller
{

    protected $auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 2)->get(); // only get users registered as company
//        $users = User::all();

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

    /**
     * Show all of the featured companies.
     *
     * @param $company
     * @return View
     */
    public function featured()
    {
        $companies = FeaturedCompany::all();

        return view('dashboard.featured', compact('companies', 'companies'));
    }
}
