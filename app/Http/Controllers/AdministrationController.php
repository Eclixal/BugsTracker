<?php

namespace App\Http\Controllers;

use App\Projet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ixudra\Curl\Facades\Curl;

class AdministrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        return view('administration');
    }

    public function users() {
        return response()->json(['data' => DB::table('users')->distinct()->get()]);
    }

    public function delete($id) {
        return DB::table('users')->where('id', '=', $id)->delete();
    }

    public function ajout(Request $request) {
        if ($request->get('pseudo') != null) {
            $pseudo = $request->get('pseudo');
            if ($user = DB::table('users')->where('username', "=", $pseudo)->first() == null) {
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
                $password = substr( str_shuffle( $chars ), 0, 16 );
                User::create([
                    'username' => $pseudo,
                    'password' => Hash::make($password),
                ]);
                return response()->json(["password" => $password, "username" => $pseudo]);
            } else
                return response()->json(["error" => "Un compte avec ce pseudo existe déjà !"], 500);
        } else
            return response()->json(["error" => "Un pseudo doit être saisie !"], 500);
    }

    public function projets() {
        return response()->json(["data" => Projet::all()]);
    }

    public function deleteProjet($id) {
        return DB::table('projets')->where('id', '=', $id)->delete();
    }

    public function ajoutProjet(Request $request) {
        if ($request->get('id') != null) {
            $id = $request->get('id');
            if ($user = DB::table('projets')->where('projet_id', "=", $id)->first() == null) {
                $response = Curl::to(env("GITLAB_URL") . '/api/v4/projects/' . $id)
                    ->withHeader('Authorization: Bearer ' . env('GITLAB_TOKEN'))
                    ->asJson(true)
                    ->get();

                if (isset($response) && array_key_exists("id", $response)) {
                    $projet = new Projet();
                    $projet->projet_id = $id;
                    $projet->name = $response['name'];
                    $projet->save();
                    return response()->json(["name" => $response['name']]);
                } else {
                    return response()->json(["error" => "Ce projet n'existe pas !"], 500);
                }
            } else
                return response()->json(["error" => "Ce projet est déjà présent !"], 500);
        } else
            return response()->json(["error" => "Un ID de projet doit être renseigné"], 500);
    }

}
