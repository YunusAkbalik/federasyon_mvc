 <!-- Vertically Centered Block Modal -->
 <div class="modal" id="modalHere" tabindex="-1" role="dialog" aria-labelledby="modalHere" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
         <div class="modal-content">
             <div class="block block-rounded block-themed block-transparent mb-0" id="modalBlock">
                 <div class="block-header bg-primary-dark">
                     <h3 class="block-title">Veli Bilgileri</h3>
                     <div class="block-options">
                         <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                             <i class="fa fa-fw fa-times"></i>
                         </button>
                     </div>
                 </div>
                 <div class="block-content mb-4">
                     <div class="container">
                         <div class="row justify-content-center" id="icerik">
                             <div class="col-xl-6">
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
                                                     <td><strong>321654</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Ad Soyad</td>
                                                     <td><strong>Esma Koçyiğit</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>T.C Kimlik</td>
                                                     <td><strong>34671043458</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Doğum Tarihi</td>
                                                     <td><strong>08/08/2000</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Kan Grubu</td>
                                                     <td><strong>0 RH (+)</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>GSM No</td>
                                                     <td><strong>5367653403</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>E-posta</td>
                                                     <td><strong class="text-danger">Yok</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Kullanıcı Durumu</td>
                                                     <td><strong class="text-success">Onaylı</strong></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>

                             </div>

                             {{-- <div class="col-6">
                                <a class="block text-center bg-xplay" href="javascript:void(0)">
                                    <div class="block-content block-content-full ratio ratio-16x9">
                                      <div class="d-flex justify-content-center align-items-center">
                                        <div>
                                          <i class="fa fa-2x fa-times text-danger-light"></i>
                                          <div class="fw-semibold mt-3 text-uppercase text-white">Hata Mesajı</div>
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                             </div> --}}

                         </div>

                     </div>
                 </div>
                 <div class="block-content block-content-full text-end bg-body">
                     <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Kapat</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- END Vertically Centered Block Modal -->
 <script>
     function getData(id) {
         Dashmix.block('state_loading', '#modalBlock');
         var fd = new FormData();
         fd.append('_token', $('input[name="_token"]').val());
         fd.append('id', id);
         $.ajax({
             url: '{{ route('admin_get_veli') }}',
             method: 'post',
             data: fd,
             processData: false,
             contentType: false,
             success: function(res) {
                 console.log(res);
                 $('#icerik').empty()
                 if (res.error) {
                     var content = `  <div class="col-6">
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
                             </div>`
                 } else {
                     var kullaniciDurumu = "Bekliyor"
                     var durumClass = "warning"
                     if (res.veli.onayli && res.veli.ret == 0) {
                         kullaniciDurumu = "Onaylı"
                         durumClass = "success"
                     }
                     if (res.veli.onayli == 0 && res.veli.ret) {
                         kullaniciDurumu = "Reddedildi"
                         durumClass = "danger"
                     }
                     if (res.ogrenci != null) {
                         var ogrenci_kullaniciDurumu = "Bekliyor"
                         var ogrenci_durumClass = "warning"
                         if (res.ogrenci.onayli && res.ogrenci.ret == 0) {
                             ogrenci_kullaniciDurumu = "Onaylı"
                             ogrenci_durumClass = "success"
                         }
                         if (res.ogrenci.onayli == 0 && res.ogrenci.ret) {
                             ogrenci_kullaniciDurumu = "Reddedildi"
                             ogrenci_durumClass = "danger"
                         }
                     }

                     var kisisel = ` <div class="col-xl-6">
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
                                                     <td><strong>${res.veli.ozel_id}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Ad Soyad</td>
                                                     <td><strong>${res.veli.ad} ${res.veli.soyad}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>T.C Kimlik</td>
                                                     <td><strong>${res.veli.tc_kimlik}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Doğum Tarihi</td>
                                                     <td><strong>${res.veli.dogum_tarihi}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Kan Grubu</td>
                                                     <td><strong ${res.veli.kan_grubu == null ? 'class="text-danger"':""}>${res.veli.kan_grubu == null ? 'Yok':res.veli.kan_grubu}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>GSM No</td>
                                                     <td><strong ${res.veli.gsm_no == null ? 'class="text-danger"':""}>${res.veli.gsm_no == null ? 'Yok':res.veli.gsm_no}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>E-posta</td>
                                                     <td><strong ${res.veli.email == null ? 'class="text-danger"':""}>${res.veli.email == null ? 'Yok':res.veli.email}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Kullanıcı Durumu</td>
                                                     <td><strong class="text-${durumClass}">${kullaniciDurumu}</strong></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>

                             </div>`
                     if (res.ogrenci == null) {
                         var ogrenci = `<div class="col-xl-6">
                                 <div class="block block-rounded">
                                     <div class="block-content block-content-full bg-gd-fruit text-center">
                                         <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                             <i class="fa fa-2x fa-people-roof text-white"></i>
                                         </a>
                                         <p class="text-white fs-3 fw-light mt-3 mb-0">
                                             Velisi Olduğu Öğrenci Bilgileri
                                         </p>
                                     </div>
                                     <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                             <tbody>
                                                 <tr>
                                                     <td class="text-center text-danger"><b>Velisi Olduğu Öğrenci Yok</b></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>`
                     } else {
                         var ogrenci = `<div class="col-xl-6">
                                 <div class="block block-rounded">
                                     <div class="block-content block-content-full bg-gd-fruit text-center">
                                         <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                             <i class="fa fa-2x fa-id-card text-white"></i>
                                         </a>
                                         <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Velisi Olduğu Öğrenci Bilgileri
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
                                                     <td><strong ${res.ogrenci.kan_grubu == null ? 'class="text-danger"':""}>${res.ogrenci.kan_grubu == null ? 'Yok':res.ogrenci.kan_grubu}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>GSM No</td>
                                                     <td><strong ${res.ogrenci.gsm_no == null ? 'class="text-danger"':""}>${res.ogrenci.gsm_no == null ? 'Yok':res.ogrenci.gsm_no}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>E-posta</td>
                                                     <td><strong ${res.ogrenci.email == null ? 'class="text-danger"':""}>${res.ogrenci.email == null ? 'Yok':res.ogrenci.email}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Kullanıcı Durumu</td>
                                                     <td><strong class="text-${ogrenci_durumClass}">${ogrenci_kullaniciDurumu}</strong></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>

                             </div>`
                     }

                     if (res.ogrenci != null) {
                         var okul = `<div class="col-xl-12">
                                 <div class="block block-rounded">
                                     <div class="block-content block-content-full bg-primary text-center">
                                         <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                             <i class="fa fa-2x fa-school-flag text-white"></i>
                                         </a>
                                         <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Velisi Olduğu Öğrencinin Okul Bilgileri
                                         </p>
                                     </div>
                                     <div class="block-content block-content-full">
                                         <table class="table table-borderless table-striped table-hover">
                                             <tbody>
                                                 <tr>
                                                     <td>Okul</td>
                                                     <td><strong>${res.okul.okul_details.ad}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Sınıf / Şube</td>
                                                     <td><strong>${res.okul.sinif} / ${res.okul.sube}</strong></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Branş</td>
                                                     <td><strong ${res.okul.brans == null ? "class='text-danger'":""}>${res.okul.brans == null ? "Yok":res.okul.brans}</strong></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>`
                     }else{
                        var okul = `<div class="col-xl-12">
                                 <div class="block block-rounded">
                                     <div class="block-content block-content-full bg-primary text-center">
                                         <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                             <i class="fa fa-2x fa-school-flag text-white"></i>
                                         </a>
                                         <p class="text-white fs-3 fw-light mt-3 mb-0">
                                            Velisi Olduğu Öğrencinin Okul Bilgileri
                                         </p>
                                     </div>
                                     <div class="block-content block-content-full">
                                        <table class="table table-borderless table-striped table-hover">
                                             <tbody>
                                                 <tr>
                                                     <td class="text-center text-danger"><b>Velisi Olduğu Öğrenci Yok</b></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>`
                     }

                 }
                 $('#icerik').append(content)
                 $('#icerik').append(kisisel)
                 $('#icerik').append(ogrenci)
                 $('#icerik').append(okul)
                 Dashmix.block('state_normal', '#modalBlock');
             }
         })
     }
 </script>
