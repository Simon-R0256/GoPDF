@extends ('layouts.layout')

@section('HeadContent')
<title>API-Logs</title>
@endsection

@section('Navbar')
<!-- Navigation-->
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/documents">Dokumente</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/editor">Editor</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/help">Hilfe</a>
</li>

<li class="nav-item mx-4 activeLink dropdown">
    <a class="nav-link fs-4 p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Admin
    </a>
    <ul class="dropdown-menu">
       <li><a class="dropdown-item transition" href="/admin"><i class="bi bi-people-fill me-2"></i>Nutzer-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api"><i class="bi bi-broadcast-pin me-2"></i>API-Verwaltung</a></li>
        <li><a class="dropdown-item activeLink transition" href="/admin/api/logs"><i class="bi bi-journals me-2"></i>API-Logs</a></li>
    </ul>
</li>

@endsection


@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->

<div class="row justify-content-evenly">

    <!--Bilder Link-->
    <div class="col-xl-2 mt-4 align-self-center">
        <div class="row justify-content-center">

            <div class="col-auto">
                <a href="/admin/api"> <img class="img-link" style="width:100%;max-width:280px"
                        src="{{ asset('Bilder_WebApp/API-link2.png') }}" alt="Api Link"> </a>
            </div>

        </div>
    </div>


    <!-- API Log Tabelle -->
    <script>
    $(document).ready(function() {
        $('#logTable').DataTable({
            scrollY: "388px",
            scrollX: "auto",
            info:false,

            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/de-DE.json'
            },

            order: [[0, 'desc']],
        });
    });
    </script>

    <div class="col-xl-5 mt-4 p-0">
        <div style="max-width:85vw" class="row mx-auto">

            <div class="tableHead">
                <i class="bi bi-journals"></i>
                API-Logs
            </div>

            <!--Tabelle-->
            <table class="tablestyle" id="logTable">

                <colgroup>
                    <col style="width:25%">
                    <col style="width:25%">
                    <col style="width:25%">
                    <col style="width:25%">
                </colgroup>

                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Key-Besitzer</th>
                        <th>Request</th>
                        <th>Dokument</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td style="white-space:nowrap;">
                        <span style="display:none;">{{$log->created_at}}</span>
                        {{$log->created_at->format('d.m.Y (H:i)')}}
                    </td>
                    <td>{{$log->name}}</td>
                    <td>{{$log->requestType}}</td>
                    <td>{{$log->document}}</td>
                </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>


    <!-- API Statistik Tabelle -->
    <script>
    $(document).ready(function() {
        $('#apiTable').DataTable({
            scrollY: "388px",
            scrollX: "auto",
            info:false,

            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/de-DE.json'
            },

            order: [[1, 'desc']],
        });
    });
    </script>

    <div class="col-xl-4 mt-4 p-0">
        <div style="max-width:85vw" class="row mx-auto">

            <div class="tableHead">
                <i class="bi bi-list-ol"></i>
                Aufruf-Statistik
            </div>

            <!-- Tabelle -->
            <table class="tablestyle" id="apiTable">
                
                <colgroup>
                    <col style="width:65%">
                    <col style="width:35%">
                </colgroup>

                <thead>
                    <tr>
                        <th>Dokument</th>
                        <th>Aufrufe</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($documents as $document)
                <tr>
                    <td>{{$document->document_name}}</td>
                    <td>{{$document->call}}
                        @isset($document->last_Call)
                        <span style="font-size:14px;position:relative;bottom:2px">
                            ({{ date('d/m/Y', strtotime($document->last_Call)) }})
                        </span>
                        @endisset
                    </td>
                </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection