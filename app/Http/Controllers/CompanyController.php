<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            $company->paid_until = Carbon::parse(request('paid-until'));
            $company->last_paid = Carbon::now();
            $updateMsg = 'Företaget är nu registrerat som betalande!';

        } else{
            $company->paying = 0;
            $company->paid_until = Carbon::now();
            $updateMsg = 'Företaget är inte längre registrerat som betalande!';

        }

        $company->save();
        $response = array(
            'status' => 'success',
            'msg' => $updateMsg,
            'request' => request()->all()
        );

        return response()->json($response);
//        return back()->with('updated', $updateMsg);

    }
}
