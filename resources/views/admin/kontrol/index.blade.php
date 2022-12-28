@extends('layouts.backend')
@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ $user->ad . ' ' . $user->soyad }}</h3>
            </div>
            <div class="block-content">
                <div class="row g-0 justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form class="js-validation-signup" action="{{ route('admin_kontrol_onay') }}" method="POST"
                            novalidate="novalidate">
                            @csrf
                            <div class="py-3">
                                <div class="mb-4">
                                    <input type="text" readonly="" class="form-control-plaintext" id="ID"
                                        name="ID" value="ID : {{ $user->ozel_id }}">
                                </div>
                                <div class="mb-4">
                                    <input type="text" class="form-control form-control-lg form-control-alt"
                                        id="tc" value="{{ $user->tc_kimlik }}" name="tc"
                                        placeholder="T.C Kimlik Numarası">
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="ad" value="{{ $user->ad }}" name="ad" placeholder="İsim">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <input type="text" class="form-control form-control-lg form-control-alt"
                                            id="soyad" value="{{ $user->soyad }}" name="soyad" placeholder="Soyisim">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <input type="tel" class="form-control form-control-lg form-control-alt"
                                            id="gsm_no" value="{{ $user->gsm_no }}" name="gsm_no"
                                            placeholder="Telefon Numarası">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <input type="email" class="form-control form-control-lg form-control-alt"
                                            id="email" value="{{ $user->email }}" name="email"
                                            placeholder="E-posta Adresi">
                                    </div>
                                </div>
                                @if ($user->hasRole('Öğrenci'))
                                    <hr>
                                    <p>Okul Bilgileri</p>
                                    <div class="row">
                                        <div class="col-xl-6 mb-4">
                                            <select class="form-control" onchange="ilSelect(this.value)" name="il"
                                                id="il">
                                                @foreach ($iller as $il)
                                                    <option {{ $user_il == $il->id ? 'selected' : '' }}
                                                        value="{{ $il->id }}">{{ $il->ad }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-6 mb-4">
                                            <select class="form-control" onchange="ilceSelect(this.value)" name="ilce"
                                                id="ilce">
                                                @foreach ($ilceler as $ilce)
                                                    <option
                                                        {{ $user->okul->okulDetails->ilce_id == $ilce->id ? 'selected' : '' }}
                                                        value="{{ $ilce->id }}">{{ $ilce->ad }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <select class="form-control" name="okul" id="okul">
                                            @foreach ($okullar as $okul)
                                                <option {{ $user->okul->okul_id == $okul->id ? 'selected' : '' }}
                                                    value="{{ $okul->id }}">{{ $okul->ad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 mb-4">
                                            <select class="form-control" name="sinif" id="sinif">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option {{ $user->okul->sinif == $i ? 'selected' : '' }}
                                                        value="{{ $i }}">{{ $i }}. sınıf</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-xl-4 mb-4">
                                            <select name="sube" class="form-control" id="sube">
                                                <option value="null">Şube Yok</option>
                                                @foreach (range('A', 'Z') as $item)
                                                    <option {{ $user->okul->sube == $item ? 'selected' : '' }}
                                                        value="{{ $item }}">{{ $item }} şubesi
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-4 mb-4">
                                            <input type="text" class="form-control" id="brans"
                                                value="{{ $user->okul->brans }}" name="brans" placeholder="Branş">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="mb-4">
                                <button type="submit" class="btn w-100 btn-lg btn-hero btn-success">
                                    <i class="fa fa-fw fa-check opacity-50 me-1"></i> Onayla
                                </button>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <a class="btn btn-sm btn-alt-danger d-block d-lg-inline-block mb-1" href="#"
                                        data-bs-toggle="modal" data-bs-target="#reddet">
                                        <i class="fa fa-times opacity-50 me-1"></i> Reddet
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="reddet" tabindex="-1" role="dialog" aria-labelledby="reddet"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Reddet</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form class="js-validation-signup" action="{{ route('admin_kontrol_reddet') }}" method="POST"
                                novalidate="novalidate">
                                @csrf
                                <div class="py-3">
                                    <div class="mb-4">
                                        <textarea name="ret_nedeni" id="ret_nedeni" cols="3" class="form-control" placeholder="Ret Nedeni..."
                                            rows="3"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="mb-4">
                                    <button type="submit" class="btn w-100 btn-lg btn-hero btn-danger">
                                        <i class="fa fa-fw fa-times opacity-50 me-1"></i> Reddet
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">İptal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/kontrol.js') }}"></script> --}}
    <script>
        function ilSelect(id) {
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            $.ajax({
                url: "{{ route('getIlcelerFromIlID') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        Dashmix.block('state_loading', '#signblock');
                        $('#ilce').empty();
                        $('#okul').empty();
                        var option = `<option value="0" selected disabled>İlçe seçimi</option>`;
                        $('#ilce').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#ilce').append(option)
                        });
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }

        function ilceSelect(id) {
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('id', id);
            $.ajax({
                url: "{{ route('getOkullarFromIlceID') }}",
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error) {
                        Dashmix.helpers('jq-notify', {
                            type: 'danger',
                            icon: 'fa fa-times me-1',
                            align: 'center',
                            message: res.message
                        });
                    } else {
                        Dashmix.block('state_loading', '#signblock');
                        $('#okul').empty();
                        var option = `<option value="0" selected disabled>Okul seçimi</option>`;
                        $('#okul').append(option);
                        res.data.forEach(element => {
                            var option = `<option value="${element.id}">${element.ad}</option>`;
                            $('#okul').append(option)
                        });
                        Dashmix.block('state_normal', '#signblock');
                    }
                }
            })
        }
    </script>
@endsection
