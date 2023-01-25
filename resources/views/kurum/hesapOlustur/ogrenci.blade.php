@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Öğrenci Hesabı Oluştur</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded" id="signblock">
            <div class="block-header block-header-default">

            </div>
            <div class="block-content">
                <div class="row justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form class="js-validation-signup" action="{{ route('kurum_hesapOlustur_ogrenci_post') }}"
                            method="POST">
                            @csrf
                            <p class="fw-bold fs-sm text-muted mb-4">Kişisel Bilgiler</p>

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
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="tel" class="form-control" id="kan_grubu" name="kan_grubu"
                                        placeholder="Kan grubu Örn: (0 RH +)">
                                    <span class="input-group-text">
                                        <i class="fa fa-suitcase-medical"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fw-bold fs-sm text-muted mb-4">Okul bilgileri</p>
                            <div class="row">
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <select name="il" onchange="ilSelect(this.value)" class="form-control"
                                            id="il">
                                            <option value="0" disabled selected> İl seçimi</option>
                                            @foreach ($iller as $il)
                                                <option value="{{ $il->id }}">{{ $il->ad }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <select name="ilce" onchange="ilceSelect(this.value)" class="form-control"
                                            id="ilce">
                                            <option value="0" disabled selected> İlçe seçimi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <select name="okul" class="form-control" id="okul">
                                        <option value="0" disabled selected> Okul seçimi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <select name="sinif" class="form-control" id="sinif">
                                            <option value="0" selected disabled>Sınıf</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value="{{ $i }}">{{ $i }}. sınıf
                                                </option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text">
                                            <i class="fa fa-graduation-cap"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 mb-4">
                                    <div class="input-group input-group-lg">
                                        <select name="sube" class="form-control" id="sube">
                                            <option value="0" selected disabled>Şube</option>
                                            <option value="null">Şube Yok</option>

                                            @foreach (range('A', 'Z') as $item)
                                                <option value="{{ $item }}">{{ $item }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">
                                            <i class="fa fa-graduation-cap"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" id="brans" name="brans"
                                        placeholder="Branş">
                                    <span class="input-group-text">
                                        <i class="fa fa-briefcase"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fw-bold fs-sm text-muted mb-4">Kurum bilgileri</p>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <select name="kurum_okul" onchange="okulSelect(this.value)" id="kurum_okul"
                                        class="form-control">
                                        <option value="0" selected disabled>Kurum Okulu</option>
                                        @foreach ($kurumOkullar as $okul)
                                            <option value="{{ $okul->id }}">{{ $okul->okul->ad }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text">
                                        <i class="fa fa-users-rectangle"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <select name="kurum_sinif" id="kurum_sinif" class="form-control">
                                        <option value="0" selected disabled>Kurum Sınıfı</option>
                                    </select>
                                    <span class="input-group-text">
                                        <i class="fa fa-users-rectangle"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="fw-bold fs-sm text-muted mb-4">Veli bilgileri</p>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="veli_tc" name="veli_tc"
                                            placeholder="Veli T.C">
                                        <button onclick="VeliAra(this)" type="button" class="btn btn-primary">
                                            <i class="fa fa-search me-1"></i> Ara
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 text-center" id="veliDiv">

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
    <script src="{{ asset('assets/js/pages/kurum_create_acc_ogrenci.js') }}"></script>
    <script>
        function ilSelect(id) {
            Dashmix.block('state_loading', '#signblock');
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
                    Dashmix.block('state_normal', '#signblock');
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        $('#ilce').empty();
                        var option = `<option value="0" selected disabled>İlçe seçimi</option>`;
                        $('#ilce').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#ilce').append(option)
                        });
                    }
                }
            })
        }

        function okulSelect(id) {
            Dashmix.block('state_loading', '#signblock');
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('okul_id', id);
            $.ajax({
                url: "{{ route('kurum_get_sinif_from_okul') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Dashmix.block('state_normal', '#signblock');
                    $('#kurum_sinif').empty();
                    if (res.data.length <= 0) {
                        var option = `<option value="0" selected="" disabled="">Sınıf Yok</option>`;
                        $('#kurum_sinif').append(option);
                    }

                    res.data.forEach(element => {
                        var option = `<option value="${element.id}">${element.ad}</option>`;
                        $('#kurum_sinif').append(option)
                    });
                    console.log(res);
                },
                error: function(res) {
                    Dashmix.block('state_normal', '#signblock');

                    Dashmix.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        align: 'center',
                        message: res.responseJSON.message
                    });
                }
            })
        }

        function ilceSelect(id) {
            Dashmix.block('state_loading', '#signblock');
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
                    Dashmix.block('state_normal', '#signblock');
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        $('#okul').empty();
                        var option = `<option value="0" selected disabled>Okul seçimi</option>`;
                        $('#okul').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#okul').append(option)
                        });
                    }
                }
            })
        }
    </script>
    <script>
        function VeliAra(e) {
            Dashmix.block('state_loading', '#signblock');
            $('#veliDiv').empty()
            var tc = $(e).prev().val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('tc', tc);
            $.ajax({
                url: '{{ route('getVeliFromTc') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    console.log(res);
                    if (res.error) {
                        var notFound = `<strong class="text-danger text-bold">Veli Bulunamadı</strong>`
                        $('#veliDiv').append(notFound)
                        Dashmix.block('state_normal', '#signblock');

                    } else {
                        if (!res.veliOgrenciBaglanti) {
                            var veli = ` <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                                            <div
                                                class="block-content block-content-full d-flex align-items-center justify-content-between">
                                                <img class="img-avatar img-avatar48"
                                                    src="{{ asset('assets/media/avatars/avatar16.jpg') }}"
                                                    alt="">
                                                <div class="ms-3 text-end">
                                                    <p class="fw-semibold mb-0">${res.data.ad} ${res.data.soyad}</p>
                                                    <p class="fs-sm fw-medium text-muted mb-0">
                                                        ${res.data.gsm_no}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>`
                            $('#veliDiv').append(veli)
                        } else {
                            var exist = `<strong class="text-warning text-bold">Velinin Öğrencisi Var</strong>`
                            $('#veliDiv').append(exist)
                        }
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }
    </script>
@endsection
