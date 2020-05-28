@inject('projets', 'App\Projet')
    <!doctype html>
<html lang="fr">

    <head>
        <title>Bugs Tracker | Elenox</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link href="{{ asset('css/material-dashboard.css?v=2.1.2') }}" rel="stylesheet" />
    </head>

    <body>
        <div class="wrapper ">
            <div class="sidebar" data-color="azure" data-background-color="white" data-image="{{ asset('img/sidebar.jpg') }}">
                <div class="logo"><a href="https://bugs.elenox.net" class="simple-text logo-normal">
                        Bugs Tracker
                    </a></div>
                <div class="sidebar-wrapper">
                    <ul class="nav">
                        <li class="nav-item @if(Request::is('/')) active @endif">
                            <a class="nav-link" href="/">
                                <i class="material-icons">dashboard</i>
                                <p>Accueil</p>
                            </a>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item @if(Request::is('administration')) active @endif">
                                <a class="nav-link" href="/administration">
                                    <i class="material-icons">fingerprint</i>
                                    <p>Administration</p>
                                </a>
                            </li>
                        @endif
                        @foreach  ($projets::all() as $projet)
                            <li class="nav-item @if(Request::is("projet/" . $projet->id)) active @endif">
                                <a class="nav-link" href="/projet/{{$projet->id}}">
                                    <i class="material-icons">explore</i>
                                    <p>{{$projet->name}}</p>
                                </a>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                <i class="material-icons">logout</i>
                                <p>Me deconnecter</p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                    <div class="container-fluid">
                        <div class="navbar-wrapper">
                            <a class="navbar-brand" href="javascript:;">@yield('title')</a>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                        </button>
                    </div>
                </nav>
                <div class="content">
                    <div class="container-fluid">
                            @yield('content')
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="copyright float-right">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script>, BugsTracker. Tous droits réservés à Alexandre JOUSSET.
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('js/core/popper.min.js') }}"></script>
        <script src="{{ asset('js/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/plugins/bootstrap-tagsinput.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
        <script src="{{ asset('js/material-dashboard.js?v=2.1.2') }}" type="text/javascript"></script>
        @yield('scripts')
    </body>
</html>
