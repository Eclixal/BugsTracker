@extends('layouts.app')

@section('title')
    Accueil
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h3 class="card-title ">Bienvenue sur Bugs Tracker</h3>
                    <p class="card-category">Application pour le report des bugs</p>
                </div>
                <div class="card-body">
                    <br/>
                    <p>Bonjour à vous !</p>
                    <p>Cette application a été mise en place afin de faciliter le travail des développeurs. Cette application est simple, elle permet de voir les bugs à
                        corriger et elle permet aussi de créer un ticket lorsqu'un bug est révélé. Un ticket est assez représentatif vous pouvez suivre son évolution,
                        ainsi connaître qui se charge de la correction si vous n'êtes pas certain du projet pour lequel vous devez report un bug, demander à un développeur
                        de vous aiguiller.</p>
                    <p class="float-right">Merci pour votre collaboration :)</p>
                </div>
            </div>
        </div>

    </div>
@endsection
