@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Talepler</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Examples</li>
                        <li class="breadcrumb-item active" aria-current="page">Blank</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
            </div>
            <div class="block-content">
                <div class="list-group fs-sm">
                    @if ($talepler->count() <= 0)
                        <span class="text-center mb-4">Talebiniz yok :( </span>
                    @endif
                    @foreach ($talepler as $talep)
                        <a class="list-group-item list-group-item-action mb-4" href="javascript:void(0)">
                            <div class="btn-group float-end">

                                <button type="button" class="btn btn-sm btn-alt-success js-bs-tooltip-enabled"
                                    data-bs-toggle="tooltip" aria-label="Edit">
                                    <i class="fa fa-check"></i> Kabul Et
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled"
                                    data-bs-toggle="tooltip" aria-label="Delete">
                                    <i class="fa fa-times"></i> Reddet
                                </button>
                            </div>
                            <p class="fs-6 fw-bold mb-0">
                                {{ $talep->kurum->unvan }}
                            </p>
                            <p class="text-muted mb-2">
                                {{ $talep->kurum->unvan }} size talep yolladı.
                            </p>
                            <p class="fs-sm text-muted mb-0">
                                <strong>{{ $talep->kurum_owner->user->ad . ' ' . $talep->kurum_owner->user->soyad }}</strong>,
                                {{ $talep->created_at->diffForHumans() }} <br>

                                <em class="text-muted">
                                    {{ date('d/m/Y H:i:s', strtotime($talep->created_at)) }}
                                </em>
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
