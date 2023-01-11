<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>MNG Dijital</title>

    <meta name="description" content="Klüp">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="roosecs, mngdijital">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="MNG Dijital">
    <meta property="og:site_name" content="MNG Dijital">
    <meta property="og:description" content="Klüp">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <div class="bg-image" style="background-image: url('assets/media/photos/photo19@2x.jpg');">
                <div class="row g-0 justify-content-center bg-primary-dark-op">
                    <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                        <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                            <div
                                class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                                <div class="mb-2 text-center">
                                    <a class="link-fx fw-bold fs-1" href="javascript:void(0)">
                                        <span class="text-dark">Giriş</span><span class="text-primary">Yap</span>
                                    </a>
                                    <p class="text-uppercase fw-bold fs-sm text-muted">Klüp</p>
                                </div>
                                <form class="js-validation-signin" action="{{ route('giris_yap_post') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="text" class="form-control" id="login-id" name="login_id"
                                                placeholder="ID veya Telefon Numarası">
                                            <span class="input-group-text">
                                                <i class="fa fa-user-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="password" class="form-control" id="login-password"
                                                name="login_password" placeholder="Parola">
                                            <span class="input-group-text">
                                                <i class="fa fa-asterisk"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">

                                        <div class="fw-semibold fs-sm py-1">
                                            <a onclick="alert('İnş bulursun')" href="javascript:void(0)">Şifremi Unuttum
                                                <i class="fa-solid fa-fish"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center mb-4">
                                        <button type="submit" class="btn btn-hero btn-primary">
                                            <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Giriş Yap
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content bg-body">
                                <div class="d-flex justify-content-center text-center push">
                                    <a class="item item-circle item-tiny me-1 bg-default" data-toggle="theme"
                                        data-theme="default" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xwork" data-toggle="theme"
                                        data-theme="assets/css/themes/xwork.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xmodern" data-toggle="theme"
                                        data-theme="assets/css/themes/xmodern.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xeco" data-toggle="theme"
                                        data-theme="assets/css/themes/xeco.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xsmooth" data-toggle="theme"
                                        data-theme="assets/css/themes/xsmooth.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xinspire" data-toggle="theme"
                                        data-theme="assets/css/themes/xinspire.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xdream" data-toggle="theme"
                                        data-theme="assets/css/themes/xdream.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny me-1 bg-xpro" data-toggle="theme"
                                        data-theme="assets/css/themes/xpro.min.css" href="#"></a>
                                    <a class="item item-circle item-tiny bg-xplay" data-toggle="theme"
                                        data-theme="assets/css/themes/xplay.min.css" href="#"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/op_auth_signin.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-notify']);
    </script>
    @if (count($errors))
        <script>
            Dashmix.helpers('jq-notify', {
                type: 'danger',
                icon: 'fa fa-times me-1',
                message: '{{ $errors->first() }}'
            });
        </script>
    @endif
    @if (Session::has('success'))
        <script>
            Dashmix.helpers('jq-notify', {
                type: 'success',
                icon: 'fa fa-check me-1',
                message: '{{ Session::get('success') }}'
            });
        </script>
    @endif
</body>

</html>
