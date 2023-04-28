<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale =1">

    <!--Bootstrap Imports -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.css') }} ">
    <link rel="stylesheet" href="{{ asset('design.css') }} ">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid loginContainer">
        <div class="row p-0 justify-content-between align-items-center" id="logo" style="min-height:70px">
            <div class="col-3 ms-2">
                <img class="img-fluid" style="min-width:300px" src="{{ asset('Bilder_WebApp/Logo.svg') }}" alt="George August Universität Göttingen">
            </div>
            <div class="col-1 me-5">
                <img class="img-fluid" style="min-width:80px" src="{{ asset('Bilder_WebApp/PDF-Logo.png') }}" alt="GöPDF">
            </div>
        </div>
        <div class="row loginRow justify-content-center">
            <div class="loginCol">
                <br><br><br><br><br>
                <div class="row offset-row justify-content-center mt-1 mx-1">

                    <div style="width:100%;max-width:700px" class="col-auto loginHead">
                        Passwort zurücksetzen
                    </div>
                </div>
                <form action="{{ route('reset.password.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <!--E-Mail-->
                    <div class="row offset-row justify-content-center mt-4">
                        <div style="max-width:500px" class="col-auto input-group input-group-lg">
                            <span style="font-size:35px" class="input-group-text bi bi-person-circle"></span>
                            <input class="form-control form-control-lg" type="email" id="email-address" name="email" placeholder="E-Mail Adresse" required>

                        </div>
                    </div>

                    <!--Password-->
                    <div class="row offset-row justify-content-center mt-3">
                        <div style="max-width:500px" class="col-auto input-group input-group-lg">
                            <span style="font-size:35px" class="input-group-text bi bi-key-fill"></span>
                            <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Passwort" required>
                        </div>
                    </div>

                    <!--Passwort bestätigen-->
                    <div class="row offset-row justify-content-center mt-3">
                        <div style="max-width:500px" class="col-auto input-group input-group-lg">
                            <span style="font-size:35px" class="input-group-text bi bi-key-fill"></span>
                            <input class="form-control form-control-lg" type="password" id="password-confirm" name="password_confirmation" placeholder="Passwort bestätigen" required>
                        </div>
                    </div>
                    <!--Submit-->
                    <div class="row offset-row justify-content-center mt-4 mb-3">
                        <div class="col-auto">
                            <button class="btn loginButton text-center" type="submit" value="Login" required>
                                PW ändern
                                <span class="bi bi-unlock"> </span>
                            </button>
                        </div>

                    </div>
                </form>
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