@extends('layouts.backend')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    
@endsection
@section('content')
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
        <div class="row mb-4">
            <div class="col-md-6">
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
            <div class="col-md-6">
                <a class="block block-rounded  text-center d-flex flex-column h-100 mb-0" href="javascript:void(0)">
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
                        <table></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

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
    </script>
@endsection
