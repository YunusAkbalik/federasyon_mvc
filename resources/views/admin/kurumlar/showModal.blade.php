 <!-- Vertically Centered Block Modal -->
 <div class="modal" id="modal-block" tabindex="-1" role="dialog" aria-labelledby="modal-block" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
         <div class="modal-content">
             <div class="block block-rounded block-themed block-transparent mb-0" id="modalBlock">
                 <div class="block-header bg-primary-dark">
                     <h3 class="block-title">Kurum Detayları</h3>
                     <div class="block-options">
                         <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                             <i class="fa fa-fw fa-times"></i>
                         </button>
                     </div>
                 </div>
                 <div class="block-content" id="modal-content">
                     {{-- <div class="row">
                         <div class="col-xxl-8">
                             <div class="block block-rounded">
                                 <div class="block-content block-content-full bg-xeco text-center">
                                     <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                         <i class="fa fa-2x fa-city text-white"></i>
                                     </a>
                                     <p class="text-white fs-3 fw-light mt-3 mb-0">
                                         Kurum Detayları
                                     </p>
                                 </div>
                                 <div class="block-content block-content-full">
                                     <table class="table table-borderless table-striped table-hover">
                                         <tbody>
                                             <tr>
                                                 <td>Ünvan</td>
                                                 <td>
                                                     <strong>Roosecs eğitim</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Telefon</td>
                                                 <td>
                                                     <strong><a href="tel:0 224 801 27 48">0 224 801 27 48</a></strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Adres</td>
                                                 <td>
                                                     <strong>Atakol Sokak 3
                                                         91258 Ardahan</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Kişi</td>
                                                 <td>
                                                     <strong>Ege Ozansoy</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Telefon Numarası</td>
                                                 <td>
                                                     <strong><a href="tel:0 509 130 01 27">0 509 130 01 27</a></strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Hesap ID</td>
                                                 <td>
                                                     <strong>123</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Vergi Dairesi</td>
                                                 <td>
                                                     <strong>Esma Sokak 6</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Vergi No</td>
                                                 <td>
                                                     <strong>672</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td><span class="text-success">Whatsapp</span> Hattı</td>
                                                 <td>
                                                     <strong><a class="text-success"
                                                             href="https://wa.me/5367653403">5367653403</a></strong>
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                     <div class="text-center">
                                         <a class="btn btn-sm btn-primary"
                                             href="{{ route('admin_edit_kurum', ['id' => 1]) }}">
                                             <i class="fa fa-pencil me-1 opacity-50"></i> Düzenle
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-xxl-4">
                             <div class="block block-rounded">
                                 <div class="block-content block-content-full bg-xeco-dark text-center">
                                     <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                         <i class="fa fa-2x fa-chalkboard-user text-white"></i>
                                     </a>
                                     <p class="text-white fs-3 fw-light mt-3 mb-0">
                                         Kurum Hizmetleri
                                     </p>
                                 </div>
                                 <div class="block-content block-content-full">
                                     <table class="table table-borderless table-striped table-hover">
                                         <tbody>
                                             <tr>
                                                 <td class="text-center">Robotik</td>
                                             </tr>
                                             <tr>
                                                 <td class="text-center">Etüt</td>
                                             </tr>
                                             <tr>
                                                 <td class="text-center">Kodlama</td>
                                             </tr>
                                             <tr>
                                                 <td class="text-center">Türkçe</td>
                                             </tr>
                                             <tr>
                                                 <td class="text-center">İngilizce</td>
                                             </tr>
                                         </tbody>
                                     </table>

                                 </div>
                             </div>
                         </div>
                     </div> --}}
                     {{-- <div class="row justify-content-center">
                         <div class="col-md-6">
                             <a class="block text-center bg-xplay" href="javascript:void(0)">
                                 <div class="block-content block-content-full ratio ratio-16x9">
                                     <div class="d-flex justify-content-center align-items-center">
                                         <div>
                                             <i class="fa fa-2x fa-times text-danger-light"></i>
                                             <div class="fw-semibold mt-3 text-uppercase text-white">HATA MESAJI</div>
                                         </div>
                                     </div>
                                 </div>
                             </a>
                         </div>
                     </div> --}}
                 </div>
                 <div class="block-content block-content-full text-end bg-body">
                     <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Kapat</button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- END Vertically Centered Block Modal -->

 <script>
     function getData(id) {
         Dashmix.block('state_loading', '#modalBlock');
         $('#modal-content').empty()
         var fd = new FormData();
         fd.append('_token', $('input[name="_token"]').val());
         fd.append('id', id);
         $.ajax({
             url: '{{ route('admin_get_kurum') }}',
             method: 'post',
             data: fd,
             processData: false,
             contentType: false,
             success: function(res) {
                console.log(res);
                 var hizmetler = "";
                 res.data.hizmetler.forEach(element => {
                     hizmetler += ` <tr>
                                                 <td class="text-center">${element.hizmet}</td>
                                             </tr>`
                 });
                 var content = `<div class="row">
                         <div class="col-xxl-8">
                             <div class="block block-rounded">
                                 <div class="block-content block-content-full bg-xeco text-center">
                                     <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                         <i class="fa fa-2x fa-city text-white"></i>
                                     </a>
                                     <p class="text-white fs-3 fw-light mt-3 mb-0">
                                         Kurum Detayları
                                     </p>
                                 </div>
                                 <div class="block-content block-content-full">
                                     <table class="table table-borderless table-striped table-hover">
                                         <tbody>
                                             <tr>
                                                 <td>Ünvan</td>
                                                 <td>
                                                     <strong>${res.data.unvan}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Telefon</td>
                                                 <td>
                                                     <strong><a href="tel:${res.data.telefon}">${res.data.telefon}</a></strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Adres</td>
                                                 <td>
                                                     <strong>${res.data.adres}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Kişi</td>
                                                 <td>
                                                     <strong>${res.data.yetkili_kisi}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Telefon Numarası</td>
                                                 <td>
                                                     <strong><a href="tel:${res.data.yetkili_telefon}">${res.data.yetkili_telefon}</a></strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Yetkili Hesap ID</td>
                                                 <td>
                                                     <strong>${res.data.yetkili.user.ozel_id}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Vergi Dairesi</td>
                                                 <td>
                                                     <strong>${res.data.vergi_dairesi}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td>Vergi No</td>
                                                 <td>
                                                     <strong>${res.data.vergi_no}</strong>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td><span class="text-success">Whatsapp</span> Hattı</td>
                                                 <td>
                                                     <strong><a class="text-success"
                                                             href="https://wa.me/90${res.data.wp_hatti}">${res.data.wp_hatti}</a></strong>
                                                 </td>
                                             </tr>
                                         </tbody>
                                     </table>
                                     <div class="text-center">
                                         <a class="btn btn-sm btn-primary"
                                         href="kurumlar/duzenle/${res.data.id}">
                                             <i class="fa fa-pencil me-1 opacity-50"></i> Düzenle
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-xxl-4">
                             <div class="block block-rounded">
                                 <div class="block-content block-content-full bg-xeco-dark text-center">
                                     <a class="item item-circle mx-auto bg-black-25" href="javascript:void(0)">
                                         <i class="fa fa-2x fa-chalkboard-user text-white"></i>
                                     </a>
                                     <p class="text-white fs-3 fw-light mt-3 mb-0">
                                         Kurum Hizmetleri
                                     </p>
                                 </div>
                                 <div class="block-content block-content-full">
                                     <table class="table table-borderless table-striped table-hover">
                                         <tbody>
                                             ${hizmetler}
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                     </div>`
                 $('#modal-content').append(content)
                 Dashmix.block('state_normal', '#modalBlock');

             },
             error: function(res) {
                 var content = `<div class="row justify-content-center">
                         <div class="col-md-6">
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
                         </div>
                     </div>`
                 $('#modal-content').append(content)
                 Dashmix.block('state_normal', '#modalBlock');

             }

         })
     }
 </script>
