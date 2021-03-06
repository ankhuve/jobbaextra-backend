<?php

namespace App\Http\Controllers;

use App\FeaturedCompany;
use App\Http\Requests\StoreCompanyLogo;
use App\Http\Requests\UpdateUserNoteRequest;
use App\Job;
use App\Note;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            $company->paid_until = request('paying-end');
            $company->last_paid = Carbon::now();
            $updateMsg = 'Företaget är nu registrerat som betalande!';

        } else{
            $company->paying = 0;
//            $company->paid_until = Carbon::now()->toDateString();
            $company->paid_until = '0000-00-00';
            $updateMsg = 'Företaget är inte längre registrerat som betalande!';
        }

        $company->save(); // persist changes to company

        $response = array(
            'status' => 'success',
            'msg' => $updateMsg,
            'paying' => $company->paying,
            'paid_until' => $company->paid_until,
            'request' => request()->all()
        );

        return response()->json($response);
//        return back()->with('updated', $updateMsg);

    }


    public function setFeatured($companyId)
    {
        $featuredInRequest = request('featured');
        $company = User::find($companyId);
        $featured = $company->featured();
        $hasBeenFeatured = $company->hasBeenFeatured();

        if(!$featured && $featuredInRequest && !$hasBeenFeatured)
        {
            $newFeatured = FeaturedCompany::create([
                'company_id' => $companyId,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => request('featured-end')
            ]);
            $updateMsg = 'Företaget är nu registrerat som en attraktiv arbetsgivare!';
            $newFeatured->save();
            $featuredId = $newFeatured->id;

        } elseif($featured && !$featuredInRequest){
//            $featured->delete();
            $featured->end_date = Carbon::yesterday()->toDateString();
            $featured->save();
            $featuredId = $featured->id;
            $updateMsg = 'Företaget är inte längre registrerat som en attraktiv arbetsgivare!';

        } elseif($hasBeenFeatured && $featuredInRequest) {
            $prevFeatured = FeaturedCompany::where('company_id', $companyId)->first();
            $prevFeatured->end_date = request('featured-end');
            $prevFeatured->save();
            $featuredId = $prevFeatured->id;
            $updateMsg = 'Företaget är nu en attraktiv arbetsgivare igen!';
        } elseif($featured && $featuredInRequest) {
            $featured->end_date = request('featured-end');
            $featured->save();

            request('featured-end') > Carbon::now() ? $featuredInRequest = 'on' : $featuredInRequest = 0;

            $featuredId = $featured->id;
            $updateMsg = 'Företaget har uppdaterats.';
        } else {
            $updateMsg = 'Företaget har inte uppdaterats.';
        }

        $response = array(
            'status' => 'success',
            'featured' => $featuredInRequest,
            'msg' => $updateMsg,
            'request' => request()->all(),
        );

        if(isset($featuredId)){
            $response['id'] = $featuredId;
        }

        return response()->json($response);
//        return back()->with('updated', $updateMsg);

    }


    public function checkOgImageSize($logo) {
        $minHeight = 200;
        $minWidth = 200;
        list($width, $height) = getimagesize($logo);
        return ( ($width >= $minWidth) && ($height >= $minHeight) );
    }


    /**
     *
     * Handle a logo upload request.
     *
     * @param $companyId
     * @param StoreCompanyLogo $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function setLogo($companyId, StoreCompanyLogo $request)
    {
        $company = User::find($companyId);

        // check if the uploaded logo can be used as og-image
        $sizeCheck = false;
        if($this->checkOgImageSize($request->file('logo'))){
            $sizeCheck = true;
            $company->logo_accepted_as_og_image = true;
            $company->save();
        } else{
            $company->logo_accepted_as_og_image = false;
        }


        $logoStorage = Storage::disk('logos');
        if($company->hasLogo())
        {
            // delete old logo
            $old = $company->logo_path;
            $logoStorage->delete($old);
        }

        $file = $request->file('logo');
        $ext = $file->guessExtension();
        $fileName = time() . '-' . $companyId . '-logo.' . $ext;
        $company->logo_path = $fileName;
        $file->move(public_path() . '/uploads/', $fileName);

        $company->save();

        if($request->ajax())
            return response()->json(['path' => 'uploads/' . $fileName, 'logo' => 1, 'ogImageApproved' => $sizeCheck]);
        return 'success';
    }


    /**
     *
     * Deletes a job.
     *
     * @param $companyId
     * @param $jobId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($companyId, $jobId)
    {
        $job = Job::find($jobId);
        $job->delete();
        return redirect()->route('company', ['company' => $companyId]);
    }

    public function setNote($userId, UpdateUserNoteRequest $request)
    {
        $user = User::find($userId);
        if ($user->note) {
            $user->note->content = $request->get('content');
            $user->note->save();
            $updateMsg = 'Anteckning uppdaterad!';
        }
        else {
            $note = new Note;
            $note->user_id = $userId;
            $note->content = $request->get('content');
            $note->save();
            $updateMsg = 'Anteckning skapad!';
        }

        $response = array(
            'status' => 'success',
            'msg' => $updateMsg,
            'request' => request()->all()
        );

        return response()->json($response);
    }
}
