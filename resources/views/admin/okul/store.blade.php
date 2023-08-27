@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded" id="createBlock">
            <div class="block-header block-header-default">
                <h3 class="block-title">Okul Ekle</h3>

            </div>
            <div class="block-content">
                <form class="js-validation" action="{{ route('okul.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="il_id" class="form-label">İl Seçimi</label>
                            <select onchange="getIlceler(this.value)" name="il_id" id="il_id" class="form-control mb-2">
                                <option value="0" selected disabled>Lütfen İl Seçin</option>
                                @foreach($iller as $il)
                                    <option value="{{$il->id}}">{{$il->ad}}</option>
                                @endforeach
                            </select>
                            <a href="#">İl Ekle</a>
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="ilce_id" class="form-label">İlçe Seçimi</label>
                            <select name="ilce_id" id="ilce_id" class="form-control mb-2">
                                <option value="0" selected disabled>Lütfen İlçe Seçin</option>
                            </select>
                            <a href="#">İlçe Ekle</a>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="okul_ad" class="form-label">Okul Adı</label>
                        <input type="text" id="okul_ad" name="okul_ad" class="form-control" placeholder="Okul Adı">
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-success">Oluştur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/admin_create_okul.js') }}"></script>
    <script>
    function getIlceler(id) {
        Dashmix.block('state_loading', '#createBlock')
        $('#ilce_id').empty()
        axios.request({
            method: 'POST',
            url: '{{route('getIlcelerFromIlID')}}',
            data: {
                id: id
            }
        }).then((r) => {
            r.data.data.forEach(function (item) {
                const option = `<option value="${item.id}">${item.ad}</option>`
                $('#ilce_id').append(option)
            })
            Dashmix.block('state_normal', '#createBlock')
        }).catch(e => {
            Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: 'İlçeler alınırken bir hata oluştu' })
            Dashmix.block('state_normal', '#createBlock')

        })
    }
    </script>
@endsection

