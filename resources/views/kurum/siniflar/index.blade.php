@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Sınıflar</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <select onchange="yonlendir(this.value)" class="form-control" name="okullar" id="okullar">
                        @foreach ($kurumOkullar as $kurumOkul)
                            <option {{ $okulExist ? ($okul->id == $kurumOkul->id ? 'selected' : '') : '' }}
                                value="{{ $kurumOkul->id }}">{{ $kurumOkul->ad }}</option>
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
        </div>
        <div class="row">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th>Sınıf Adı</th>
                        <th>Öğrenci Sayısı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siniflar as $sinif)
                        <tr>
                            <td><a href="{{ route('kurum_sinif_show', ['id' => $sinif->id]) }}">{{ $sinif->ad }}</a></td>
                            <td>{{ $sinif->ogrenciler->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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
    <script src="{{ asset('assets/js/pages/sinifIndex.js') }}"></script>
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

        function yonlendir(id) {
            location.href = "{{ route('kurum_sinif_index') }}/?okul=" + id
        }
    </script>
@endsection
