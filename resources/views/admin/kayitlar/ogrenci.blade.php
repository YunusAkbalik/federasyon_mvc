@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Öğrenci Listesi</h1>

            </div>
        </div>
    </div>
    <!-- END Hero -->

    @include('admin.kayitlar.ogrenciModal')
    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
            </div>
            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>T.C Kimlik</th>
                            <th>Okul</th>
                            <th>Kayıt Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ogrenciler as $ogrenci)
                            <tr>
                                <td> <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#modalHere">{{ $ogrenci->ozel_id }}</a></td>
                                <td>{{ $ogrenci->ad . ' ' . $ogrenci->soyad }}</td>
                                <td>{{ $ogrenci->tc_kimlik }}</td>
                                <td>{{ $ogrenci->okul->okulDetails->ad }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($ogrenci->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Your Block -->
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
    <script src="{{ asset('assets/js/pages/kayitlar.js') }}"></script>
@endsection
