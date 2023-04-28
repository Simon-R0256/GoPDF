@extends ('layouts.layout')

@section('HeadContent')
<title>Key-Verwaltung</title>
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
        <li><a class="dropdown-item activeLink transition" href="/admin/api"><i class="bi bi-broadcast-pin me-2"></i>API-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api/logs"><i class="bi bi-journals me-2"></i>API-Logs</a></li>
    </ul>
</li>

@endsection


@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->

<div class="row justify-content-evenly">

    <!--Bilder Link-->
    <div class="col-xl-2 mt-3 align-self-center">
        <div class="row justify-content-center">

            <div class="col-auto">
                <a href="/admin"> <img class="img-link" style="width:100%;max-width:280px"
                        src="{{ asset('Bilder_WebApp/User-link.png') }}" alt="User Link"> </a>
            </div>

        </div>
    </div>

    <!-- Aktionen Box -->
    <div class="col-xl-3">
        <div class="row justify-content-center">

            <!-- "Keys Generieren" Box-->
            <div class="col-12-xl mx-2 mt-3 contentBorder boxSize">

                <!-- Überschrift-->
                <div class="row mt-3">
                    <div class="col-auto contentHead contentBorder">
                        API-Keys Generieren
                    </div>
                </div>

                <!--Form start-->
                <form id="keyCreateForm">

                    <!--Datum Feld-->
                    <div class="row mt-3">
                        <div class="col input-group input-group-lg">
                            <span class="input-group-text">Gültig bis:</span>
                            <input class="form-control form-control-lg boxSize" type="date" id="keyDate"
                                required>
                        </div>
                    </div>

                    <!-- Info Alert-->
                    <div class="row mt-3">
                        <div class="col alert alert-secondary text-center p-2 mx-3">
                            Der Key selber ist nicht wählbar und wird automatisch generiert
                        </div>
                    </div>

                    <!--Submit Button-->
                    <div class="row text-center mt-2 mb-3">
                        <div class="col">
                            <input class="btn btnstyle btnstyle-green text-center" type="submit" value="Generieren">
                        </div>
                    </div>

                </form>

            </div>


            <!-- "Keys Löschen" Box-->
            <div class="col-12-xl mx-2 mt-3 contentBorder boxSize">

                <!-- Überschrift-->
                <div class="row mt-3">
                    <div class="col-auto contentHead contentBorder">
                        API-Keys Löschen
                    </div>
                </div>

                <!--Form start-->
                <form id="keyDeleteForm">

                    <!--Text-Feld-->
                    <div class="row mt-3">
                        <div class="col">
                            <input class="form-control form-control-lg boxsize" id="keyTextField" type="text"
                                placeholder="Key" required>
                        </div>
                    </div>

                    <!-- Info Alert-->
                    <div class="row mt-3">
                        <div class="col alert alert-secondary text-center p-2 mx-3">
                            Klicken auf die Tabelle fügt automatisch den Key in das Textfeld ein
                        </div>
                    </div>

                    <!--Submit Button-->
                    <div class="row text-center mt-2 mb-3">
                        <div class="col">
                            <input class="btn btnstyle btnstyle-red text-center" type="submit" value="Löschen">
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <!--Api-Key Tabelle-->
    <script>
    $(document).ready(function() {
        $('#keyTable').DataTable({
            scrollY: "388px",
            scrollX: "auto",
            info:false,
            order: [[2, 'asc']],

            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/de-DE.json'
            },

            ajax: {
                url: '/table/getApiTable',
                dataSrc: "",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            }, 
        });
    });
    </script>

    <div class="col-xl-5 mt-3">
        <div style="max-width:85vw" class="row mx-auto">

            <div class="tableHead">
                <i class="bi bi-broadcast-pin"></i>
                API-Verwaltung
            </div>

            <!--Key Tabelle-->
            <table class="tablestyle" id="keyTable">

                <colgroup>
                    <col style="width:50%">
                    <col style="width:25%">
                    <col style="width:25%">
                </colgroup>

                <thead>
                    <tr>
                        <th>API-Key</th>
                        <th>Besitzer</th>
                        <th>Gültig bis</th>
                    </tr>
                </thead>

            </table>
        </div>

        <script>
            function copyOnClick(button) {
                var element = document.getElementById("keyTextField");
                element.value = button.textContent;
            }
        </script>

    </div>

    <!--Bilder Link-->
    <div class="col-xl-2 mt-3 align-self-center">
        <div class="row justify-content-center">

            <div class="col-auto">
                <a href="/admin/api/logs"> <img class="img-link" style="width:100%;max-width:280px"
                        src="{{ asset('Bilder_WebApp/Log-link.png') }}" alt="Logs Link"> </a>
            </div>

        </div>
    </div>

</div>

@endsection