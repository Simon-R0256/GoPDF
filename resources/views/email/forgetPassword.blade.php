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

<body class = "backgroundPic">
    <div class="container-fluid">
        <div class="row p-0 justify-content-between align-items-center" id="logo" style="min-height:70px">
            <div class="col-3 ms-2">
                <img class="img-fluid" style="min-width:300px" src="{{ asset('Bilder_WebApp/Logo.svg') }}" alt="George August Universität Göttingen">
            </div>
            <div class="col-1 me-5">
                <img class="img-fluid" style="min-width:80px" src="{{ asset('Bilder_WebApp/PDF-Logo.png') }}" alt="GöPDF">
            </div>
        </div>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <br>
                        <br>
                        <br>
                        <h3>Hi {{$username}},</h3>
                        <br>
                        <p>Du hast vor kurzem einen Passwort-Reset in unserer WebApp GöPDF angefragt. Falls das nicht der Fall sein sollte kannst du diese E-Mail ignorieren. <br>
                        <br>
                        <br>
                        Falls doch, kannst du über den unten stehenden Link zum Passwort-Reset gelangen:</p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="{{ route('reset.password.get', $token) }}" class="f-fallback button button--green" target="_blank">Reset your password</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>   
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
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