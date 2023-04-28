@extends ('layouts.layout')


@section('HeadContent')
<title> Dokumente </title>
@endsection


@section('Navbar')
<!-- Navigation-->
<li class="nav-item activeLink transition mx-4">
    <a class="nav-link fs-4 p-0" href="/documents">Dokumente</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/editor">Editor</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/help">Hilfe</a>
</li>

@if(Auth::User()->role == "Admin")
<li class="nav-item mx-4 dropdown">
    <a class="nav-link fs-4 p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Admin
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item transition" href="/admin"><i class="bi bi-people-fill me-2"></i>Nutzer-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api"><i class="bi bi-broadcast-pin me-2"></i>API-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api/logs"><i class="bi bi-journals me-2"></i>API-Logs</a></li>
    </ul>
</li>
@endif

@endsection


@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->

<div class="row justify-content-center">

    <script>
        $(document).ready(function() {
            $('#documentTable').DataTable({
                scrollY: "388px",
                scrollX: "auto",
                info: false,
                order: [[0, 'asc']],

                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/de-DE.json'
                },

                ajax: {
                    url: '/table/getDocumentsTable',
                    dataSrc: "",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                }, 

                "createdRow": function(row) {
                    $(row).addClass( 'showAction' );
                }
            });
        });
    </script>

    <!-- Tabellen Abschnitt -->
    <div class="col-9 mt-4">

        <div class="tableHead">
                <div class="row justify-content-around">
                    <div class="col-auto">
                        <i class="bi bi-file-earmark-code"></i>
                        Dokumente
                    </div>
                    @if(Auth::user()->role == "Admin")
                    <div class="col-auto">
                        <i class="bi bi-people-fill"></i>
                        Aller Redakteure
                    </div>
                    @endif

                    @if(Auth::user()->role == "Redakteur")
                    <div class="col-auto">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->username }}
                    </div>
                    @endif
                </div>
            </div>

        <div class="row mx-auto" style="max-width:85vw;">

            <!-- Tabelle Init, unterschiedlich je nach Rolle -->
            <table class="tablestyle" id="documentTable">

                @if(Auth::user()->role == "Admin")
                <colgroup>
                    <col style="width:25%">
                    <col style="width:20%">
                    <col style="width:20%">
                    <col style="width:15%">
                    <col style="width:20%">
                </colgroup>
                @endif       

                @if(Auth::user()->role == "Redakteur")
                <colgroup>
                    <col style="width:25%">
                    <col style="width:25%">
                    <col style="width:25%">
                    <col style="width:25%">
                </colgroup>
                @endif
                
                <thead>
                    <tr>
                        <th>Dokument</th>
                        @if(Auth::user()->role == "Admin")
                        <th>Besitzer</th>
                        @endif
                        <th>Status (ID)</th>
                        <th>Erstellt am</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>

            </table>

        </div>
    </div>

</div>

@endsection