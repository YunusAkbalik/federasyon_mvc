@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    @include('kurum.ogretmen.modals.atamaBekleyen')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Atama Bekleyen Öğretmenler</h1>
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
                    Block Title
                </h3>
            </div>
            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>Doğum Tarihi</th>
                            <th>Mezuniyet Okulu</th>
                            <th>Mezuniyet Bölümü</th>
                            <th>Mezuniyet Tarihi</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ogretmenler as $ogretmen)
                            <tr>
                                <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalHere"
                                        onclick="getData({{ $ogretmen->id }})">{{ $ogretmen->ozel_id }}</a> </td>
                                <td>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalHere"
                                        onclick="getData({{ $ogretmen->id }})">
                                        {{ $ogretmen->ad . ' ' . $ogretmen->soyad }}</a>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($ogretmen->dogum_tarihi)) }}</td>
                                <td>{{ $ogretmen->ogretmen_cv->okul }}</td>
                                <td>{{ $ogretmen->ogretmen_cv->bolum }}</td>
                                <td>{{ date('d/m/Y', strtotime($ogretmen->ogretmen_cv->mezun_tarihi)) }}</td>
                                <td>
                                    <h4 style="position: relative;
                                    margin: auto;"><span
                                            class="badge bg-{{ in_array($ogretmen->id, $talepler) ? 'primary' : 'success' }}"><i
                                                class="fa-solid fa-{{ in_array($ogretmen->id, $talepler) ? 'clock' : 'circle-check' }}"></i>
                                            {{ in_array($ogretmen->id, $talepler) ? 'Bekleniyor' : 'Müsait' }}</span>
                                    </h4>
                                </td>
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
    <script src="{{ asset('assets/js/pages/atamaBekleyenHocalar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
