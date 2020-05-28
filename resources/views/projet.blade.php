@inject('projets', 'App\Projet')

@extends('layouts.app')

@section('title')
    Projet: {{ $projets::where('id', substr(Request::getPathInfo(), 8))->first()->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Liste des tickets<button id="addTicket" class="btn btn-info pull-right">Ajouter un bug</button></h4>
                    <p class="card-category">Les tickets lié au projet</p>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="filtre">Filtre</label>
                        </div>
                        <select class="custom-select" id="filtre">
                            <option selected value="">All</option>
                            <option value="Ouvert">Ouvert</option>
                            <option value="Fermé">Fermé</option>
                        </select>
                    </div>
                    <div class="material-datatables">
                        <table id="bugs_list" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Attribué à</th>
                                <th>Étiquettes</th>
                                <th>Denière modification</th>
                                <th>Statut</th>
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
            const table = $('#bugs_list').DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                },
                "searching": true,
                "lengthChange": true,
                "ordering": true,
                "processing": true,
                "pageLength": 15,
                "order": [[ 0, "desc" ]],
                "ajax": "/v1/projet/{{$projets::where('id', substr(Request::getPathInfo(), 8))->first()->id}}",
                "columns": [
                    {
                        "data": "id", "render": function (data, type, row) {
                            return data;
                        }
                    },
                    {"data": "title"},
                    {
                        "data": "assignees[0]",
                        "render": function (data, type, row) {
                            if (row.assignees[0]) {
                                return "<img class=\"img rounded\" height=\"30px\" src=\"" + row.assignees[0].avatar_url + "\"> " + row.assignees[0].name;
                            } else {

                                return "";
                            }
                        }
                    },
                    {
                        "data": "labels",
                        "render": function (data, type, row) {
                            if (row.labels) {
                                let txt = "";
                                row.labels.forEach(function (item, index) {
                                    if (item === "Bug")
                                        txt += "<span class=\"badge badge-danger\">" + item + "</span> ";
                                    else if (item === "En cours")
                                        txt += "<span class=\"badge badge-warning\">" + item + "</span> ";
                                    else if (item === "Idée")
                                        txt += "<span class=\"badge badge-info\">" + item + "</span> ";
                                    else if (item === "A tester")
                                        txt += "<span class=\"badge badge-primary\">" + item + "</span> ";
                                    else
                                        txt += "<span class=\"badge badge-success\">" + item + "</span> ";
                                });
                                return txt;
                            } else {
                                return "";
                            }
                        }
                    },
                    {
                        "data": "updated_at",
                        "render": function (data, type, row) {
                            var m = moment(data);
                            m.locale('fr');
                            return m.format('DD MMMM YYYY à HH:mm');
                        }
                    },
                    {
                        "data": "state",
                        "render": function (data, type, row) {
                            if (row.state === "opened") {
                                return "<span class=\"badge badge-success\">Ouvert</span>\n";
                            } else if (row.state === "closed") {
                                return "<span class=\"badge badge-danger\">Fermé</span>\n";
                            } else {
                                return row.state;
                            }
                        }
                    },
                    {
                        "data": null,
                        "defaultContent": "<button class=\"btn btn-info btn-link\"><i class=\"material-icons\">visibility</i><div class=\"ripple-container\"></div></button>",
                        "className": "text-right"
                    }
                ]
            })

            $('#filtre').change(function(){
                table.columns(5).search($(this).val(), true, false).draw();
            })

            $('#bugs_list tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                document.location.href = "/issue/{{$projets::where('id', substr(Request::getPathInfo(), 8))->first()->id }}/" + data.iid;
            } );

            $('#addTicket').click(function () {
                document.location.href = "/new/issue/{{ $projets::where('id', substr(Request::getPathInfo(), 8))->first()->id }}"
            });
        } );
    </script>
@endsection
