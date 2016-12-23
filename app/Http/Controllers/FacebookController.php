<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook;

class FacebookController extends Controller
{

    protected $fb;

    public function __construct(LaravelFacebookSdk $fb) {
        $this->fb = $fb;
        $this->middleware(['auth', 'guest']);
    }

    public function index()
    {
        $pages = [];
        $currentPage = [];

        // Send an array of permissions to request
        $login_url = $this->fb->getLoginUrl(['email', 'publish_actions', 'publish_pages', 'manage_pages']);

        if(session('fb_user_access_token')){
            try{
                // Get the pages where the logged in user is admin
                $response = $this->fb->get('me/accounts', session('fb_user_access_token'));
                $pages = $response->getGraphEdge()->asArray();

                foreach ($pages as $page) {
                    // Find the right page to post to
                    if($page['id'] === env('FACEBOOK_PAGE_ID')){
                        Session::put('fb_page_access_token', (string) $page['access_token']);
                        $currentPage = $page;
                    }
                }
            } catch(Facebook\Exceptions\FacebookSDKException $e){
                dd($e->getMessage());
            }
        }

        $permissions = $this->makePermissionsChecklist($page);

        return view('auth.facebook-login', compact('login_url', 'pages', 'permissions'));
    }

    private function makePermissionsChecklist(array $page){

        $createContentAccess = false;

        if(!empty($page)){
            foreach ($page['perms'] as $perm){
                if($perm == "CREATE_CONTENT"){
                    $createContentAccess = true;
                }
            }
        }

        $permissions = [
            [
                'name' => 'Användaråtkomst',
                'access' => session('fb_user_access_token') ? true : false
            ],
            [
                'name' => 'Sidåtkomst',
                'access' => session('fb_page_access_token') ? true : false
            ],
            [
                'name' => 'Publiceringsåtkomst',
                'access' => $createContentAccess
            ]
        ];

        return $permissions;
    }

    public function callback()
    {
        // Obtain an access token.
        try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        // Access token will be null if the user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (! $token) {
            // Get the redirect helper
            $helper = $this->fb->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }

        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->fb->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }

        $this->fb->setDefaultAccessToken($token);

        // Save for later
        Session::put('fb_user_access_token', (string) $token);

        $activePageName = $this->getPageToken();

        // Spara användarens namn i sessionen
        Session::put('fb_user_name', $activePageName);

        return redirect(route('fbLogin'))->with('message', 'Loggade in på Facebook som ' . $activePageName . '!');
    }

    public function getPageToken()
    {
        try{
            // Get the pages where the logged in user is admin
            $response = $this->fb->get('me/accounts', session('fb_user_access_token'));
            $pages = $response->getGraphEdge()->asArray();

            foreach ($pages as $page) {
                // Find the right page to post to
                if($page['id'] === env('FACEBOOK_PAGE_ID')){
                    Session::put('fb_page_access_token', (string) $page['access_token']);
                    return($page['name']);
                }
            }
        } catch(Facebook\Exceptions\FacebookSDKException $e){
            dd($e->getMessage());
        }
    }
}