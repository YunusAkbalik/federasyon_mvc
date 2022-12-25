<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Veli Kayıt</title>

    <meta name="description" content="Veli Kayıt">
    <meta name="author" content="roosecs">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Veli Kayıt">
    <meta property="og:site_name" content="MNG Dijital">
    <meta property="og:description" content="Veli Kayıt">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>

    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo14@2x.jpg') }}');">
                <div class="row g-0 justify-content-center bg-black-75">
                    <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                        <!-- Sign Up Block -->
                        <div id="signblock" class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                            <div
                                class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                                <!-- Header -->
                                <div class="mb-2 text-center">
                                    <a class="link-fx fw-bold fs-1" href="index.html">
                                        <span class="text-dark">Veli</span><span class="text-primary">kayıt</span>
                                    </a>
                                    <p class="text-uppercase fw-bold fs-sm text-muted">YENİ BİR VELİ HESABI OLUŞTUR
                                    </p>
                                </div>
                                <!-- END Header -->

                                <!-- Sign Up Form -->
                                <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _js/pages/op_auth_signup.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-signup" action="#" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="input-group input-group-lg">
                                                <input type="number" class="form-control" id="tc_kimlik"
                                                    name="tc_kimlik" placeholder="TC Kimlik Numarası (*)">
                                                <span class="input-group-text">
                                                    <i class="fa fa-id-card"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control" id="ad" name="ad"
                                                    placeholder="İsim (*)">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 mb-4">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control" id="soyad" name="soyad"
                                                    placeholder="Soyisim (*)">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="E-posta adresi">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="text" class="form-control" onfocus="(this.type='date')"
                                                id="dogum_tarihi" name="dogum_tarihi" placeholder="Doğum Tarihi (*)">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar-days"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="tel" class="form-control" id="gsm_no" name="gsm_no"
                                                placeholder="Telefon Numarası">
                                            <span class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-sm-flex justify-content-sm-between align-items-sm-center mb-4 bg-body rounded py-2 px-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="signup-terms"
                                                name="signup-terms">
                                            <label class="form-check-label" for="signup-terms">Kabul Ediyorum</label>
                                        </div>
                                        <div class="fw-semibold fs-sm py-1">
                                            <a class="fw-semibold fs-sm" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modal-terms">Şartlar &amp; Koşullar</a>
                                        </div>
                                    </div>
                                    <div class="text-center mb-4">
                                        <button type="submit" class="btn btn-hero btn-primary">
                                            <i class="fa fa-fw fa-plus opacity-50 me-1"></i> Kayıt Ol
                                        </button>
                                    </div>
                                </form>
                                <!-- END Sign Up Form -->
                            </div>
                        </div>
                    </div>
                    <!-- END Sign Up Block -->
                </div>

                <!-- Terms Modal -->
                <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog"
                    aria-labelledby="modal-terms" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-success">
                                    <h3 class="block-title">Şartlar &amp; Koşullar</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad
                                        feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante
                                        convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat
                                        accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies
                                        sed, fames aliquet consectetur consequat nostra molestie neque nullam
                                        scelerisque neque commodo turpis quisque etiam egestas vulputate massa,
                                        curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit
                                        gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos
                                        nibh orci.</p>
                                    <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad
                                        feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante
                                        convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat
                                        accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies
                                        sed, fames aliquet consectetur consequat nostra molestie neque nullam
                                        scelerisque neque commodo turpis quisque etiam egestas vulputate massa,
                                        curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit
                                        gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos
                                        nibh orci.</p>
                                </div>
                                <div class="block-content block-content-full text-end bg-body">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        data-bs-dismiss="modal">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Terms Modal -->
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
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/veli_kayit.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-notify']);
    </script>
    <script>
        function ilSelect(id) {
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            $.ajax({
                url: "{{ route('getIlcelerFromIlID') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        Dashmix.block('state_loading', '#signblock');
                        $('#ilce').empty();
                        var option = `<option value="0" selected disabled>İlçe seçimi</option>`;
                        $('#ilce').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#ilce').append(option)
                        });
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }

        function ilceSelect(id) {
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            $.ajax({
                url: "{{ route('getOkullarFromIlceID') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        Dashmix.block('state_loading', '#signblock');
                        $('#okul').empty();
                        var option = `<option value="0" selected disabled>Okul seçimi</option>`;
                        $('#okul').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#okul').append(option)
                        });
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }
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
