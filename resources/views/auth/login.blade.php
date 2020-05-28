<!doctype html>
<html lang="fr">
    <head>
        <title>Bugs Tracker | Elenox</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href="{{ asset('css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
    </head>
    <body>
        <div class="wrapper wrapper-full-page" style="    background-image: url({{ asset('img/background.jpg') }});background-size: cover;background-position: top center;">
            <div class="container container-center">
                <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto d-flex align-content-center">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h2 class="card-title text-center">Elenox</h2>
                            <p class="card-category text-center">Connexion a l'application Bugs Tracker</p>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nom d'utilisateur</label>
                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="off" autofocus>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Mot de passe</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success pull-right">
                                        Me connecter<div class="ripple-container"></div>
                                    </button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="{{ asset('js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('js/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script src="{{ asset('js/plugins/sweetalert2.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/plugins/bootstrap-tagsinput.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
        <script src="{{ asset('js/material-dashboard.js?v=2.1.2') }}" type="text/javascript"></script>
    </body>
</html>
