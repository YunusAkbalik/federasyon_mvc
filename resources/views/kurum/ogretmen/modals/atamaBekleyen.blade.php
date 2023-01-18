 <!-- Vertically Centered Block Modal -->
 <div class="modal" id="modalHere" tabindex="-1" role="dialog" aria-labelledby="modalHere" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
         <div class="modal-content">
             <div class="block block-rounded block-themed block-transparent mb-0" id="modalBlock">
                 <div class="block-header bg-primary-dark">
                     <h3 class="block-title">Öğretmen Bilgileri</h3>
                     <div class="block-options">

                         <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                             <i class="fa fa-fw fa-times"></i>
                         </button>
                     </div>
                 </div>
                 <div class="block-content mb-4">
                     <div class="container">
                         <div class="row justify-content-center" id="icerik">
                             {{-- <div class="col-xl-12">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary-darker text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-id-card text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Kişisel Bilgileri
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>ID</td>
                                                    <td><strong>${res.ogrenci.ozel_id}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Ad Soyad</td>
                                                    <td><strong>${res.ogrenci.ad} ${res.ogrenci.soyad}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>T.C Kimlik</td>
                                                    <td><strong>${res.ogrenci.tc_kimlik}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Doğum Tarihi</td>
                                                    <td><strong>${res.ogrenci.dogum_tarihi}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Kan Grubu</td>
                                                    <td><strong ${res.ogrenci.kan_grubu==null ? 'class="text-danger"'
                                                            :""}>${res.ogrenci.kan_grubu == null ?
                                                            'Yok':res.ogrenci.kan_grubu}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>GSM No</td>
                                                    <td><strong ${res.ogrenci.gsm_no==null ? 'class="text-danger"'
                                                            :""}>${res.ogrenci.gsm_no == null ?
                                                            'Yok':res.ogrenci.gsm_no}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>E-posta</td>
                                                    <td><strong ${res.ogrenci.email==null ? 'class="text-danger"'
                                                            :""}>${res.ogrenci.email == null ?
                                                            'Yok':res.ogrenci.email}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Kullanıcı Durumu</td>
                                                    <td><strong class="text-${durumClass}">${kullaniciDurumu}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-12">
                                <a class="block block-rounded bg-gd-sublime" href="javascript:void(0)">
                                    <div class="block-content block-content-full">
                                        <div class="row text-center">
                                            <div class="col-xl-4 col-md-6 border-end border-black-op">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-school text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        Nişantaşı Üniversitesi
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Okul
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6 border-end border-black-op">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-chalkboard-user text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        İlkokul Öğretmenlik
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Bölüm
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-calendar-days text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        2018-11-11
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Mezuniyet
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #1 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Tam Zamanlı
                                            </p>
                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-circle-check text-success"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #1 -->
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #2 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 50%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Yarı Zamanlı
                                            </p>
                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-circle-xmark text-danger"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #2 -->
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #3 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Uzaktan Eğitim
                                            </p>

                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-circle-check text-success"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #3 -->
                            </div>
                            <br>
                            <div class="col-xl-6 mt-4">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-scroll text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Sertifikalar
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <strong>Çok iyi öğretmen sertifikası</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <strong>Muhteşem öğretmen sertifikası</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <strong>ÜĞğf fena öğretmen sertifikası</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-4">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-briefcase text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Tecrübeler
                                        </p>

                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <strong>Güngören şehitler i.ö.o 5 sene tam zamanlı
                                                            çalıştım</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <strong>Ataşehir İMTEM lisesine 2 senedir aktif olarak uzaktan
                                                            eğitim veriyorum.</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}



                             {{-- <div class="col-6">
                               <a class="block text-center bg-xplay" href="javascript:void(0)">
                                   <div class="block-content block-content-full ratio ratio-16x9">
                                     <div class="d-flex justify-content-center align-items-center">
                                       <div>
                                         <i class="fa fa-2x fa-times text-danger-light"></i>
                                         <div class="fw-semibold mt-3 text-uppercase text-white">${res.message}</div>
                                       </div>
                                     </div>
                                   </div>
                                 </a>
                            </div> --}}

                         </div>
                     </div>
                 </div>
                 <div class="block-content block-content-full text-end bg-body" id="buttonsContent">
                     {{-- <button type="button" class="btn btn-sm btn-success" onclick="onayla(1)"
                        data-bs-dismiss="modal">Onayla</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="reddet_alert(1)">Reddet</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Kapat</button> --}}
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- END Vertically Centered Block Modal -->
 <script>
     function getData(id) {
         $('#icerik').empty()
         $('#buttonsContent').empty()
         Dashmix.block('state_loading', '#modalBlock');
         var fd = new FormData();
         fd.append('_token', $('input[name="_token"]').val());
         fd.append('id', id);
         $.ajax({
             url: '{{ route('kurum_ogretmen_bekleyenler_show') }}',
             method: 'post',
             data: fd,
             processData: false,
             contentType: false,
             success: function(res) {
                 if (res.talep) {
                     var buttons = ` <button type="button" class="btn btn-sm btn-success" disabled
                        data-bs-dismiss="modal">Talep Gönderildi</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Kapat</button>`
                 } else {
                     var buttons = ` <button type="button" class="btn btn-sm btn-success" onclick="talep(${id})"
                        data-bs-dismiss="modal">Talep Gönder</button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Kapat</button>`
                 }

                 var tamZamanli = false
                 var yariZamanli = false
                 var uzaktanEgitim = false
                 res.data.ogretmen_cv.calismasaatleri.forEach(element => {
                     if (element.calismaSaatleri == "Tam Zamanlı")
                         tamZamanli = true;
                     if (element.calismaSaatleri == "Yarı Zamanlı")
                         yariZamanli = true;
                     if (element.calismaSaatleri == "Uzaktan Eğitim")
                         uzaktanEgitim = true;
                 });
                 var sertifikalar = ""
                 var tecrubeler = ""
                 res.data.ogretmen_cv.sertifikalar.forEach(element => {
                     sertifikalar += `<tr>
                                                    <td class="text-center">
                                                        <strong>${element.sertifika}</strong>
                                                    </td>
                                                </tr>`
                 });
                 res.data.ogretmen_cv.oncekiisler.forEach(element => {
                     tecrubeler += `<tr>
                                                    <td class="text-center">
                                                        <strong>${element.isler}</strong>
                                                    </td>
                                                </tr>`
                 });


                 var content = `<div class="col-xl-12">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary-darker text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-id-card text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Kişisel Bilgileri
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>ID</td>
                                                    <td><strong>${res.data.ozel_id}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Ad Soyad</td>
                                                    <td><strong>${res.data.ad} ${res.data.soyad}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>T.C Kimlik</td>
                                                    <td><strong>${res.data.tc_kimlik}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Doğum Tarihi</td>
                                                    <td><strong>${res.data.dogum_tarihi}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Kan Grubu</td>
                                                    <td><strong ${res.data.kan_grubu==null ? 'class="text-danger"'
                                                            :""}>${res.data.kan_grubu == null ?
                                                            'Yok':res.data.kan_grubu}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>GSM No</td>
                                                    <td><strong ${res.data.gsm_no==null ? 'class="text-danger"'
                                                            :""}>${res.data.gsm_no == null ?
                                                            'Yok':res.data.gsm_no}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>E-posta</td>
                                                    <td><strong ${res.data.email==null ? 'class="text-danger"'
                                                            :""}>${res.data.email == null ?
                                                            'Yok':res.data.email}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-12">
                                <a class="block block-rounded bg-gd-sublime" href="javascript:void(0)">
                                    <div class="block-content block-content-full">
                                        <div class="row text-center">
                                            <div class="col-xl-4 col-md-6 border-end border-black-op">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-2x fa-school text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        ${res.data.ogretmen_cv.okul}
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Okul
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6 border-end border-black-op">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-2x fa-chalkboard-user text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        ${res.data.ogretmen_cv.bolum}
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Bölüm
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="py-3">
                                                    <div class="item item-circle bg-black-25 mx-auto">
                                                        <i class="fa fa-2x fa-calendar-days text-white"></i>
                                                    </div>
                                                    <p class="text-white fs-3 fw-medium mt-3 mb-0">
                                                        ${res.data.ogretmen_cv.mezun_tarihi}
                                                    </p>
                                                    <p class="text-white-75 mb-0">
                                                        Mezuniyet
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #1 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-${tamZamanli ? "success":"danger"}" role="progressbar" style="width: 100%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Tam Zamanlı
                                            </p>
                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-${tamZamanli ? "circle-check":"circle-xmark"} text-${tamZamanli ? "success":"danger"}"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #1 -->
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #2 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-${yariZamanli ? "success":"danger"}" role="progressbar" style="width: 50%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Yarı Zamanlı
                                            </p>
                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-${yariZamanli ? "circle-check":"circle-xmark"} text-${yariZamanli ? "success":"danger"}"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #2 -->
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <!-- Project Overview #3 -->
                                <a class="block block-rounded block-link-shadow h-100 mb-0" href="javascript:void(0)">
                                    <div class="block-content p-0 progress" style="height: 2px;">
                                        <div class="progress-bar bg-${uzaktanEgitim ? "success":"danger"}" role="progressbar" style="width: 0%;"
                                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div
                                        class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="fs-lg fw-semibold mb-0">
                                                Uzaktan Eğitim
                                            </p>

                                        </div>
                                        <div class="ms-3 item">
                                            <i class="fa fa-2x fa-${uzaktanEgitim ? "circle-check":"circle-xmark"} text-${uzaktanEgitim ? "success":"danger"}"></i>
                                        </div>
                                    </div>
                                </a>
                                <!-- END Project Overview #3 -->
                            </div>
                            <br>
                            <div class="col-xl-6 mt-4">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-scroll text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Sertifikalar
                                        </p>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                              ${sertifikalar}
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-4">
                                <div class="block block-rounded">
                                    <div class="block-content block-content-full bg-primary text-center">
                                        <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-briefcase text-white"></i>
                                        </a>
                                        <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Tecrübeler
                                        </p>

                                    </div>
                                    <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                            <tbody>
                                                ${tecrubeler}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> `
                 console.log(res);
                 $('#icerik').append(content)
                 $('#buttonsContent').append(buttons)
                 Dashmix.block('state_normal', '#modalBlock');

             },
             error: function(res) {
                 var buttons =
                     `  <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Kapat</button>`
                 var content = `<div class="col-6">
                               <a class="block text-center bg-xplay" href="javascript:void(0)">
                                   <div class="block-content block-content-full ratio ratio-16x9">
                                     <div class="d-flex justify-content-center align-items-center">
                                       <div>
                                         <i class="fa fa-2x fa-times text-danger-light"></i>
                                         <div class="fw-semibold mt-3 text-uppercase text-white">${res.responseJSON.message}</div>
                                       </div>
                                     </div>
                                   </div>
                                 </a>
                            </div>`
                 $('#icerik').append(content)
                 $('#buttonsContent').append(buttons)
                 Dashmix.block('state_normal', '#modalBlock');

             }
         })
     }

     function talep(id) {
         var fd = new FormData();
         fd.append('_token', $('input[name="_token"]').val());
         fd.append('id', id);
         $.ajax({
             url: '{{ route('kurum_ogretmen_bekleyenler_talep') }}',
             method: 'post',
             data: fd,
             processData: false,
             contentType: false,
             success: function(res) {
                 Swal.fire({
                     icon: 'success',
                     title: 'Onaylandı!',
                     text: res.message,
                     confirmButtonText: "Tamam"
                 }).then((result) => {
                     location.reload();
                 })
             },
             error: function(res) {
                 Swal.fire({
                     icon: 'error',
                     title: 'Hata!',
                     text: res.responseJSON.message,
                     confirmButtonText: "Tamam"
                 }).then((result) => {
                     location.reload();
                 })

             }
         })
     }
 </script>
