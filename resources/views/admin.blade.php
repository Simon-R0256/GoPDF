@extends ('layouts.layout')

@section('HeadContent')
<title>Nutzer-Verwaltung</title>
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

<li class="nav-item activeLink mx-4 dropdown">
    <a class="nav-link fs-4 p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Admin
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item activeLink transition" href="/admin"><i class="bi bi-people-fill me-2"></i>Nutzer-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api"><i class="bi bi-broadcast-pin me-2"></i>API-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api/logs"><i class="bi bi-journals me-2"></i>API-Logs</a></li>
    </ul>
</li>
@endsection


@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->


<div class="row justify-content-evenly">

    <!-- Aktionen Box -->
    <div class="col-xl-3">
        <div class="row justify-content-center">

            <!--"Nutzer Erstellen" Box-->
            <div class="col-12-xl mx-2 mt-3 contentBorder boxSize">

                <!--Überschrift-->
                <div class="row mt-3">
                    <div class="col-auto contentHead contentBorder">
                        Nutzer Erstellen
                    </div>
                </div>

                <!-- Form Start -->
                <form id="userCreateForm">
                    <!--E-Mail-->
                    <div class="row mt-2">
                        <div class="col">
                            <input class="form-control form-control-lg boxSize" type="email" id="userEmail"
                                placeholder="E-Mail" required>
                        </div>
                    </div>

                    <!--Passwort-->
                    <div class="row mt-2">
                        <div class="col">
                            <input class="form-control form-control-lg boxSize" type="text" id="userPassword"
                                placeholder="Password" required>
                        </div>
                    </div>

                    <!--Admin Checkbox und Label-->
                    <div class="row justify-content-center mt-3">

                        <div class="col-auto text-center h5 align-self-center">
                            Admin
                        </div>

                        <div class="col-auto form-check ms-3 mb-2">
                            <input class="form-check-input p-3" type="checkbox" id="userCheck">
                        </div>

                    </div>

                    <!--Submit Button-->
                    <div class="row text-center mt-2 mb-3">
                        <div class="col">
                            <input class="btn btnstyle btnstyle-green text-center" type="submit" value="Erstellen">
                        </div>
                    </div>
                </form>

            </div>


            <!--"Nutzer Löschen" Box-->
            <div class="col-12-xl mx-2 mt-3 contentBorder boxSize">

                <!--Überschrift-->
                <div class="row mt-3">
                    <div class="col-auto contentHead contentBorder">
                        Nutzer Löschen
                    </div>
                </div>

                <!--Form start-->
                <form id="userDeleteForm">

                    <!--Text Feld-->
                    <div class="row mt-2">
                        <div class="col">
                            <input class="form-control form-control-lg boxSize" type="text" id="userId" placeholder="ID"
                                required>
                        </div>
                    </div>

                    <!-- Info Alert-->
                    <div class="row mt-3">
                        <div class="col alert alert-secondary text-center p-2 mx-3">
                            Alle Dokumente, die der Nutzer erstellt hat, werden auch gelöscht!
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

    <!-- User Tabelle -->
    <script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            scrollY: "388px",
            scrollX: "auto",
            info:false,
            order: [[3, 'desc']],

            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/de-DE.json'
            },

            ajax: {
                url: '/table/getAdminTable',
                dataSrc: "",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            }, 
        });
    });

    </script>

    <div class="col-xl-6 mt-3 p-0">
        <div style="max-width:85vw" class="row mx-auto">

            <div class="tableHead">
                <i class="bi bi-people-fill"></i>
                Nutzer-Verwaltung
            </div>

            <!--Tabelle-->
            <table class="tablestyle" id="userTable">

                <colgroup>
                    <col style="width:15%">
                    <col style="width:45%">
                    <col style="width:20%">
                    <col style="width:20%">
                </colgroup>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>E-Mail</th>
                        <th>Rolle</th>
                        <th>Erstellt am</th>
                    </tr>
                </thead>

            </table>

        </div>
    </div>


    <!--Bilder Link-->
    <div class="col-xl-2 mt-3 align-self-center">
        <div class="row justify-content-center">

            <div class="col-auto">
                <a href="/admin/api"> <img class="img-link" style="width:100%;max-width:280px"
                        src="{{ asset('Bilder_WebApp/API-link.png') }}" alt="API Link"> </a>
            </div>

        </div>
    </div>

</div>

@endsection