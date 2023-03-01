@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Yoklama Seçimi</h1>

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
                                <th>{{ $gunler->where('id', date('w'))->first()->ad }}</th>
                                <th>Yoklama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saatler as $saat)
                                <tr>
                                    @php
                                        $now = false;
                                        $currentDers = $dersProgrami
                                            ->where('baslangic', explode('-', $saat)[0])
                                            ->where('bitis', explode('-', $saat)[1])
                                            ->first();
                                        if ($suankiDers && $currentDers) {
                                            $now = $suankiDers->id == $currentDers->id ? true : false;
                                        }
                                    @endphp
                                    <td class="{{ $now ? 'text-success':''}}" style="vertical-align: middle; ">{{ $saat }}</td>

                                    <td class="{{ $currentDers ? ($now ? 'text-success' : 'text-danger') : '' }}">
                                        {{ $currentDers ? $currentDers->ders->ad : '' }}
                                        @if ($currentDers)
                                            <br>
                                            <span class="text-muted">{{ $currentDers->sinif->ad }}</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle"><a
                                            href="{{ route('ogretmen_yoklama_show', ['id' => $currentDers->id]) }}"
                                            class="btn {{ $now ? 'btn-success':'btn-alt-success' }}">Yoklama Al</a></td>
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
