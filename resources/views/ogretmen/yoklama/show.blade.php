@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ $dersprogrami->first()->ders->ad }} Ders Yoklaması
                </h1>

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
                    Yoklama Al
                </h3>
                <div class="block-options">
                    <button type="button" onclick="$('#yoklama-form').submit()" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Yoklamayı Kaydet</button>
                </div>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle">Öğrenciler</th>
                                <th class="text-center">
                                    {{ $dersprogrami->first()->gun->ad }} - {{ date('d/m/Y') }}
                                    <br>
                                    <br>
                                    <table class="table table-bordered">
                                        <tr>
                                            @foreach ($dersprogrami as $item)
                                                <td>
                                                    {{ $item->baslangic }}
                                                    <br>
                                                    {{ $item->bitis }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="yoklama-form" action="{{ route('ogretmen_yoklama_al') }}" method="POST">
                                @csrf
                                @foreach ($dersprogrami->first()->sinif->ogrenciler as $ogrenci)
                                    <tr>
                                        <td>{{ $ogrenci->ogrenci->ad . ' ' . $ogrenci->ogrenci->soyad }}</td>
                                        <td class="text-center">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        @foreach ($dersprogrami as $item)
                                                            @php
                                                                $durum = true;
                                                                $yoklamaHere = $item->yoklama
                                                                    ->where('ogrenci_id', $ogrenci->ogrenci->id)
                                                                    ->where('tarih', date('Y-m-d'))
                                                                    ->first();
                                                                if ($yoklamaHere && $yoklamaHere->geldi == false) {
                                                                    $durum = false;
                                                                }
                                                            @endphp
                                                            <td><button onclick="durumDegistir(this)" type="button"
                                                                    class="btn {{ $durum ? 'btn-success' : 'btn-danger' }}"><i
                                                                        class="fa fa-{{ $durum ? 'check' : 'xmark' }}-circle"></i></button>
                                                                <input type="hidden" name="ogrenci_{{ $ogrenci->ogrenci->id }}_{{ $item->id }}"
                                                                    value="{{ $durum ? "1":"0" }}">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
         
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        function durumDegistir(e) {
            var durum_input = $(e).next()
            var button_input = $(e)
            if (durum_input.val() == 1) {
                button_input.html(`<i class="fa fa-xmark-circle"></i>`)
                button_input.removeClass('btn-success')
                button_input.addClass('btn-danger')
                durum_input.val(0)
            } else {
                button_input.html(`<i class="fa fa-check-circle"></i>`)
                button_input.addClass('btn-success')
                button_input.removeClass('btn-danger')
                durum_input.val(1)
            }
        }
    </script>
@endsection
