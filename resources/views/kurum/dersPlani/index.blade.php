@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Ders Planı</h1>
                <a href="{{ route('kurum_dersPlani_create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Ders Planı
                    Oluştur</a>
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
                    Ders Planları Listesi
                </h3>
            </div>
            <div class="block-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ders</th>
                            <th>Konu</th>
                            <th>Sınıf(lar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dersPlanlari as $dersPlani)
                            @php
                                $siniflar = '';
                                $siniflarArray = explode(',', $dersPlani->sinif);
                                foreach ($siniflarArray as $value) {
                                  $lastString = $value. ". sınıf <br>";
                                  $siniflar = $siniflar.$lastString;
                                }
                            @endphp
                            <tr>
                                <td>{{ $dersPlani->id }}</td>
                                <td>{{ $dersPlani->ders->ad }}</td>
                                <td>{{ $dersPlani->konu }}</td>
                                <td>{!! $siniflar !!}</td>
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
