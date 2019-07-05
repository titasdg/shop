<?php

namespace App\Http\Controllers;

use Facebook\Authentication\AccessToken;
use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{

    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            if (is_string('token')) {
                $this->defaultAccessToken = new AccessToken('token');}
            $fb->setDefaultAccessToken('zzz');
            $this->api = $fb;
            return $next($request);
        });
    }



    public function publishToPage(Request $request){

        $page_id =1073065322880430;
        try {
            $post = $this->api->post('/'.$page_id .'/feed', array('message' => $request->message),'zzzz');
        $post = $post->getGraphNode()->asArray();

        dd($post);
        redirect('/');

    } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

}
