<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Parola Değiştir</title>

    <meta name="description" content="Klüp">
    <meta name="author" content="roosecs, mngdijital">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Parola Değiştir">
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
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
</head>

<body>
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo9@2x.jpg') }}');">
                <div class="row g-0 justify-content-center bg-black-75">
                    <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                        <!-- Lock Block -->
                        <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                            <div
                                class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                                <!-- Header -->
                                <div class="mb-2 text-center">
                                    <a class="link-fx fw-bold fs-1" href="index.html">
                                        <span class="text-dark">Parola</span><span class="text-primary">Belirle</span>
                                    </a>
                                    <p class="text-uppercase fw-bold fs-sm text-muted">LÜTFEN YENİ PAROLA BELİRLEYİN</p>
                                </div>
                                <div class="text-center push">
                                    <div class="d-inline-block p-4 rounded bg-body">
                                        <img class="img-avatar img-avatar-thumb"
                                            src="{{ asset('assets/media/avatars/avatar11.jpg') }}" alt="">
                                        <a class="d-block fw-semibold mt-2"
                                            href="javascript:void(0)">{{ auth()->user()->ad . ' ' . auth()->user()->soyad }}</a>
                                        <div class="fs-sm fw-semibold text-muted">
                                            {{ auth()->user()->getRoleNames()[0] }}</div>
                                    </div>
                                </div>
                                <!-- END Header -->

                                <!-- Lock Form -->
                                <!-- jQuery Validation (.js-validation-lock class is initialized in js/pages/op_auth_lock.min.js which was auto compiled from _js/pages/op_auth_lock.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-lock" action="{{ route('onePass_change_post') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="number" class="form-control" id="password"
                                                name="password" placeholder="Yeni Parola (8 Rakam)">
                                            <span class="input-group-text">
                                                <i class="fa fa-asterisk"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-center mb-4">
                                        <button type="submit" class="btn btn-hero btn-primary">
                                            <i class="fa fa-fw fa-lock-open opacity-50 me-1"></i> Parolamı DEĞİŞTİR
                                        </button>
                                    </div>
                                    <div class="text-center mb-4">
                                        <div class="fw-semibold fs-sm py-1">
                                            <a href="{{ route('cikis_yap') }}">Çıkış Yap
                                                <i class="fa-solid fa-right-from-bracket"></i></a>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Lock Form -->
                            </div>
                        </div>
                        <!-- END Lock Block -->
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    <!--
      Dashmix JS
    
      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/vide/jquery.vide.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/op_auth_lock.min.js') }}"></script>
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
</body>

</html>
