<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale =1">

    <!--Bootstrap CSS Imports -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.css') }} ">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!--Eigene CSS-->
    <link rel="stylesheet" href="{{ asset('design.css') }} ">

    <!-- JQuery Import -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Data Table Imports -->
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>
    

    <!-- CSRF Token in Meta Content speichern, um es von ajaxScripts abzufragen -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('HeadContent')
</head>

<body class="backgroundPic">

    <div class="container-fluid">
        <!-- Main Container für alle Sections -->

        <!--Header-->
        <div class="row p-0 justify-content-between align-items-center" id="logo" style="min-height:70px">
            <div class="col-3 ms-2">
                <img class="img-fluid" style="min-width:300px" src="{{ asset('Bilder_WebApp/logo.svg') }}"
                    alt="Georg August Universität Göttingen">
            </div>
            <div class="col-1 me-5">
                <img class="img-fluid" style="min-width:80px" src="{{ asset('Bilder_WebApp/PDF-Logo.png') }}"
                    alt="GöPDF">
            </div>
        </div>

        <!-- Navigationsbar-->
        @if(Auth::User() != Null)
        <div class="row align-items-center" id="navigation">
            <div class="col-auto">
                <nav class="navbar navbar-expand">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">

                            @yield('Navbar')

                        </ul>
                    </div>
                </nav>
            </div>

            <div class="col-auto ms-auto my-1">
                <a data-bs-toggle="modal" data-bs-target="#profileModal" class="profileLink" href="#">
                    <div class="sessionInfo startBox ps-2">
                        <span class="bi bi-person-vcard"></span>
                    </div>

                    <div class="sessionInfo endBox px-2">
                        
                        @if(Auth::user() != null)

                            {{Auth::user()->username}}

                            @if(Auth::user()->role == "Admin")
                                <span class="bi bi-person-fill-gear"></span>
                            @endif

                            @if(Auth::user()->role == "Redakteur")
                                <span class="bi bi-pencil-fill"></span>
                            @endif
                        @endif
                       
                    </div>
                </a>

                <div style="float:right;" class="mx-3">
                    <form method="get" action="/logout">
                        <button class="btn sessionInfo logoutButton" type="submit">
                            Logout<span class="bi ms-3 bi-box-arrow-right"></span> 
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="row profileHead py-1 justify-content-between">
                        <div class="col-auto">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="col-auto">
                            Mein Profil
                        </div>
                        <div class="col-auto">
                            <button class="closeButton" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row profileContent py-4 justify-content-center">
                        <table class="profileTable w-75">
                            <tr>
                                <th style="width:35%"></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>User-ID</td>
                                <td>{{Auth::User()->id}}</td>
                            </tr>
                            <tr>
                                <td>E-Mail-Adresse</td>
                                <td>{{Auth::User()->email}}</td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>{{Auth::User()->username}}</td>
                            </tr>
                            <tr>
                                <td>Rolle</td>
                                <td>
                                    @php
                                    $userrole = Auth::User()->role;
                                    @endphp

                                    {{$userrole}}

                                    @if($userrole == "Admin")
                                    <span class="ms-1 bi bi-person-fill-gear"></span>
                                    @endif

                                    @if($userrole == "Redakteur")
                                    <span class="ms-1 bi bi-pencil-fill"></span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 0px;">
                                <td style="border-bottom: 0px;">Erstellt am</td>
                                <td style="border-bottom: 0px;">{{Auth::User()->created_at->format('d/m/Y')}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="row profileFooter py-3 justify-content-around">
                        <div class="col-auto">
                            <a data-bs-target="#profileModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                class="btn profileButton">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>
                        
                        <div class="col-auto">
                            @if(Auth::User()->role == "Admin")
                            <button data-bs-target="#keyModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                class="btn profileButton" onclick="loadMyKey(this)" data-id="{{Auth::id()}}" disabled="">
                                Mein API-Key
                                <i class="bi bi-key-fill"></i>
                            </button>
                            @endif

                            @if(Auth::User()->role == "Redakteur")
                            <a data-bs-target="#keyModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                class="btn profileButton" onclick="loadMyKey(this)" data-id="{{Auth::id()}}">
                                Mein API-Key
                                <i class="bi bi-key-fill"></i>
                            </a>
                            @endif
                        </div>
    
                        <div class="col-auto">
                            <a data-bs-target="#passwordModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                class="btn profileButton" style="background-color:yellow">
                                Passwort 
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Password ändern Modal -->
        <div class="modal fade" id="passwordModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="row profileHead py-1 text-center justify-content-between"> 
                        <div class="col-auto">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="col-auto">
                            Passwort ändern
                        </div>
                        <div class="col-auto">
                            <button class="closeButton" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <form action="/profile/changePassword" method="POST">
                        @csrf
                        <div class="row profileContent py-5 justify-content-center">
                            <div style="max-width:450px" class="col-auto w-75 input-group input-group-lg">
                                <span style="font-size:35px" class="input-group-text bi bi-key-fill"></span>
                                <input type="text" class="form-control form-control-lg profileForm" name="password" placeholder="Neues Passwort">
                            </div>   
                        </div>

                        <div class="row profileFooter py-3 justify-content-around">
                            
                            <div class="col-auto">
                                <a data-bs-target="#profileModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                    class="btn profileButton">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn profileButton">
                                    Absenden
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Meine API-Keys Modal -->
        <div class="modal fade" id="keyModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="row profileHead py-1 text-center justify-content-between"> 
                        <div class="col-auto">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <div class="col-auto">
                            Mein API-Key
                        </div>
                        <div class="col-auto">
                            <button class="closeButton" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row profileContent py-5 justify-content-center">
                        <table style="max-width:75%" class="profileTable text-center">
                            <tr>
                                <th>Key Value:</th>
                            </tr>
                            <tr>
                                <td id="myKeyValue">Du besitzt keinen API-Key</td>
                            </tr>
                            <tr>
                                <th>Gültig bis:<th>
                            </tr>
                            <tr>
                                <td style="border-bottom:0px" id="myKeyDate">-</td>
                            </tr>
                            
                        </table>
                    </div>

                    <div class="row profileFooter py-3 justify-content-around">
                        
                        <div class="col-auto">
                            <a data-bs-target="#profileModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                class="btn profileButton">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <div class="col-auto">
                            <button class="btn profileButton" onclick="getMyKey(this)" data-id="{{Auth::id()}}">
                                API-Key anfordern
                            </button>
                        </div>

                    </div>
                  
                </div>
            </div>
        </div>
        @endif

        <!-- ErrorBox -->
        <div class = "messageBox mt-5"></div>

        @yield('BodyContent')


        <!--Legt eine Ebene hinter den Footer damit der Footer
        nicht den Contentder Seite Überschneidet-->
        <div class="row" id="footerResponsive">
        </div>

        <!--Footer-->
        <div class="row fixed-bottom" id="footer">
            <div class="col-auto m-auto border border-1 rounded-pill">
                ©2023 Universität Göttingen
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Imports -->
    <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>

    <!-- Eigene Ajax Scripts -->
    <script src="{{ asset('ajaxScripts.js') }}"></script>

</body>

</html>