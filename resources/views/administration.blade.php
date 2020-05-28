@extends('layouts.app')

@section('title')
    Administration
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Utilisateurs<button id="addCompte" class="btn btn-info pull-right">Ajouter un compte</button></h4>
                    <p class="card-category">Les utilisateurs ayant un accès a bugs tracker</p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="users" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Pseudo</th>
                                <th>Administrateur</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Projets<button id="addProjet" class="btn btn-info pull-right">Ajouter un projet</button></h4>
                    <p class="card-category">Les projets ayant activé le mode tracker</p>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="projets" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>ID Projet</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            const table = $('#users').DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                },
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "processing": true,
                "pageLength": 5,
                "ajax": "/v1/users",
                "columns": [
                    {
                        "data": "id", "render": function (data, type, row) {
                            return '# ' + data;
                        }
                    },
                    {"data": "username"},
                    {
                        "data": "is_admin", "render": function (data, type, row) {
                            return (data === 1) ? 'Oui' : 'Non';
                        }
                    },
                    {
                        "data": null,
                        "defaultContent": "<button class=\"btn btn-danger btn-link\"><i class=\"material-icons\">close</i><div class=\"ripple-container\"></div></button>",
                        "className": "text-right"
                    }
                ]
            });

            $('#users tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                Swal.fire({
                    title: 'Êtes vous sûr?',
                    text: "Cette opération est irreversible et supprimera le compte " + data.username,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText : 'NON',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        $.ajax({
                            url: '/v1/users/' + data.id,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            }
                        }).done(function(response){
                            console.log(response.data);
                            Swal.fire({
                                icon: 'success',
                                title: 'Compte supprimé...',
                                text: 'Le compte ' + data.username + " à été supprimé !"
                            });
                            table.ajax.reload();
                        }).fail(function () {
                            Swal.fire('Une erreur est survenue !')
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            } );

            $('#addCompte').click(function () {
                Swal.fire({
                    title: 'Pseudo du compte a créer',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Créer',
                    showLoaderOnConfirm: true,
                    preConfirm: function(pseudo) {
                        $.ajax({
                            url: '/v1/users',
                            type: 'PUT',
                            data: {
                                "pseudo": pseudo,
                                "_token": "<?php echo e(csrf_token()); ?>",
                            }
                        }).done(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Compte ' + response.username + ' créé !',
                                html: 'Le compte ' + response.username + ' à été crée ! Le mot de passe est : <b>' + response.password + '</b>'
                            });
                            table.ajax.reload();
                        }).fail(function (response) {
                            Swal.fire({
                                icon: "error",
                                title: 'Une erreur est survenue !',
                                text: response.responseJSON.error
                            });
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            });

            const tableProjet = $('#projets').DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                },
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "processing": true,
                "pageLength": 15,
                "ajax": "/v1/projets",
                "columns": [
                    {
                        "data": "id", "render": function (data, type, row) {
                            return '# ' + data;
                        }
                    },
                    {"data": "name"},
                    {"data": "projet_id"},
                    {
                        "data": null,
                        "defaultContent": "<button class=\"btn btn-danger btn-link\"><i class=\"material-icons\">close</i><div class=\"ripple-container\"></div></button>",
                        "className": "text-right"
                    }
                ]
            });

            $('#projets tbody').on( 'click', 'button', function () {
                var data = tableProjet.row( $(this).parents('tr') ).data();
                Swal.fire({
                    title: 'Êtes vous sûr?',
                    text: "Cette opération est irreversible et supprimera le projet " + data.name,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText : 'NON',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        $.ajax({
                            url: '/v1/projets/' + data.id,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            }
                        }).done(function(response){
                            Swal.fire({
                                icon: 'success',
                                title: 'Projet supprimé...',
                                text: 'Le projet ' + data.name + " à été supprimé !"
                            });
                            tableProjet.ajax.reload();
                        }).fail(function () {
                            Swal.fire('Une erreur est survenue !')
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            } );

            $('#addProjet').click(function () {
                Swal.fire({
                    title: 'ID du compte a créer',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Créer',
                    showLoaderOnConfirm: true,
                    preConfirm: function(id) {
                        $.ajax({
                            url: '/v1/projets',
                            type: 'PUT',
                            data: {
                                "id": id,
                                "_token": "<?php echo e(csrf_token()); ?>",
                            }
                        }).done(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Projet ' + response.name + ' créé !',
                                html: 'Le projet ' + response.name + ' à été crée !'
                            });
                            tableProjet.ajax.reload();
                        }).fail(function (response) {
                            Swal.fire({
                                icon: "error",
                                title: 'Une erreur est survenue !',
                                text: response.responseJSON.error
                            });
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            });
        } );
    </script>
@endsection

