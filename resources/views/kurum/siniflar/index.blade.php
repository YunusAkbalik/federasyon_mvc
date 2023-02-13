@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Sınıflar</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <select onchange="getSinif()" class="form-control" name="okullar" id="okullar">
                        @foreach ($kurumOkullar as $okul)
                            <option value="{{ $okul->id }}">{{ $okul->ad }}</option>
                        @endforeach
                    </select>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div id="content" class="row justify-content-center">
            <div class="col-xl-4 col-lg-6 col-md-6 ">
                <div class="block block-rounded block-link-shadow">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <input type="text" name="yeniSinifAd" id="yeniSinifAd" placeholder="Sınıf Adı"
                                class="form-control">
                        </div>
                        <div onclick="sinifEkle()" class="item item-circle bg-body-light">
                            <i class="fa fa-plus text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 ">
                <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                        <div class="me-3">
                            <p class="fs-lg fw-semibold mb-0">
                                Çilekler Sınıfı
                            </p>
                            <p class="text-muted mb-0">
                                17 Öğrenci
                            </p>
                        </div>
                        <div class="item item-circle bg-body-light">
                            <i class="fa fa-users-rectangle text-body-color"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
       
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        function sinifEkle() {
            var yeniSinifAd = $('#yeniSinifAd').val()
            var okul_id = $('#okullar').val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('okul_id', okul_id);
            fd.append('yeniSinifAd', yeniSinifAd);
            $.ajax({
                url: '{{ route('kurum_sinif_add') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sınıf Oluşturuldu!',
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
        window.addEventListener('DOMContentLoaded', (event) => {
            var okulsec = getCookie('okulsec')
            console.log(okulsec);
            if (okulsec != null && okulsec != "null") {
                if (okulsec != $('#okullar').val()) {
                    $('#okullar').val(okulsec)
                    getSinif()
                } else {
                    getSinif()
                }
            } else {
                getSinif()
            }
        });

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return null;
        }

        function getSinif() {
            Dashmix.layout('header_loader_on');
            $('#content').empty()
            var okul_id = $('#okullar').val()
            document.cookie = "okulsec=" + okul_id;
            $('#okullar').attr('disabled', 'disabled')
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('okul_id', okul_id);
            $.ajax({
                url: '{{ route('kurum_sinif_get') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    console.log(res);
                    var addContent = `<div class="col-xl-4 col-lg-6 col-md-6 ">
                        <div class="block block-rounded block-link-shadow">
                            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div class="me-3">
                                    <input type="text" name="yeniSinifAd" id="yeniSinifAd" placeholder="Sınıf Adı"
                                        class="form-control">
                                </div>
                                <div onclick="sinifEkle()" class="item item-circle bg-body-light">
                                    <i class="fa fa-plus text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>`
                    $('#content').append(addContent)
                    res.data.forEach(element => {
                        var content = `<div class="col-xl-4 col-lg-6 col-md-6 ">
                            <a class="block block-rounded block-link-shadow" href="sinif/${element.id}">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="me-3">
                                        <p class="fs-lg fw-semibold mb-0">
                                            ${element.ad}
                                        </p>
                                        <p class="text-muted mb-0">
                                            ${element.ogrenciler.length} Öğrenci
                                        </p>
                                    </div>
                                    <div class="item item-circle bg-body-light">
                                        <i class="fa fa-users-rectangle text-body-color"></i>
                                    </div>
                                </div>
                            </a>
                        </div>`;
                        $('#content').append(content)
                    });
                    Dashmix.layout('header_loader_off');
                    $('#okullar').removeAttr('disabled', 'disabled')


                },
                error: function(res) {
                    Dashmix.layout('header_loader_off');
                    if (res.responseJSON.message == "Okul bilgisi alınamadı") {
                        document.cookie = "okulsec=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        location.reload();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: res.responseJSON.message,
                            confirmButtonText: "Tamam"
                        }).then((result) => {
                            location.reload();
                        })
                    }


                }

            })

        }
    </script>
@endsection
