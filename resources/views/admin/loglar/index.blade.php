@extends('layouts.backend')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection



@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Loglar</h3>
                <div class="block-options">
                    <select onchange="categoryFilter(this.value)" class="js-select2 form-select" id="example-select2"
                        name="example-select2" style="width: 100%;" data-placeholder="Kategori Filtresi">
                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        <option value="0">Hepsini Göster</option>
                        @foreach ($logCategories as $logCategory)
                            <option
                                {{ $cid == $logCategory->id ? 'selected' : '' }}
                                onclick="" value="{{ $logCategory->id }}">{{ $logCategory->ad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="block-content">




                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Log</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td><i class="fa fa-solid fa-{{ $log->kategori->icon }}"></i></td>
                                <td> {{ $log->logText }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($log->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{ $logs->links() }}

            </div>
        </div>


    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        Dashmix.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-maxlength', 'jq-select2', 'jq-rangeslider',
            'jq-masked-inputs', 'jq-pw-strength'
        ]);
    </script>
    <script>
        function categoryFilter(id) {
            if (id != 0)
                location.href = "{{ route('admin_loglar') }}/" + id
            else
                location.href = "{{ route('admin_loglar') }}/"
        }
    </script>
@endsection
