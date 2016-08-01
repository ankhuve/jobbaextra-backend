<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class CompanyController extends Controller
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


    public function setPaying($companyId)
    {
        $isPaying = request('paying');
        $company = User::find($companyId);

        if($isPaying)
        {
            $company->paying = 1;
            $updateMsg = 'Företaget är nu registrerat som betalande!';

        } else{
            $company->paying = 0;
            $updateMsg = 'Företaget är inte längre registrerat som betalande!';

        }

        $company->save();
        return back()->with('updated', $updateMsg);

    }
}
