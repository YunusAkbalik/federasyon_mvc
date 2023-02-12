@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Dersler</h1>
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
                            <input type="text" name="yeniDersAdi" id="yeniDersAdi" placeholder="Ders Adı"
                                class="form-control">
                        </div>
                        <div onclick="dersEkle()" class="item item-circle bg-body-light">
                            <i class="fa fa-plus text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($dersler as $ders)
                <div class="col-xl-4 col-lg-6 col-md-6 ">
                    <a class="block block-rounded block-link-shadow" href="{{ route('kurum_ders_show',['id' => $ders->id]) }}">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <p class="fs-lg fw-semibold mb-0">
                                    {{ $ders->ad }}
                                </p>
                            </div>
                            <div class="item item-circle bg-body-light">
                                <i class="fa fa-book-open text-body-color"></i>
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
        function dersEkle() {
            var yeniDersAdi = $('#yeniDersAdi').val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('yeniDersAdi', yeniDersAdi);
            $.ajax({
                url: '{{ route('kurum_ders_add') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Ders Oluşturuldu!',
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
