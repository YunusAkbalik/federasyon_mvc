@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    @include('kurum.siniflar.modals.ogrenciEkle')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ $sinif->ad }}</h1>

            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-plus fa-lg text-success"></i>
                        </div>
                        <div class="fw-semibold mt-3 text-uppercase">Sınıfa Öğrenci Ekle</div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 ">
                                <input type="number" name="tc" placeholder="T.C Kimlik veya ID" id="tc"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6">
                                <button onclick="ogrenciEkleTc({{ $sinif->id }})"
                                    class="btn btn-outline-success">Öğrenciyi Ekle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <!-- Your Block -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Okuldan Öğrenci(ler) Seç
                        </h3>
                    </div>
                    <div class="block-content text-center">
                        <div class="mb-4">
                            <select class="form-control" name="okulList" id="okulList">
                                @foreach ($kurumOkullar as $okul)
                                    <option value="{{ $okul->okul->id }}">{{ $okul->okul->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <button onclick="ogrencileriGetir()" class="btn btn-alt-primary">Öğrencileri Getir</button>
                        </div>

                    </div>
                </div>
                <!-- END Your Block -->
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <a class="block block-rounded  text-center d-flex flex-column h-100 mb-0"
                    href="{{ route('kurum_hesapOlustur_ogrenci', ['sinif' => $sinif->id]) }}">
                    <div
                        class="block-content  block-content-full flex-grow-1 d-flex justify-content-center align-items-center">
                        <div>
                            <i class="fa fa-clipboard-list fa-2x  text-success"></i>
                            <div class="fw-semibold mt-3 text-uppercase">Öğrenci Kayıt Et</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">Öğrenci <small>Listesi</small></h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad Soyad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ogrenciler as $ogrenci)
                                    <tr>
                                        <td>{{ $ogrenci->ogrenci->ozel_id }}</td>
                                        <td>{{ $ogrenci->ogrenci->ad . ' ' . $ogrenci->ogrenci->soyad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/sinifOgrenciList.js') }}"></script>
    <script>
        function ogrenciEkleTc(sinif_id) {
            var tc = $('#tc').val();
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('tc', tc);
            fd.append('sinif_id', sinif_id);
            $.ajax({
                url: '{{ route('kurum_sinif_add_ogrenci_tc') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Öğrenci eklendi!',
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

        function ogrencileriGetir() {
            Dashmix.layout('header_loader_on');
            var id = $('#okulList').val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            fd.append('sinif', "{{ $sinif->id }}");

            $.ajax({
                url: '{{ route('kurum_getData_ogrenci_from_school') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#accordion2').empty()
                    if (res.data.length != 0) {
                        var siniflar = []
                        res.data.forEach(element => {
                            if (!siniflar.includes(element.sinif))
                                siniflar.push(element.sinif)
                        });
                        siniflar.sort()
                        // SINIFLARI YAZDIR
                        siniflar.forEach(element => {
                            var yenisinif = ` <div  class="block block-rounded mb-1">
                           <div class="block-header block-header-default" role="tab" id="accordion2_h1">
                               <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion2"
                                   href="#accordion2_q${element}" aria-expanded="true" aria-controls="accordion2_q${element}">${element}.
                                   Sınıf</a>
                           </div>
                           <div id="accordion2_q${element}" class="collapse" role="tabpanel" aria-labelledby="accordion2_h1">
                               <div id="sinif_${element}" class="block-content">
                                 
                               </div>
                           </div>
                       </div>`;
                            $('#accordion2').append(yenisinif)
                        });
                        var subeler = []
                        siniflar.forEach(element => {
                            subeler = []
                            res.data.forEach(x => {
                                if (x.sinif == element) {
                                    if (!subeler.includes(x.sube)) {
                                        subeler.push(x.sube)
                                    }
                                }
                            });
                            subeler.forEach(x => {
                                var sube = `     <div class="block block-rounded mb-1">
                                        <div class="block-header block-header-default" role="tab"
                                            id="accordion2_h1">
                                            <a class="fw-semibold" data-bs-toggle="collapse"
                                                data-bs-parent="#accordion2" href="#accordion2_q${element}_${x}"
                                                aria-expanded="true" aria-controls="accordion2_q${element}_${x}">${x} Şubesi</a>
                                        </div>
                                        <div id="accordion2_q${element}_${x}" class="collapse" role="tabpanel"
                                            aria-labelledby="accordion2_h1">
                                            <div id="sinif_${element}_sube_${x}" class="block-content">
                                                
                                            </div>
                                        </div>
                                    </div>`
                                $(`#sinif_${element}`).append(sube)
                                res.data.forEach(xx => {
                                    var siniftaOgrenci = false;
                                    res.siniftakiler.forEach(sinifta => {
                                        if(xx.ogrenci_id == sinifta.ogrenci_id){
                                            siniftaOgrenci = true
                                        }
                                    });
                                    if (xx.sinif == element && xx.sube == x) {
                                        var ogrenciInput = ` <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="${xx.ogrenci_id}"
                                                        id="ogrenci_${xx.ogrenci_id}" ${siniftaOgrenci ? "checked":""} name="ogrenci[]"
                                                        >
                                                    <label class="form-check-label"
                                                        for="ogrenci_${xx.ogrenci_id}">${xx.ogrenci.ad} ${xx.ogrenci.soyad}</label>
                                                </div>`
                                        $(`#sinif_${element}_sube_${x}`).append(
                                            ogrenciInput)

                                    }
                                });
                            });

                        });
                        $('#ogrenci-ekle').modal('show')
                    } else {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            message: "Okulda öğrenci bulunmuyor."
                        });
                    }
                    Dashmix.layout('header_loader_off');

                },
                error: function(res) {
                    Dashmix.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: res.responseJSON.message
                    });
                    Dashmix.layout('header_loader_off');
                }
            })
        }

        function sendData() {
            var values = $("input[name='ogrenci[]']")
                .map(function() {
                    var obj = {
                        "id": $(this).val(),
                        "durum": $(this).is(':checked')
                    }
                    return obj;
                }).get();
            values = JSON.stringify(values)
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('values', values);
            fd.append('sinif', "{{ $sinif->id }}");

            $.ajax({
                url: '{{ route('kurum_sinif_toplu_ekle_ogrenci') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
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
                    }).then((result) => {
                        location.reload();
                    })
                }
            })
        }
    </script>
@endsection
