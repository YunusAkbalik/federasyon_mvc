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
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Kurumlar</h1>
                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Yeni Kurum Oluştur</button>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Kurumların Listesi
                </h3>
            </div>
            <div class="block-content">
               <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ünvan</th>
                        <th>Telefon</th>
                        <th>Yetkili Kişi</th>
                        <th>Yetkili Telefon</th>
                        <th>Whatsapp Hattı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kurumlar as $kurum)
                        <tr>
                            <td>{{ $kurum->id }}</td>
                            <td>{{ $kurum->unvan }}</td>
                            <td><a href="tel:{{ $kurum->telefon }}">{{ $kurum->telefon }}</a></td>
                            <td>{{ $kurum->yetkili_kisi }}</td>
                            <td><a href="tel:{{ $kurum->yetkili_telefon }}">{{ $kurum->yetkili_telefon }}</a></td>
                            <td><a href="tel:{{ $kurum->wp_hatti }}">{{ $kurum->wp_hatti }}</a></td>
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
    <script src="{{ asset('assets/js/pages/kurumlar.js') }}"></script>
@endsection
