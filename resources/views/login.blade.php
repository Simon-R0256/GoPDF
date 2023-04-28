<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale =1">

    <!--Bootstrap Imports -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.css') }} ">
    <link rel="stylesheet" href="{{ asset('design.css') }} ">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

    <div class="container-fluid loginContainer">

        <!--Header-->
        <div class="row p-0 justify-content-between align-items-center" id="logo" style="min-height:70px">
            <div class="col-3 ms-2">
                <img class="img-fluid" style="min-width:300px" src="{{ asset('Bilder_WebApp/Logo.svg') }}" alt="George August Universität Göttingen">
            </div>
            <div class="col-1 me-5">
                <img class="img-fluid" style="min-width:80px" src="{{ asset('Bilder_WebApp/PDF-Logo.png') }}" alt="GöPDF">
            </div>
        </div>

        <form method="post" action="/authenticate">
            @csrf

            <!--Login Box-->
            <div class="row loginRow justify-content-center">
                <div class="loginCol">

                    <!--Icon und Überschrift-->
                    <div class="row justify-content-center offset-row ">
                        <div class="col-auto">
                            <img style="max-width:30vw" class="img-fluid" src="{{ asset('Bilder_WebApp/login.png') }}" alt="Login-User">
                        </div>


                        <a class="loginHelp col-auto" href="/help">
                            <span class="bi bi-question-circle-fill"></span>
                        </a>
                    </div>

                    <div class="row offset-row justify-content-center mt-1 mx-1">
                        <div style="width:100%;max-width:700px" class="col-auto loginHead">
                            ANMELDEN
                        </div>
                    </div>

                    <!--E-Mail-->
                    <div class="row offset-row justify-content-center mt-4">
                        <div style="max-width:500px" class="col-auto input-group input-group-lg">
                            <span style="font-size:35px" class="input-group-text bi bi-person-circle"></span>
                            @if (session('email'))
                            <input class="form-control form-control-lg" value="{{session('email')}}" type="email" name="email" placeholder="E-Mail Adresse" required>
                            @else
                            <input class="form-control form-control-lg" type="email" name="email" placeholder="E-Mail Adresse" required>
                            @endif
                        </div>
                    </div>

                    <!--Password-->
                    <div class="row offset-row justify-content-center mt-3">
                        <div style="max-width:500px" class="col-auto input-group input-group-lg">
                            <span style="font-size:35px" class="input-group-text bi bi-key-fill"></span>
                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Passwort" required>
                        </div>
                    </div>

                    <!-- Passwort Wiederherstellen -->
                    <div class="row offset-row mt-3 justify-content-center">
                        <div class="col-auto">
                            <a class="passwordReset px-3 py-1" href="#" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                                Passwort zurücksetzen
                            </a>
                        </div>
                    </div>

                    <!--Submit-->
                    <div class="row offset-row justify-content-center mt-4 mb-3">
                        <div class="col-auto">
                            <button class="btn loginButton text-center" type="submit" value="Login" required>
                                Login
                                <span class="bi bi-unlock"> </span>
                            </button>
                        </div>
                    </div>

                    @if (session("error") )
                    <div class="row justify-content-center alertFade">
                        <div class="loginError alert alert-danger">
                            {{session("error")}}
                        </div>
                    </div>
                    @endif

                    <!-- Script um Alert automatisch auszublenden -->
                    <script>
                        $(document).ready(function() {
                            window.setTimeout(function() {
                                $(".alertFade").fadeTo(1000, 0).slideUp(1000, function() {
                                    $(this).remove();
                                });
                            }, 3000);
                        });
                    </script>


                </div>
            </div>

        </form>

        <!-- Password Wiederherstellen Modal -->
        <div class="modal fade" id="passwordResetModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="row profileHead py-1 text-center justify-content-between">
                        <div class="col-auto">
                            <i class="bi bi-envelope-at-fill"></i>
                        </div>
                        <div class="col-auto">
                            Passwort zurücksetzen
                        </div>
                        <div class="col-auto">
                            <button class="closeButton" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <form action="/forget-password" method="POST">
                        @csrf
                        <div class="row profileContent py-5 justify-content-center">
                            <div style="max-width:450px" class="col-auto w-75 input-group input-group-lg">
                                <span style="font-size:35px" class="input-group-text bi bi-person-circle"></span>
                                <input type="text" class="form-control form-control-lg profileForm" name="email" placeholder="E-Mail Adresse">
                            </div>
                        </div>

                        <div class="row profileFooter py-3 justify-content-around">

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


        <!--Footer-->
        <div class="row" id="footerResponsive">
        </div>

        <div class="row fixed-bottom" id="footer">
            <div class="col-auto m-auto border border-1 rounded-pill">
                ©2023 Universität Göttingen
            </div>
        </div>

    </div>

    <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>
</body>

</html>