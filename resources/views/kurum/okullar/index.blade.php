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
        <div class="input-group mb-4">
            <input list="okul" id="yeni_okul" placeholder="Okul Adı" class="form-control">
            <datalist id="okul">
                @foreach ($tumOkullar as $okul)
                    <option value="{{ $okul->ad }}">
                @endforeach
            </datalist>
            <button type="button" onclick="okulEkle()" class="btn btn-success">
                Okul Ekle <i class="fa fa-plus me-1"></i>
            </button>
        </div>
        <div class="row">
            @foreach ($kurumOkullar as $okul)
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <a class="block block-rounded text-center" href="javascript:void(0)">
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
                                        0 Öğrenci
                                    </p>
                                </div>
                                <div class="col-6">
                                    <div class="item item-circle mb-3 mx-auto border border-primary border-2">
                                        <i class="fa fa-fw fa-chalkboard-user text-primary"></i>
                                    </div>
                                    <p class="fs-sm fw-medium text-muted mb-0">
                                        0 Sınıf
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
            var ad = $('#yeni_okul').val();
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('ad', ad);
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
    </script>
@endsection
