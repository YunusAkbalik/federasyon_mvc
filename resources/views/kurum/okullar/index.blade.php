@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Okullar</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group input-group-lg">
                            <select name="il" onchange="ilSelect(this.value)" class="form-control" id="il">
                                <option value="0" disabled selected> İl seçimi</option>
                                @foreach ($iller as $il)
                                    <option value="{{ $il->id }}">{{ $il->ad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-lg">
                            <select name="ilce" onchange="ilceSelect(this.value)" class="form-control" id="ilce">
                                <option value="0" disabled selected> İlçe seçimi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="input-group input-group-lg">
                            <select name="okul" class="form-control" id="okul">
                                <option value="0" disabled selected> Okul seçimi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 d-grid">
                        <button class="btn btn-success" onclick="okulEkle()" type="button">Okul Ekle</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($kurumOkullar as $okul)
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <a class="block block-rounded text-center" onclick="okul({{ $okul->okul->id }})" href="javascript:void(0)">
                        <div
                            class="block-content block-content-full block-content-sm bg-primary border-bottom border-white-op">
                            <p class="fw-semibold text-white mb-0">{{ $okul->okul->ad }}</p>
                        </div>
                        <div class="block-content block-content-full bg-primary">
                            <img class="img-avatar img-avatar-thumb img-avatar-rounded"
                                src="{{ asset('assets/media/icons/school.png') }}" alt="">
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row g-sm">
                                <div class="col-6">
                                    <div class="item item-circle mb-3 mx-auto border border-primary border-2">
                                        <i class="fa fa-fw fa-graduation-cap text-primary"></i>
                                    </div>
                                    <p class="fs-sm fw-medium text-muted mb-0">
                                        @php
                                            $ogrencilerTotal = 0;
                                            foreach ($okul->siniflar as $key) {
                                                $ogrencilerTotal += $key->ogrenciler->count();
                                            }
                                        @endphp
                                        {{ $ogrencilerTotal }} Öğrenci
                                    </p>
                                </div>
                                <div class="col-6">
                                    <div class="item item-circle mb-3 mx-auto border border-primary border-2">
                                        <i class="fa fa-fw fa-chalkboard-user text-primary"></i>
                                    </div>
                                    <p class="fs-sm fw-medium text-muted mb-0">
                                        {{ $okul->siniflar->count() }} Sınıf
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
    <!-- END Page Content -->
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function okulEkle() {
            var okul_id = $('#okul').val();
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('okul_id', okul_id);
            $.ajax({
                url: '{{ route('kurum_okul_add') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Atama Yapıldı!',
                        text: res.message,
                        confirmButtonText: "Tamam"
                    }).then((result) => {
                        location.reload();
                    })
                },
                error: function(res) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: res.responseJSON.message,
                        confirmButtonText: "Tamam"
                    })
                }
            })
        }

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
                        $('#okul').empty();
                        var option2 = `<option value="0" selected disabled>Okul seçimi</option>`;
                        $('#okul').append(option2);
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

        function okul(id) {
            document.cookie = "okulsec=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "okulsec=" + id;
            location.href = "{{ route('kurum_sinif_index') }}";         
        }
    </script>
@endsection
