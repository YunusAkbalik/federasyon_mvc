@extends('layouts.backend')
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}"> --}}
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ $ders->ad }}</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
       
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div id="AtamaBlock" class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Öğretmen(ler) Seç
                        </h3>
                    </div>
                    <div class="block-content text-center">

                        <div class="mb-4">
                            <select class="js-select2 form-select" id="ogretmenler_secim" name="ogretmenler_secim"
                                style="width: 100%;" data-placeholder="Seçim Yap" multiple>
                                <option></option>
                                @foreach ($ogretmenler as $ogretmen)
                                    @if ($ogretmen->ders == null || $ogretmen->ders->ders_id != $ders->id)
                                        <option value="{{ $ogretmen->ogretmen->id }}">
                                            {{ $ogretmen->ogretmen->ad . ' ' . $ogretmen->ogretmen->soyad }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <button onclick="ogretmenleriAta()" class="btn btn-alt-primary">Öğretmenleri Ata</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-6 mb-4">
                <div id="ogretmenListBlock" class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Dersin <small>Öğretmenleri</small></h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-bordered table-striped table-vcenter ">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">ID</th>
                                    <th>Ad Soyad</th>
                                    <th class="text-center" style="width: 100px;">Sil</th>
                                </tr>
                            </thead>
                            <tbody id="ogretmenTableContent">
                                @foreach ($atanmisOgretmenler as $ogretmen)
                                    <tr>
                                        <td style="width: 100px;word-break: break-all;">
                                            {{ $ogretmen->ogretmen->ozel_id }}</td>
                                        <td style="word-break: break-all;">
                                            {{ $ogretmen->ogretmen->ad . ' ' . $ogretmen->ogretmen->soyad }}</td>
                                        <td class="text-center" style="width: 100px;">
                                            <div class="btn-group">
                                                <button type="button"
                                                    onclick="atamaSil({{ $ogretmen->ogretmen->id }},this)"
                                                    class="btn btn-sm btn-danger js-bs-tooltip-enabled"
                                                    data-bs-toggle="tooltip" aria-label="Delete">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
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
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-select2']);
    </script>
    <script>
        function ogretmenleriAta() {
            Dashmix.block('state_loading', '#AtamaBlock');
            Dashmix.block('state_loading', '#ogretmenListBlock');
            var ogretmenler = $('#ogretmenler_secim').val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('ogretmenler', ogretmenler);
            fd.append('ders', {{ $ders->id }});
            $.ajax({
                url: '{{ route('kurum_ders_atamayap') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Dashmix.helpers('jq-notify', {
                        type: 'success',
                        icon: 'fa fa-check me-1',
                        message: res.message
                    });
                    res.list.forEach(element => {
                        var tr = ` <tr>
                                            <td style="width: 100px;word-break: break-all;">
                                                ${element.ozel_id}</td>
                                            <td style="word-break: break-all;">
                                                ${element.ad_soyad}</td>
                                            <td class="text-center" style="width: 100px;">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        onclick="atamaSil(${element.id},this)"
                                                        class="btn btn-sm btn-danger js-bs-tooltip-enabled"
                                                        data-bs-toggle="tooltip" aria-label="Delete">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>`
                        $('#ogretmenTableContent').append(tr)
                    });
                    Dashmix.block('state_normal', '#AtamaBlock');
                    Dashmix.block('state_normal', '#ogretmenListBlock');
                },
                error: function(res) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: res.responseJSON.message,
                        confirmButtonText: "Tamam"
                    })
                    Dashmix.block('state_normal', '#AtamaBlock');
                    Dashmix.block('state_normal', '#ogretmenListBlock');
                }
            })
        }

        function atamaSil(id, e) {
            Swal.fire({
                title: 'Emin Misiniz?',
                text: "Bu işlem geri alınamaz!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Atamayı Kaldır!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Dashmix.block('state_loading', '#ogretmenListBlock');
                    var fd = new FormData();
                    fd.append('_token', $('input[name="_token"]').val());
                    fd.append('id', id);
                    fd.append('ders', {{ $ders->id }});

                    $.ajax({
                        url: '{{ route('kurum_ders_atamakaldir') }}',
                        method: 'post',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            Dashmix.helpers('jq-notify', {
                                type: 'success',
                                icon: 'fa fa-check me-1',
                                message: res.message
                            });
                            $(e).parent().parent().parent().remove()
                            Dashmix.block('state_normal', '#ogretmenListBlock');
                        },
                        error: function(res) {
                            Dashmix.helpers('jq-notify', {
                                type: 'danger',
                                icon: 'fa fa-times me-1',
                                message: res.responseJSON.message
                            });
                        }
                    })
                }
            })
        }
    </script>
@endsection
