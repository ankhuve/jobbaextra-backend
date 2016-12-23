<?php

namespace App\Listeners;

use App\Events\JobCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook;

class PostJobOnFacebook
{

    protected $fb;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Handle the event.
     *
     * @param  JobCreated  $event
     * @return void
     */
    public function handle(JobCreated $event)
    {


        if(App::isLocal()){
            $link = 'https://jobbiskola.se';
        } else{
            $job = $event->job;
            $link = env('URL_FRONT') . '/jobb/' . $job->id . '/' . str_slug($job->title);
        }

        // make the $params
        $params = array(
            "access_token" => session('fb_page_access_token'),
            "message" => "Nytt jobb på Jobbiskola.se!",
            "link" => $link,
        );

        $this->post($params, $event);

    }

    public function post(array $params, $event)
    {
        // Post to Facebook page
        try {
            $this->fb->post(env('FACEBOOK_PAGE_ID') . '/feed', $params);
            $event->request->session()->flash('message', 'Postade jobbannons på Facebook!');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $event->request->session()->flash('error', 'Något gick fel vid Facebook-postningen! Prova att logga ut och in igen.');
        }
    }
}
