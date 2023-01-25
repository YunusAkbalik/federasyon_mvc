@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Veli Hesabı Oluştur</h1>
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
                        <form class="js-validation-signup" action="{{ route('admin_create_acc_veli_post') }}" method="POST">
                            @csrf
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
                                    <input type="text" class="form-control" onfocus="(this.type='date')" id="dogum_tarihi"
                                        name="dogum_tarihi" placeholder="Doğum Tarihi (*)">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-days"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="tel" class="form-control" id="gsm_no" name="gsm_no"
                                        placeholder="Telefon Numarası (*)">
                                    <span class="input-group-text">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="ogrenci_tc" name="ogrenci_tc"
                                        placeholder="Öğrenci T.C">
                                    <button onclick="OgrenciAra(this)" type="button" class="btn btn-primary">
                                        <i class="fa fa-search me-1"></i> Ara
                                    </button>
                                </div>
                            </div>
                            <div class="mb-4 text-center" id="ogrenciDiv">
        
                            </div>
                           
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-plus opacity-50 me-1"></i> Hesap Oluştur
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
    <script src="{{ asset('assets/js/pages/admin_veli_kayit.js') }}"></script>


    <script>
        function OgrenciAra(e) {
            Dashmix.block('state_loading', '#signblock');
            $('#ogrenciDiv').empty()
            var tc = $(e).prev().val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('tc', tc);
            $.ajax({
                url: '{{ route('getOgrenciFromTc') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    console.log(res);
                    if (res.error) {
                        var notFound = `<strong class="text-danger text-bold">Öğrenci Bulunamadı</strong>`
                        $('#ogrenciDiv').append(notFound)
                        Dashmix.block('state_normal', '#signblock');

                    } else {
                        if (!res.ogrenciVeliBaglanti) {
                            var ogrenci = ` <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                        <div
                                            class="block-content block-content-full d-flex align-items-center justify-content-between">
                                            <img class="img-avatar img-avatar48"
                                                src="{{ asset('assets/media/avatars/avatar16.jpg') }}"
                                                alt="">
                                            <div class="ms-3 text-end">
                                                <p class="fw-semibold mb-0">${res.data.ad} ${res.data.soyad}</p>
                                                <p class="fs-sm fw-medium text-muted mb-0">
                                                    ${res.data.okul.okul_details.ad}
                                                </p>
                                                <hr>
                                                <p class="fs-sm fw-medium text-muted mb-0">
                                                    ${res.data.okul.sinif}. sınıf
                                                </p>
                                            </div>
                                        </div>
                                    </a>`
                            $('#ogrenciDiv').append(ogrenci)
                        } else {
                            var exist = `<strong class="text-warning text-bold">Öğrencinin Velisi Var</strong>`
                            $('#ogrenciDiv').append(exist)
                        }
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }
    </script>
@endsection
