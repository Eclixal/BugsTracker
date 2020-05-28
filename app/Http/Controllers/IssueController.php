<?php

namespace App\Http\Controllers;

use App\Projet;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $projet, $id)
    {
        $projet = Projet::where('id', $projet)->first();
        if ($projet != null) {

            $response = Curl::to(env("GITLAB_URL") . '/api/v4/projects/'.$projet->projet_id.'/issues/' . $id)
                ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                ->asJson(true)
                ->get();
            if (!isset($response['message'])) {
                $user = "";
                $note = Curl::to(env("GITLAB_URL") . "/api/v4/projects/".$projet->projet_id."/issues/".$response['iid']."/notes")
                    ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                    ->asJson(true)
                    ->get();

                if (isset($response['assignee'])) {
                    $user = Curl::to(env("GITLAB_URL") . '/api/v4/users/'.$response['assignee']['id'])
                        ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                        ->asJson(true)
                        ->get();

                    return view('issue', ['issue' => $response, 'user' => $user, 'notes' => $note]);
                } else
                    return view('issue', ['issue' => $response, 'user' => $user, 'notes' => $note]);

            } else {
                abort(404);
            }

        } else {
            abort(500);
        }
    }

    public function new(Request $request, $projet) {
        $projet = Projet::where('id', $projet)->first();
        if ($projet != null) {
            return view('newissue');
        } else {
            abort(500);
        }
    }

    public function add(Request $request, $projet) {
        $projet = Projet::where('id', $projet)->first();
        if ($projet != null) {
            if ($request->get("bug") == 'on') {
                $titre = "[BUG] " . $request->get("titre") . " (by " . auth()->user()->getName() . ")";
            } else {
                $titre = "[IDEE] " . $request->get("titre") . " (by " . auth()->user()->getName() . ")";
            }
            $description = $request->get('description');
            $response = Curl::to(env("GITLAB_URL") . '/api/v4/projects/'.$projet->projet_id.'/issues')
                ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                ->withData( array( 'title' => $titre,
                    'description' => $description) )
                ->asJson()
                ->post();

            if (isset($response->iid)) {
                return redirect('/issue/'.$projet->id.'/' . $response->iid);
            } else {
                abort(500);
            }
        } else {
            abort(500);
        }
    }
}
