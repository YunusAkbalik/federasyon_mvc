@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Kurum Oluştur</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">

            </div>
            <div class="block-content">
                <div class="row justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form class="js-validation-signup" action="{{ route('admin_create_kurum_post') }}" method="POST">
                            @csrf
                            <p class="fw-bold fs-sm text-muted mb-4">Kurum Bilgileri</p>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" id="unvan" name="unvan"
                                            placeholder="Kurum Ünvanı (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-id-card"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="input-group input-group-lg">

                                        <input type="text" class="js-masked-phone form-control" id="telefon"
                                            name="telefon_input"  placeholder="Telefon (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="input-group input-group-lg">
                                        <textarea class="form-control" name="adres" placeholder="Adres (*)" id="adres" cols="30" rows="2"></textarea>
                                        <span class="input-group-text">
                                            <i class="fa fa-location-dot"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" id="vergi_dairesi" name="vergi_dairesi"
                                            placeholder="Vergi Dairesi (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-comment-dollar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="number" class="form-control" id="vergi_no" name="vergi_no"
                                            placeholder="Vergi No (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-comment-dollar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" id="yetkili_kisi" name="yetkili_kisi"
                                            placeholder="Yetkili Kişi (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="js-masked-phone form-control" id="yetkili_telefon"
                                            name="yetkili_telefon_input" placeholder="Yetkili Telefon (*)">
                                        <span class="input-group-text">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="js-masked-phone form-control" id="wp_hatti" name="wp_hatti_input"
                                        placeholder="Whatsapp Hattı">
                                    <span class="input-group-text">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <textarea name="kurum_hizmetler" id="kurum_hizmetler" class="form-control"
                                        placeholder="Kurumun verdiği hizmetler. Lütfen (,) ile ayırın. Örn : Etüt, İngilizce, Kodlama" cols="30"
                                        rows="4"></textarea>
                                    <span class="input-group-text">
                                        <i class="fa fa-person-chalkboard"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fw-bold fs-sm text-muted mb-4">Kurum Hesap Bilgileri</p>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="input-group input-group-lg">
                                        <input type="number" class="form-control" id="tc_kimlik" name="tc_kimlik"
                                            placeholder="TC Kimlik Numarası (*)">
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
                                        id="dogum_tarihi" name="dogum_tarihi" placeholder="Doğum Tarihi">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-days"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="tel" class="js-masked-phone form-control" id="gsm_no" name="gsm_no_input"
                                        placeholder="Telefon Numarası">
                                    <span class="input-group-text">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-plus opacity-50 me-1"></i> Kurum Oluştur
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/admin_create_kurum.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-masked-inputs']);
    </script>
@endsection
