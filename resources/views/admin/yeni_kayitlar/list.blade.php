@extends('layouts.backend')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <span class="nav-main-link-badge badge rounded-pill bg-primary">{{ $ogrenciler->count() }}</span>
                &nbsp;
                <h3 class="block-title">Öğrenciler</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="content_toggle"></button>
                </div>
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
                            <th class="text-center" style="max-width: 100px">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ogrenciler as $ogrenci)
                            <tr>
                                <td>{{ $ogrenci->ozel_id }}</td>
                                <td>{{ $ogrenci->ad . ' ' . $ogrenci->soyad }}</td>
                                <td>{{ $ogrenci->tc_kimlik }}</td>
                                <td>{{ $ogrenci->okul->okulDetails->ad }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($ogrenci->created_at)) }}</td>
                                <td class="text-center" style="max-width: 100px">
                                    <div class="btn-group">
                                        <a href="{{ route('admin_kontrol', ['ozel_id' => $ogrenci->ozel_id]) }}"
                                            class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                            data-bs-toggle="tooltip" aria-label="Kontrol Et">
                                            Kontrol Et
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <span class="nav-main-link-badge badge rounded-pill bg-primary">{{ $veliler->count() }}</span>
                &nbsp;
                <h3 class="block-title">Veliler</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                        data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>T.C Kimlik</th>
                            <th>Telefon Numarası</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($veliler as $veli)
                            <tr>
                                <td>{{ $veli->ozel_id }}</td>
                                <td>{{ $veli->ad . ' ' . $veli->soyad }}</td>
                                <td>{{ $veli->tc_kimlik }}</td>
                                <td><a href="tel:{{ $veli->gsm_no }}">{{ $veli->gsm_no }}</a></td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($veli->created_at)) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin_kontrol', ['ozel_id' => $veli->ozel_id]) }}"
                                            class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                            data-bs-toggle="tooltip" aria-label="Kontrol Et">
                                            Kontrol Et
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Page JS Plugins -->
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
    <!-- Page JS Code -->
    <script src="{{ asset('assets/js/pages/yeni-kayitlar.js') }}"></script>
@endsection
