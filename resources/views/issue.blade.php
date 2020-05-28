@extends('layouts.app')

@section('title')
    Ticket n°{{$issue['id']}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">{{$issue['title']}}
                        @if($issue['state'] == 'opened')
                            <button id="addCompte" class="btn btn-success pull-right">OUVERT</button>
                        @else
                            <button id="addCompte" class="btn btn-danger pull-right">FERME</button>
                        @endif
                    </h4>
                    <p class="card-category">Crée le : {{ date('d F Y à H:i', strtotime($issue['created_at'] )) }}</p>
                    <p class="card-category">Dernière mise à jour : {{ date('d F Y à H:i', strtotime($issue['updated_at'])) }} </p>
                </div>
                <div class="card-body">
                    <p class="card-description">
                        {{ $issue['description'] }}
                    </p>

                    <div>
                        <h6 class="text-black-50" style="margin-bottom: 30px">Commentaires :</h6>
                        @if (count($notes) > 0)

                            @foreach ($notes as $note)
                                @if($loop->index % 2 != 0)
                                    <div class="col-md-11 card-header card-header-commentaire float-right">
                                        <h6 class="card-category">{{ $note['author']['name'] }} ({{ date('d/m/Y à H:i', strtotime($note['created_at'])) }}) </h6>
                                        <p class="card-description">{{ $note['body'] }}</p>
                                    </div>
                                @else
                                    <div class="col-md-11 card-header card-header-commentaire float-left">
                                        <h6 class="card-category">{{ $note['author']['name'] }} ({{ date('d/m/Y à H:i', strtotime($note['created_at'])) }}) </h6>
                                        <p class="card-description">{{ $note['body'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-md-10 card-header card-header-commentaire">
                                <h6 class="card-category">
                                    Aucun commentaire sur ce ticket
                                </h6>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if(isset($user['id']))
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img" src="{{ $user['avatar_url'] }}" />
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-header card-header-info">
                            <h6 class="card-category text-white">Ce ticket est attribué à</h6>
                            <h4 class="card-title">{{ $user['name'] }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-description">
                                {{ $user['bio'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img" src="{{ asset('img/avatar.png') }}" />
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-header card-header-info">
                            <h6 class="card-category text-white">Ce ticket n'est pas encore attribué</h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('scripts')
@endsection
