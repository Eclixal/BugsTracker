@inject('projets', 'App\Projet')

@extends('layouts.app')

@section('title')
    Nouveau ticket pour le projet: {{ $projets::where('id', substr(Request::getPathInfo(), 11))->first()->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Création d'un ticket</h4>
                    <p class="card-category">Le maximum de détails nous permettra de résoudre le problème plus rapidement.</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="/v1/new/issue/{{ $projets::where('id', substr(Request::getPathInfo(), 11))->first()->id }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Titre</label>
                                    <input name="titre" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="togglebutton">
                                    <label>
                                        <input name="bug" type="checkbox" checked>
                                        <span class="toggle"></span>
                                        est un bug ?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mettre un maximum de détails</label>
                                        <textarea name="description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Créer</button>
                        <button type="button" onclick="history.back()" class="btn btn-danger pull-right">Annuler</button>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

@endsection
