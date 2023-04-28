<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale =1">
    <title>Unauthorized</title>
    <!--Bootstrap Imports -->
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.css') }} ">
    <link rel="stylesheet" href="{{ asset('design.css') }} ">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body class="backgroundPic">

    <div class="container-fluid">

        <!--Header-->
        <div class="row p-0 justify-content-between align-items-center" id="logo" style="min-height:70px">
            <div class="col-3 ms-2">
                <img class="img-fluid" style="min-width:300px" src="{{ asset('Bilder_WebApp/Logo.svg') }}"
                    alt="George August Universität Göttingen">
            </div>
            <div class="col-1 me-5">
                <img class="img-fluid" style="min-width:80px" src="{{ asset('Bilder_WebApp/PDF-Logo.png') }}"
                    alt="GöPDF">
            </div>
        </div>

        <div style="position:relative;top:25%" class="row">
            <div style="font-size:4vw;" class="alert alert-danger text-center">
                Error 401 - Unauthorized<i class="ms-5 bi bi-exclamation-triangle"></i>
            </div>
        </div>

        <div style="position:relative;top:25%" class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-secondary" style="font-size:25px" onclick="window.history.go(-1);">
                    Back <i class="bi bi-arrow-return-left"></i>
                </button>
            </div>
        </div>

        <!--Footer-->
        <div class="row" id="footerResponsive">
        </div>

        <div class="row fixed-bottom" id="footer">
            <div class="col-auto m-auto border border-1 rounded-pill">
                ©2022 Universität Göttingen
            </div>
        </div>

    </div>

    <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>
</body>

</html>