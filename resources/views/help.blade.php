@extends ('layouts.layout')

@section('HeadContent')
<title>Hilfe</title>

@endsection

@section('Navbar')
<!-- Navigation-->

<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/documents">Dokumente</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/editor">Editor</a>
</li>
<li class="nav-item transition activeLink mx-4">
    <a class="nav-link fs-4 p-0" href="/help">Hilfe</a>
</li>

@if(Auth::User() != Null)
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
@endif

@endsection

@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->

<div class="row mt-4 justify-content-center">
    <div class="col-auto helpBody">
        <div class="helpHead mx-auto mt-3 text-center">
            Help-Board
            <i class="ms-2 bi bi-info-circle"></i>
        </div>

        <div class="row justify-content-evenly mt-3 mb-5">

            <div class="col-auto-lg helpBox mx-2 mt-4 px-0">
                <div class="boxHead mt-2">
                    <i class="bi bi-broadcast-pin boardIcon"></i>
                    API-Requests
                    <img class="boardPin" src="{{ asset('Bilder_WebApp/boardpin.png') }}">
                </div>
                <div class="helpText mx-2 mt-2">
                    <b>GET</b> 127.0.0.1:8000/api/doc/ <br>
                    <i class="bi bi-arrow-return-right"></i> Auflistung aller freigegebenen Musterdokumente <br>

                    <b>GET</b> 127.0.0.1:8000/api/doc/ID <br>
                    <i class="bi bi-arrow-return-right"></i> gibt Informationen (Name, Platzhalter) über das <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; ausgewählte Dokument zurück<br>

                    <b>GET</b> 127.0.0.1:8000/api/doc/SUCHTEXT <br>
                    <i class="bi bi-arrow-return-right"></i> listet alle Dokumente auf, die den Suchtext im <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; Namen enthalten<br>
                    <br>
                    <b>POST</b> 127.0.0.1:8000/api/doc/ID <br>
                    <i class="bi bi-arrow-return-right"></i> Gibt den Inhalt des Dokuments in PDF zurück<br>
                    <i class="bi bi-arrow-right"></i> Ggf. können Werte für die Platzhalter als<br>
                    &nbsp;&nbsp;&nbsp;&nbsp; Parameter übergeben werden<br>
                    <i class="bi bi-arrow-right"></i> z.B: Nummer 🠖 568414
                </div>
            </div>

            <div class="col-auto-lg helpBox mx-2 mt-4 px-0">
                <div class="boxHead mt-2">
                    <i class="bi bi-pencil-square boardIcon"></i>
                    Editor
                    <img class="boardPin" src="{{ asset('Bilder_WebApp/boardpin.png') }}">
                </div>
                <div class="helpText mx-2 mt-2">
                    Der Editor ermöglicht das Erstellen und
                    Bearbeiten von Musterdokumenten.<br>
                    <br>
                    <i class="bi bi-info-circle"></i> Es ist möglich Platzhalter im Dokument zu <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; platzieren, die bei der PDF-Umwandlung durch <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; beliebigen Text ersetzt werden. <br>
                    <i class="bi bi-arrow-return-right"></i> Ein Platzhalter wird durch @php print("{{*Name*}}") @endphp
                    im Editor <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; gekennzeichnet. Der Name ist dabei variabel. <br>
                    <br>
                    <i class="bi bi-info-circle"></i> Ein Bild kann im Dokument platziert werden, <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; indem es durch Drag&Drop vom lokalen <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; Dateisystem in den Editor gezogen wird.
                </div>
            </div>

            <div class="col-auto-lg helpBox mx-2 mt-4 px-0">
                <div class="boxHead mt-2">
                    <i class="bi bi-file-code boardIcon"></i>
                    Meine Dokumente
                    <img class="boardPin" src="{{ asset('Bilder_WebApp/boardpin.png') }}">
                </div>
                <div class="helpText mx-2 mt-2">
                    In der Dokumenten-Verwaltung können eigene Dokumente
                    <ul>
                        <li> bearbeitet <i class="bi bi bi-wrench-adjustable"></i>,</li>
                        <li> von einem Admin freigegeben <i class="bi bi-broadcast-pin"></i>,</li>
                        <li> oder gelöscht werden <i class="bi bi-trash3"></i></li>
                    </ul>
                    <i class="bi bi-info-circle"></i> "Freigegeben" bedeutet, dass das Dokument über <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; die API-Schnittstelle abrufbar ist. Der Freigabe- <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; Prozess benötigt die Bestätigung eines Admins. <br>
                    <i class="bi bi-info-circle"></i> Es ist möglich die Freigabe zurückzunehmen. <br>

                    <br>
                    <i class="bi bi-exclamation-triangle"></i> Das Bearbeiten eines freigegebenen Dokuments <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; entfernt die Schnittstelle und es bedarf einer <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; erneuten Freigabe.
                </div>
            </div>


            <div class="col-auto-lg helpBox mx-2 mt-4 px-0">
                <div class="boxHead mt-2">
                    <i class="bi bi-person-fill-gear boardIcon"></i>
                    Administration
                    <img class="boardPin" src="{{ asset('Bilder_WebApp/boardpin.png') }}">
                </div>
                <div class="helpText mx-2 mt-2">
                    Admins können 
                    <ul>
                        <li>auf die Nutzer- und API-Verwaltung zugreifen,</li>
                        <li>alle Dokumente bearbeiten/löschen,</li>
                        <li>Freigabeanfragen annehmen/ablehnen</li>
                    </ul>
                    <i class="bi bi-info-circle"></i> In der API-Verwaltung sind Statistiken der <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; einzelnen Schnittstellen einsehbar. Außerdem <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; werden hier die API-Keys generiert. <br>
                    
                    <br>
                    <i class="bi bi-exclamation-triangle"></i> Admins können keine Dokumente ohne <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; vorherige Anfrage freigeben! <br>
                    <br>
                </div>
            </div>

            <div class="col-auto-lg helpBox mx-2 mt-4 px-0">
                <div class="boxHead mt-2">
                    <i class="bi bi-patch-question boardIcon"></i>
                    Sonstiges
                    <img class="boardPin" src="{{ asset('Bilder_WebApp/boardpin.png') }}">
                </div>
                <div class="helpText mx-2 mt-2">
                    Es werden Symbole genutzt um die Nutzerrollen zu repräsentieren:
                    <ul>
                        <li>Redakteur <span class="bi bi-pencil-fill"></span></li>
                        <li>Admin <span class="bi bi-person-fill-gear"></span></li>
                    </ul>
                    <i class="bi bi-info-circle"></i> Über die Profil-Seite können Nutzer temporär <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; nutzbare API-Keys generieren. Diese sind zwei <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; Wochen gültig.<br>
                    <br>
                    <i class="bi bi-exclamation-triangle"></i> Um einen API-Key mit längerer Gültigkeit zu <br>
                    &nbsp;&nbsp;&nbsp;&nbsp; erhalten, ist ein Admin zu kontaktieren. <br>

                </div>
            </div>



        </div>
    </div>
</div>


@endsection