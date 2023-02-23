@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    @include('kurum.siniflar.modals.ogrenciEkle')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ $sinif->ad }}</h1>

            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1">
                        <div class="item rounded-3 bg-body mx-auto my-3">
                            <i class="fa fa-plus fa-lg text-success"></i>
                        </div>
                        <div class="fw-semibold mt-3 text-uppercase">Sınıfa Öğrenci Ekle</div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 ">
                                <input type="number" name="tc" placeholder="T.C Kimlik veya ID" id="tc"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6">
                                <button onclick="ogrenciEkleTc({{ $sinif->id }})"
                                    class="btn btn-outline-success">Öğrenciyi Ekle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <!-- Your Block -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Okuldan Öğrenci(ler) Seç
                        </h3>
                    </div>
                    <div class="block-content text-center">
                        <div class="mb-4">
                            <select class="form-control" name="okulList" id="okulList">
                                @foreach ($kurumOkullar as $okul)
                                    <option value="{{ $okul->okul->id }}">{{ $okul->okul->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <button onclick="ogrencileriGetir()" class="btn btn-alt-primary">Öğrencileri Getir</button>
                        </div>
                        <div class="mb-4">
                            <a class="btn btn-alt-success"
                                href="{{ route('kurum_hesapOlustur_ogrenci', ['sinif' => $sinif->id]) }}"><i
                                    class="fa fa-user-plus"></i> Öğrenci Oluştur</a>

                        </div>

                    </div>
                </div>
                <!-- END Your Block -->
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="dersSelect" class="form-label">Ders</label>
                                <select name="dersSelect" class="form-control" id="dersSelect">
                                    @foreach ($dersler as $ders)
                                        <option value="{{ $ders->id }}">{{ $ders->ad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="gunSelect" class="form-label">Gün</label>
                                <select name="gunSelect" class="form-control" id="gunSelect">
                                    @foreach ($gunler as $gun)
                                        <option value="{{ $gun->id }}">{{ $gun->ad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="dersBaslangic">Başlangıç</label>
                                <input type="text" class="js-masked-time form-control" id="dersBaslangic"
                                    name="dersBaslangic" placeholder="00:00">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="dersBitis">Bitiş</label>
                                <input type="text" class="js-masked-time form-control" id="dersBitis" name="dersBitis"
                                    placeholder="00:00">
                            </div>
                            <div class="col-12 mb-4">
                                <label for="ogretmenSelect" class="form-label">Öğretmen</label>
                                <select name="ogretmenSelect" class="form-control" id="ogretmenSelect">
                                    @foreach ($ogretmenler as $ogretmen)
                                        <option value="{{ $ogretmen->ogretmen->id }}">
                                            {{ $ogretmen->ogretmen->ad . ' ' . $ogretmen->ogretmen->soyad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-4 d-grid">
                                <button onclick="dersProgramiEkle()" class="btn btn-alt-success">Oluştur</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Block Tabs Animated Slide Up -->
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="btabs-animated-slideup-home-tab" data-bs-toggle="tab"
                                data-bs-target="#btabs-animated-slideup-home" role="tab"
                                aria-controls="btabs-animated-slideup-home" aria-selected="true">Ders Programı</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-animated-slideup-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#btabs-animated-slideup-profile" role="tab"
                                aria-controls="btabs-animated-slideup-profile" aria-selected="false">Öğrenci
                                Listesi</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="yoklama-tab" data-bs-toggle="tab" data-bs-target="#yoklama"
                                role="tab" aria-controls="yoklama" aria-selected="false">Yoklama</button>
                        </li>

                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel"
                            aria-labelledby="btabs-animated-slideup-home-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Saat</th>
                                        @foreach ($gunler as $gun)
                                            <th class="text-center">{{ $gun->ad }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saatler as $saat)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $saat }}</td>
                                            @for ($i = 1; $i <= 7; $i++)
                                                @php
                                                    $currentDers = $dersProgrami
                                                        ->where('baslangic', explode('-', $saat)[0])
                                                        ->where('gun_id', $i)
                                                        ->first();
                                                @endphp
                                                <td class="text-center">{{ $currentDers ? $currentDers->ders->ad : '' }}
                                                    @if ($currentDers)
                                                        <br>
                                                        <span
                                                            class="text-muted">{{ $currentDers->ogretmen->ad . ' ' . $currentDers->ogretmen->soyad }}</span>
                                                    @endif
                                                </td>
                                            @endfor

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel"
                            aria-labelledby="btabs-animated-slideup-profile-tab" tabindex="0">
                            <div class="block">
                                <div class="block-header">
                                    <h3 class="block-title">Öğrenci <small>Listesi</small></h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Ad Soyad</th>
                                                <th>Okul</th>
                                                <th>Sınıf</th>
                                                <th>Şube</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ogrenciler as $ogrenci)
                                                <tr>
                                                    <td>{{ $ogrenci->ogrenci->ozel_id }}</td>
                                                    <td>{{ $ogrenci->ogrenci->ad . ' ' . $ogrenci->ogrenci->soyad }}</td>
                                                    <td>{{ $ogrenci->okul->okulDetails->ad }}</td>
                                                    <td>{{ $ogrenci->okul->sinif . '. sınıf' }}</td>
                                                    <td class="{{ $ogrenci->okul->sube ? '' : 'text-danger' }}">
                                                        {{ $ogrenci->okul->sube ? $ogrenci->okul->sube . ' şubesi' : 'YOK' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button onclick="ogrenciCikar({{ $ogrenci->ogrenci->id }})"
                                                                type="button"
                                                                class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled"
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
                        <div class="tab-pane fade fade-up" id="yoklama" role="tabpanel" aria-labelledby="yoklama-tab"
                            tabindex="0">
                            <div class="block">
                                <div class="block-header">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 mb-4">
                                                <label for="yoklama-tarih" class="visually-hidden">Tarih:</label>
                                                <input type="date" name="yoklama-tarih" value="{{ now()->format('Y-m-d') }}" class="form-control"
                                                    id="yoklama-tarih">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <label for="yoklama-ders" class="visually-hidden">Ders:</label>
                                                <select name="yoklama-ders" class="form-control" id="yoklama-ders">
                                                    <option value="1">Test Ders 1</option>
                                                    <option value="2">Test Ders 2</option>
                                                    <option value="2">Test Ders 3</option>
                                                    <option value="2">Test Ders 4</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <button class="btn btn-primary">Filtrele</button>
                                                <button class="btn btn-success">Kaydet</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="block-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Öğrenci</th>
                                                    <th class="text-center">Pazartesi 
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Salı
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Çarşamba
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Perşembe
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Cuma
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Cumartesi
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                    <th class="text-center">Pazar
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>1</td>
                                                                <td>2</td>
                                                                <td>3</td>
                                                            </tr>
                                                        </table>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < 20; $i++)
                                                    <tr>
                                                        <td>Ali</td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered ">
                                                                <tr>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="text-center">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                   <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-success dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-check"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-danger dropdown-toggle"
                                                                                id="dropdown-default-alt-success"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button type="button"
                                                                                class="btn btn-alt-secondary dropdown-toggle"
                                                                                id="dropdown-default-alt-primary"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                <i class="fa-solid fa-circle-question"></i>
                                                                            </button>
                                                                           <div class="dropdown-menu"
                                                                                aria-labelledby="dropdown-default-alt-primary">
                                                                                <a class="dropdown-item text-success"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-check"></i> Geldi</a>
                                                                                <a class="dropdown-item text-danger"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-xmark"></i> Gelmedi</a>
                                                                                <a class="dropdown-item text-secondary"
                                                                                    href="javascript:void(0)"><i class="fa-solid fa-circle-question"></i> Bilinmiyor</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>


                                                    </tr>
                                                @endfor

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Block Tabs Animated Slide Up -->
            </div>
        </div>
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
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/sinifOgrenciList.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['jq-masked-inputs']);
    </script>
    <script>
        function ogrenciEkleTc(sinif_id) {
            var tc = $('#tc').val();
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('tc', tc);
            fd.append('sinif_id', sinif_id);
            $.ajax({
                url: '{{ route('kurum_sinif_add_ogrenci_tc') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Öğrenci eklendi!',
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

        function ogrencileriGetir() {
            Dashmix.layout('header_loader_on');
            var id = $('#okulList').val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            fd.append('sinif', "{{ $sinif->id }}");

            $.ajax({
                url: '{{ route('kurum_getData_ogrenci_from_school') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#accordion2').empty()
                    if (res.data.length != 0) {
                        var siniflar = []
                        res.data.forEach(element => {
                            if (!siniflar.includes(element.sinif))
                                siniflar.push(element.sinif)
                        });
                        siniflar.sort()
                        // SINIFLARI YAZDIR
                        siniflar.forEach(element => {
                            var yenisinif = ` <div  class="block block-rounded mb-1">
                           <div class="block-header block-header-default" role="tab" id="accordion2_h1">
                               <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion2"
                                   href="#accordion2_q${element}" aria-expanded="true" aria-controls="accordion2_q${element}">${element}.
                                   Sınıf</a>
                           </div>
                           <div id="accordion2_q${element}" class="collapse" role="tabpanel" aria-labelledby="accordion2_h1">
                               <div id="sinif_${element}" class="block-content">
                                 
                               </div>
                           </div>
                       </div>`;
                            $('#accordion2').append(yenisinif)
                        });
                        var subeler = []
                        siniflar.forEach(element => {
                            subeler = []
                            res.data.forEach(x => {
                                if (x.sinif == element) {
                                    if (!subeler.includes(x.sube)) {
                                        subeler.push(x.sube)
                                    }
                                }
                            });
                            subeler.forEach(x => {
                                var sube = `     <div class="block block-rounded mb-1">
                                        <div class="block-header block-header-default" role="tab"
                                            id="accordion2_h1">
                                            <a class="fw-semibold" data-bs-toggle="collapse"
                                                data-bs-parent="#accordion2" href="#accordion2_q${element}_${x}"
                                                aria-expanded="true" aria-controls="accordion2_q${element}_${x}">${x != "null" ? x+" Şubesi":"Şube YOK"}</a>
                                        </div>
                                        <div id="accordion2_q${element}_${x}" class="collapse" role="tabpanel"
                                            aria-labelledby="accordion2_h1">
                                            <div id="sinif_${element}_sube_${x}" class="block-content">
                                                
                                            </div>
                                        </div>
                                    </div>`
                                $(`#sinif_${element}`).append(sube)
                                res.data.forEach(xx => {
                                    var siniftaOgrenci = false;
                                    res.siniftakiler.forEach(sinifta => {
                                        if (xx.ogrenci_id == sinifta
                                            .ogrenci_id) {
                                            siniftaOgrenci = true
                                        }
                                    });
                                    if (xx.sinif == element && xx.sube == x) {
                                        var ogrenciInput = ` <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="${xx.ogrenci_id}"
                                                        id="ogrenci_${xx.ogrenci_id}" ${siniftaOgrenci ? "checked":""} name="ogrenci[]"
                                                        >
                                                    <label class="form-check-label"
                                                        for="ogrenci_${xx.ogrenci_id}">${xx.ogrenci.ad} ${xx.ogrenci.soyad}</label>
                                                </div>`
                                        $(`#sinif_${element}_sube_${x}`).append(
                                            ogrenciInput)

                                    }
                                });
                            });

                        });
                        $('#ogrenci-ekle').modal('show')
                    } else {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            message: "Okulda öğrenci bulunmuyor."
                        });
                    }
                    Dashmix.layout('header_loader_off');

                },
                error: function(res) {
                    Dashmix.helpers('jq-notify', {
                        type: 'danger',
                        icon: 'fa fa-times me-1',
                        message: res.responseJSON.message
                    });
                    Dashmix.layout('header_loader_off');
                }
            })
        }

        function sendData() {
            var values = $("input[name='ogrenci[]']")
                .map(function() {
                    var obj = {
                        "id": $(this).val(),
                        "durum": $(this).is(':checked')
                    }
                    return obj;
                }).get();
            values = JSON.stringify(values)
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('values', values);
            fd.append('sinif', "{{ $sinif->id }}");

            $.ajax({
                url: '{{ route('kurum_sinif_toplu_ekle_ogrenci') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
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
                    }).then((result) => {
                        location.reload();
                    })
                }
            })
        }

        function ogrenciCikar(id) {
            Swal.fire({
                title: 'Emin Misiniz?',
                text: "Öğrenci sınıftan çıkarılacak!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, çıkar!',
                cancelButtonText: 'İptal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var fd = new FormData();
                    fd.append('_token', $('input[name="_token"]').val());
                    fd.append('id', id);
                    fd.append('sinif', {{ $sinif->id }});
                    $.ajax({
                        url: '{{ route('kurum_sinif_remove') }}',
                        method: 'post',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Öğrenci Çıkarıldı!',
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
                            }).then((result) => {
                                location.reload();
                            })
                        }
                    })
                }
            })
        }

        function dersProgramiEkle() {
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('ders_id', $('#dersSelect').val());
            fd.append('gun_id', $('#gunSelect').val());
            fd.append('baslangic', $('#dersBaslangic').val());
            fd.append('bitis', $('#dersBitis').val());
            fd.append('ogretmen_id', $('#ogretmenSelect').val());
            fd.append('sinif_id', {{ $sinif->id }});
            $.ajax({
                url: '{{ route('kurum_sinif_dersProgrami_create') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
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
