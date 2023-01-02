@extends('layouts.backend')

@section('content')
    <!-- Hero -->

    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded" id="block">
            <div class="block-header block-header-default">

            </div>
            <div class="block-content">
                <div class="row justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="gsm_no" name="gsm_no"
                                        placeholder="ID veya Telefon Numarası">
                                    <button onclick="goSearch(this)" type="button" class="btn btn-primary">
                                        <i class="fa fa-search me-1"></i> Ara
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4" id="userDiv">
                           
                        </div>
                        <div class="mb-4" id="pwDiv">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        function copyData(e) {
            var copyText = document.getElementById("onePass");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            var newText = `<i class="fa fa-check me-1"></i> Kopyalandı!`
            $(e).html(newText)
            $(e).removeClass('btn-primary')
            $(e).addClass('btn-success')

        }

        function goSearch(e) {
            var search = $(e).prev().val()
            var fd = new FormData();
            fd.append('_token', $('input[name="_token"]').val());
            fd.append('search', search);
            $.ajax({
                url: '{{ route('admin_tek_kullanimlik_sifre_post') }}',
                method: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(res) {
                    Dashmix.block('state_loading', '#block');
                    $('#pwDiv').empty()
                    $('#userDiv').empty()
                    if (!res.error) {
                        var content = ` <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full bg-gd-sea">
                                    <img class="img-avatar img-avatar-thumb"
                                        src="{{ asset('assets/media/avatars/avatar11.jpg') }}" alt="">
                                </div>
                                <div class="block-content block-content-full">
                                    <p class="fw-semibold mb-0">${res.user.ad} ${res.user.soyad} </p>
                                    <span class="fs-sm fw-medium text-muted mb-0">Tek Kullanımlık Şifre : </span>
                                    <span class="fs-sm fw-large text-success mb-0">${res.onePass}</span>
                                </div>
                            </a>`;
                        $('#userDiv').append(content)
                        var pwContent = ` <div class="input-group input-group-lg">
                                <div class="input-group">
                                    <input type="text" value="${res.onePass}" readonly class="form-control" id="onePass"
                                        name="onePass">
                                    <button onclick="copyData(this)" type="button" class="btn btn-primary">
                                        <i class="fa fa-clipboard-list me-1"></i> Şifreyi Kopyala
                                    </button>
                                </div>
                            </div>`;
                        $('#pwDiv').append(pwContent)
                    } else {
                        var errorContent = ` <div class="block block-rounded bg-xplay text-white h-100 mb-0">
                                <div class="block-content text-center py-5">
                                    <p class="mb-4">
                                        <i class="fa fa-times fa-3x"></i>
                                    </p>
                                    <p class="fs-4 fw-bold mb-0">
                                        ${res.message}
                                    </p>
                                </div>
                            </div>`
                        $('#userDiv').append(errorContent)

                    }



                    Dashmix.block('state_normal', '#block');

                }
            })
        }
    </script>
@endsection
