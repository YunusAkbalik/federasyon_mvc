@extends('layouts.backend')
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}"> --}}
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Robotik Dersi</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Okuldan Öğrenci(ler) Seç
                        </h3>
                    </div>
                    <div class="block-content text-center">
                        <div class="mb-4">
                            <select class="form-control" name="ogretmenList" id="ogretmenList">
                                <option value="1">Ali Veli</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <button class="btn btn-alt-primary">Öğretmenleri Ata</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-6 mb-4">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">Dersin <small>Öğretmenleri</small></h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-bordered table-striped table-vcenter ">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">ID</th>
                                    <th>Ad Soyad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 100px;word-break: break-all;">999999</td>
                                    <td style="word-break: break-all;">Ali Veli</td>
                                </tr>
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
    {{-- <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/dersShowList.js') }}"></script> --}}
    <script>
      
    </script>
@endsection
