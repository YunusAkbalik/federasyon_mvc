@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Sınıflar</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sınıf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siniflar as $sinif)
                            <tr>
                                <td>{{ $sinif[1] }}</td>
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
