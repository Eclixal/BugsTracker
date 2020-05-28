<?php

namespace App\Http\Controllers;

use App\Projet;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class ProjetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('projet');
    }

    public function get($id) {
        $projet = Projet::where('id', $id)->first();
        if ($projet != null) {
            $issues = array();

            $pages = Curl::to(env("GITLAB_URL") . '/api/v4/projects/'.$projet->projet_id.'/issues?per_page=100&page=2')
                ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                ->asJson(true)
                ->withResponseHeaders()
                ->returnResponseObject()
                ->get();

            for ($i = 1; $i <= $pages->headers['X-Total-Pages']; $i++) {
                $response = Curl::to(env("GITLAB_URL") . '/api/v4/projects/'.$projet->projet_id.'/issues?per_page=100&page=' . $i)
                    ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                    ->asJson(true)
                    ->get();

                    array_push($issues, ...$response);
            }

            return response()->json(['data' => $issues]);
        } else {
            abort(500);
        }
    }
}
