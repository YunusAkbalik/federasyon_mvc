@extends('layouts.backend')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/roose/simplemde.min.css') }}">
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Ders Planı Oluştur</h1>

            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-content">
                <div class="row justify-content-center">
                    <div class="col xxl-8 col-xl-10 col-lg-12">
                        <form action="{{ route('kurum_dersPlani_insert') }}" method="POST" class="dersPlani" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <select name="ders_id" class="form-control" id="ders_id">
                                            @foreach ($dersler as $ders)
                                                <option value="{{ $ders->id }}">{{ $ders->ad }}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-label" for="example-select-floating">Ders <span
                                                class="text-danger">(*)</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <select class="js-select2 form-select" id="siniflar[]" name="siniflar[]"
                                        style="width: 100%;" data-placeholder="Sınıf Seçimi (*)" multiple>
                                        <option></option>
                                        @for ($i = 1; $i < 13; $i++)
                                            <option value="{{ $i }}">{{ $i }}. Sınıf</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="ogrenci_sayisi" name="ogrenci_sayisi"
                                            placeholder="Tavsiye Edilen Öğrenci Sayısı">
                                        <label class="form-label" for="ogrenci_sayisi">Tavsiye Edilen Öğrenci Sayısı</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="sure" name="sure"
                                            placeholder="Süre" value="40">
                                        <label class="form-label" for="sure">Süre (dk)</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="konu" name="konu"
                                            placeholder="Konu">
                                        <label class="form-label" for="konu">Konu <span
                                                class="text-danger">(*)</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <input type="file" class="form-control" id="ders_dosyalari"
                                        accept="image/png, image/jpeg, application/pdf, video/mp4,video/x-m4v,video/*"
                                        multiple name="ders_dosyalari[]">
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="kazanimlar" class="form-label">Kazanımlar</label>
                                    <textarea name="kazanimlar" id="kazanimlar" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="arac_gerec" class="form-label">Kullanılan Araç Gereçler</label>
                                    <textarea name="arac_gerec" id="arac_gerec" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="dersin_islenisi" class="form-label">Dersin İşlenişi <span
                                            class="text-danger">(*)</span></label>
                                    <textarea name="dersin_islenisi" id="dersin_islenisi" cols="30" rows="10">**Dersin İşlenişi**</textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Ders Planını Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/roose/simplemde.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dersPlaniForm.js') }}"></script>

    <script>
        Dashmix.helpersOnLoad(['jq-select2']);
        window.addEventListener('DOMContentLoaded', (event) => {
            var kazanimlar = new SimpleMDE({
                element: document.getElementById("kazanimlar")
            });
            var arac_gerec = new SimpleMDE({
                element: document.getElementById("arac_gerec")
            });
            var dersin_islenisi = new SimpleMDE({
                element: document.getElementById("dersin_islenisi")
            });
        });
    </script>
@endsection
