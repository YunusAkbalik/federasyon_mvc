@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Ders Programı</h1>

            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">

            <div class="block-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Saat</th>
                                @foreach ($gunler as $gun)
                                    <th class="text-center {{ date('w') == $gun->id ? 'text-danger' : '' }}">
                                        {{ $gun->ad }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saatler as $saat)
                                <tr>
                                    <td style="vertical-align: middle">{{ $saat }}</td>
                                    @for ($i = 1; $i <= 7; $i++)
                                        @php
                                            $now = false;
                                            $currentDers = $dersProgrami
                                                ->where('baslangic', explode('-', $saat)[0])
                                                ->where('bitis', explode('-', $saat)[1])
                                                ->where('gun_id', $i)
                                                ->first();
                                            if ($suankiDers && $currentDers) {
                                              $now = $suankiDers->id == $currentDers->id ? true:false;
                                            }
                                        @endphp
                                        <td
                                            class="text-center {{ $currentDers ? ($now ? "text-success":($i == date('w') ? "text-danger":"" )):"" }}">
                                            {{ $currentDers ? $currentDers->ders->ad : '' }}
                                            @if ($currentDers)
                                                <br>
                                                <span class="text-muted">{{ $currentDers->sinif->ad }}</span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
