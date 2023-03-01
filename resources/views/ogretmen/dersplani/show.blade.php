@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="content">
        <div
            class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
            <div>
                <h1 class="h3 mb-1">
                    Ders : {{ $dersPlani->ders->ad }}
                </h1>
                <p class="fw-medium mb-0 text-muted">
                    Konu : {{ $dersPlani->konu }}
                </p>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded" id="dersBilgileri">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Ders Bilgileri
                </h3>
            </div>
            <div class="block-content">
                <div class="row items-push">
                    <div class="col-md-6">
                        <div class="block block-rounded block-bordered block-link-shadow h-100 mb-0">
                            <div class="block-content">
                                <table class="table table-borderless table-striped">
                                    <tbody>
                                        {{-- <tr>
                                            <td>
                                                <span class="text-warning">
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                    <i class="fa fa-fw fa-star"></i>
                                                </span>
                                                <span class="fw-medium text-muted">(790 oy)</span>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td class="fw-medium text-muted">
                                                <i class="fa fa-fw fa-building-flag me-1 text-primary"></i>
                                                {{ $kurum->unvan }}
                                            </td>
                                        </tr>
                                        @if ($dersPlani->sure)
                                            <tr>
                                                <td class="fw-medium text-muted">
                                                    <i class="fa fa-fw fa-clock me-1"></i> {{ $dersPlani->sure }} dakika
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($dersPlani->ogrenci_sayisi)
                                            <tr>
                                                <td class="fw-medium text-muted">
                                                    <i class="fa fa-fw fa-user-graduate me-1 "></i>
                                                    {{ $dersPlani->ogrenci_sayisi }} kişi
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-tags me-1"></i>
                                                @foreach ($siniflar as $sinif)
                                                    <span class="badge bg-primary">{{ $sinif . '. sınıf' }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($dersPlani->kazanimlar)
                        <div class="col-md-6">
                            <div class="block block-rounded block-bordered block-link-shadow h-100 mb-0">
                                <div class="block-content">
                                    {!! Str::markdown($dersPlani->kazanimlar) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($dersPlani->arac_gerec)
                        <div class="col-md-6">
                            <div class="block block-rounded block-bordered block-link-shadow h-100 mb-0">
                                <div class="block-content">
                                    {!! Str::markdown($dersPlani->arac_gerec) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($dersPlani->dersin_islenisi)
                        <div class="col-md-6">
                            <div class="block block-rounded block-bordered block-link-shadow h-100 mb-0">
                                <div class="block-content">
                                    {!! Str::markdown($dersPlani->dersin_islenisi) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- END Your Block -->
        <!-- Your Block -->
        <div class="block block-rounded" id="dersDosyalari">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Ders Dosyaları
                </h3>
            </div>
            <div class="block-content">
                <div class="row items-push">
                    @if ($dersPlaniFiles->count() <= 0)
                        <h3>Dosya Yok</h3>
                    @endif
                    @foreach ($dersPlaniFiles as $file)
                        <div class="col-sm-6 col-md-4 col-xl-3 d-flex flex-column">
                            <!-- Example File -->
                            <div class="options-container w-100 flex-grow-1 rounded bg-body d-flex align-items-center">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded block-transparent mb-0 w-100">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            @if ($file->extension == 'png' || $file->extension == 'jfif' || $file->extension == 'jpeg' || $file->extension == 'jpg')
                                                <img class="img-fluid"
                                                    src="{{ asset("uploads/ders_plani_dosyalari/$file->path") }}"
                                                    alt="">
                                            @endif
                                            @if ($file->extension == 'mp4' || $file->extension == 'wav')
                                                <i class="fa fa-fw fa-4x fa-file-video text-warning"></i>
                                            @endif
                                            @if ($file->extension == 'pdf')
                                                <i class="fa fa-fw fa-4x fa-file-pdf text-warning"></i>
                                            @endif
                                        </p>
                                        <p class="fw-semibold text-break mb-0">
                                            Dosya Numarası : {{ $file->id }}
                                        </p>
                                        <p class="fs-sm text-muted">
                                            @if ($file->extension == 'png' || $file->extension == 'jfif' || $file->extension == 'jpeg' || $file->extension == 'jpg')
                                                Görüntü
                                            @endif
                                            @if ($file->extension == 'mp4' || $file->extension == 'wav')
                                                Video
                                            @endif
                                            @if ($file->extension == 'pdf')
                                                PDF Belgesi
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay rounded bg-primary-dark-op">
                                    <div class="options-overlay-content">
                                        <div class="mb-3">
                                            <a class="btn btn-primary" target="_blank"
                                                href="{{ asset("uploads/ders_plani_dosyalari/$file->path") }}">
                                                <i class="fa fa-eye opacity-50 me-1"></i> Görüntüle
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-primary" download="dersDosyasi_{{ $file->id }}"
                                                href="{{ asset("uploads/ders_plani_dosyalari/$file->path") }}">
                                                <i class="fa fa-download me-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
