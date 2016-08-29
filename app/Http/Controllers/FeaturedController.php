<?php

namespace App\Http\Controllers;

use App\FeaturedCompany;
use App\Http\Requests\UpdateFeaturedCompanyRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class FeaturedController extends Controller
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
     * Show all of the featured companies.
     *
     * @param $company
     * @return View
     */
    public function all()
    {
        $companies = FeaturedCompany::where('end_date', '>', \Carbon\Carbon::now())->get();

        return view('dashboard.featured', compact('companies'));
    }

    /**
     *
     * Edit a featured company's description.
     *
     * @param $companyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($companyId)
    {
        $featured = User::find($companyId)->featured();
//        dd($featured);
        return view('dashboard.featured.edit', compact('featured'));
    }

    public function save($companyId, UpdateFeaturedCompanyRequest $request)
    {
        $featured = User::find($companyId)->featured();

        $featured->title = $request['title'];
        $featured->subtitle = $request['subtitle'];
        $featured->description = $request['description'];

        $featured->save();

        $request->session()->flash('status', 'Uppdaterat!');

        return redirect(route('editFeatured', $companyId));
    }


    public function setFeatured($companyId)
    {
        $featuredInRequest = request('featured');
        $company = User::find($companyId);
        $featured = $company->featured();

        if(!$featured && $featuredInRequest)
        {
            $newFeatured = FeaturedCompany::create([
                'company_id' => $companyId,
                'start_date' => Carbon::now()->toDateString(),
                'end_date' => request('featured-end')
            ]);
            $updateMsg = 'Företaget är nu registrerat som en attraktiv arbetsgivare!';
            $newFeatured->save();

        } elseif($featured && !$featuredInRequest){
            $featured->delete();
            $featured->end_date = Carbon::now()->toDateString();
            $updateMsg = 'Företaget är inte längre registrerat som en attraktiv arbetsgivare!';

        } else{
            $updateMsg = 'Företaget har inte uppdaterats.';
        }

        $response = array(
            'status' => 'success',
            'featured' => $featuredInRequest,
            'msg' => $updateMsg,
            'request' => request()->all()
        );

        return response()->json($response);
//        return back()->with('updated', $updateMsg);

    }


    /**
     *
     * Handle an image upload request.
     *
     * @param $companyId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function uploadImage($companyId, Request $request)
    {
        if ($request->file('photo')->isValid()) {

            // prepare for upload
            $disk = Storage::disk('s3');
            $file = $request->file('photo');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '-' . $originalName;
            $pathToUploadsFolder = 'featured-companies/';

            // Ladda upp filen
            $disk->put($pathToUploadsFolder . $fileName, file_get_contents($file->getRealPath()), 'public');

            // Hämta URL för filen
            $url = $disk->url($pathToUploadsFolder . $fileName);

            // allt gick bra!
            $fileData = [
                'url' => $url,
                'path' => $file->getPath() . '/' . $file->getFilename(),
                'originalName' => $file->getClientOriginalName(),
                'mimetype' => $file->getMimeType()
            ];
            if($request->ajax()){
                return response()->json($fileData);
            }
            return $fileData;

        } else{
            // failed to validate upload, broken file?
            return false;
        }

    }
}
