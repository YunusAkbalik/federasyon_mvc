<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OgrenciOkulModel;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => "Öğrenci"]);
        Role::create(['name' => "Veli"]);
        Role::create(['name' => "Admin"]);
        Role::create(['name' => "Öğretmen"]);
        Role::create(['name' => "Kurum Yetkilisi"]);
        $perm_ogrenci_create =  ModelsPermission::create(['name' => "Öğrenci Hesabı Oluştur"]);
        $faker = Factory::create("tr_TR");
        // Main acc
        DB::table('users')->insert([
            [
                'tc_kimlik' => "27256988692",
                'ozel_id' => 1,
                'ad' => "Demo",
                'soyad' => "Admin",
                'dogum_tarihi' => Carbon::parse("08/08/2000"),
                'kan_grubu' => "0RH(+)",
                'gsm_no' => "5367653403",
                'email' => $faker->email(),
                'password' => bcrypt("123"),
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'created_at' => now(),
            ],
        ]);
        // Kurum Acc
        // DB::table('users')->insert([
        //     [
        //         'tc_kimlik' => $faker->numerify('###########'),
        //         'ozel_id' => 2,
        //         'ad' => $faker->firstName(),
        //         'soyad' => $faker->lastName(),
        //         'dogum_tarihi' => $faker->date(),
        //         'kan_grubu' => kan_grubu_uret(),
        //         'gsm_no' => $faker->phoneNumber(),
        //         'email' => $faker->unique()->email(),
        //         'password' => bcrypt("123"),
        //         'onayli' => true,
        //         'ret' => false,
        //         'ret_nedeni' => null,
        //         'created_at' => now(),
        //     ]
        // ]);
        // Öğretmen Acc
        // DB::table('users')->insert([
        //     [
        //         'tc_kimlik' => $faker->numerify('###########'),
        //         'ozel_id' => 3,
        //         'ad' => $faker->firstName(),
        //         'soyad' => $faker->lastName(),
        //         'dogum_tarihi' => $faker->date(),
        //         'kan_grubu' => kan_grubu_uret(),
        //         'gsm_no' => $faker->phoneNumber(),
        //         'email' => $faker->unique()->email(),
        //         'password' => bcrypt("123"),
        //         'onayli' => true,
        //         'ret' => false,
        //         'ret_nedeni' => null,
        //         'created_at' => now(),
        //     ]
        // ]);
        // DB::table('users')->insert([
        //     [
        //         'tc_kimlik' => $faker->numerify('###########'),
        //         'ozel_id' => 4,
        //         'ad' => $faker->firstName(),
        //         'soyad' => $faker->lastName(),
        //         'dogum_tarihi' => $faker->date(),
        //         'kan_grubu' => kan_grubu_uret(),
        //         'gsm_no' => $faker->phoneNumber(),
        //         'email' => $faker->unique()->email(),
        //         'password' => bcrypt("123"),
        //         'onayli' => true,
        //         'ret' => false,
        //         'ret_nedeni' => null,
        //         'created_at' => now(),
        //     ]
        // ]);



        User::find(1)->assignRole("Admin");
        // User::find(2)->assignRole("Kurum Yetkilisi");
        // User::find(3)->assignRole("Öğretmen");
        // User::find(3)->givePermissionTo($perm_ogrenci_create);
        // User::find(4)->assignRole("Öğretmen");


        // Random kullanıcılar
        // for ($i = 1; $i <= 46; $i++) {

        //     DB::table('users')->insert([
        //         [
        //             'tc_kimlik' => $faker->numerify('###########'),
        //             'ozel_id' => ozel_id_uret(),
        //             'ad' => $faker->firstName(),
        //             'soyad' => $faker->lastName(),
        //             'dogum_tarihi' => $faker->date(),
        //             'kan_grubu' => kan_grubu_uret(),
        //             'gsm_no' => $faker->phoneNumber(),
        //             'email' => $faker->unique()->email(),
        //             'password' => bcrypt("123"),
        //             'onayli' => $faker->boolean(),
        //             'ret' => false,
        //             'ret_nedeni' => null,
        //             'created_at' => now(),
        //         ]
        //     ]);
        // }

        // Kullanıcılara random Permler
        // for ($i = 5; $i <= 50; $i++) {
        //     User::find($i)->assignRole($faker->randomElement(['Öğrenci', 'Veli']));
        // }

        // Öğrencilere random okul sınıf tanımlaması
        // $ogrenciler = User::role('Öğrenci')->get();
        // foreach ($ogrenciler as $ogrenci) {
        //     $randomOkul = rand(1, 8);
        //     $randomSinif = rand(1, 12);
        //     $randomSube = chr(rand(65, 90));
        //     OgrenciOkulModel::create([
        //         'okul_id' => $randomOkul,
        //         'ogrenci_id' => $ogrenci->id,
        //         'sinif' => $randomSinif,
        //         'sube' => $randomSube
        //     ]);
        // }

        DB::table('il')->insert([
            ['ad' => "İstanbul"],
            ['ad' => "Ankara"],
            ['ad' => "İzmir"],
        ]);
        DB::table('ilce')->insert([
            ['il_id' => 1, 'ad' => 'Ataşehir'],
            ['il_id' => 1, 'ad' => 'Kartal'],
            ['il_id' => 1, 'ad' => 'Pendik'],
            ['il_id' => 2, 'ad' => 'Çamlıdere'],
            ['il_id' => 2, 'ad' => 'Elmadağ'],
            ['il_id' => 3, 'ad' => 'Balçova'],
            ['il_id' => 3, 'ad' => 'Bayındır'],
            ['il_id' => 3, 'ad' => 'Menemen'],
        ]);
        DB::table('okul')->insert([
            ['ilce_id' => 1, 'ad' => "Ataşehir İbrahim Müteferrika Mesleki ve Teknik Anadolu Lisesi"],
            ['ilce_id' => 2, 'ad' => "Soğanlık İlköğretim okulu"],
            ['ilce_id' => 3, 'ad' => "Yıldırım Beyazıt İlköğretim okulu"],
            ['ilce_id' => 4, 'ad' => "Çamlıdere Merkez Atatürk İlköğretim okulu"],
            ['ilce_id' => 5, 'ad' => "Yaşar Doğu Ortaokulu"],
            ['ilce_id' => 6, 'ad' => "Başöğretmen Atatürk İlköğretim okulu"],
            ['ilce_id' => 7, 'ad' => "Fatih İlköğretim okulu"],
            ['ilce_id' => 8, 'ad' => "Menemen Gazi İlköğretim okulu"],
        ]);
        DB::table('log_kategorileri')->insert([
            ['ad' => "Giriş İşlemleri", "icon" => "key"],
            ['ad' => "Çıkış İşlemleri", "icon" => "right-from-bracket"],
            ['ad' => "Kayıt İşlemleri", "icon" => "pencil"],
            ['ad' => "Kullanıcı Onayları", "icon" => "check-to-slot"],
            ['ad' => "Kullanıcı Retleri", "icon" => "circle-xmark"],
            ['ad' => "Öğrenci Kayıtları", "icon" => "user-graduate"],
            ['ad' => "Veli Kayıtları", "icon" => "user"],
            ['ad' => "Kurum Oluşturmaları", "icon" => "building"],
            ['ad' => "Öğretmen Onayları", "icon" => "check-to-slot"],
            ['ad' => "Öğretmen Retleri", "icon" => "circle-xmark"],
            ['ad' => "Öğretmen Talepleri", "icon" => "hand"],
            ['ad' => "Talep Yanıtları", "icon" => "comment-dots"],
            ['ad' => "Sınıf Oluşturmaları", "icon" => "person-chalkboard"],
            ['ad' => "Sınıfa Öğrenci Eklemeleri", "icon" => "user-plus"],
            ['ad' => "Kurum Okul İşlemleri", "icon" => "school-flag"],
            ['ad' => "Ders Oluşturmaları", "icon" => "book-open"],
            ['ad' => "Derse Öğretmen Atamaları", "icon" => "chalkboard-user"],
            ['ad' => "Dersten Öğretmeni Kaldırmaları", "icon" => "user-xmark"],
            ['ad' => "Sınıftan Öğrenci Çıkarmaları", "icon" => "user-xmark"],
            ['ad' => "Ders Planı Eklemeleri", "icon" => "file-circle-plus"],
            ['ad' => "Ders Planına Dosya Eklemeleri", "icon" => "file-circle-plus"],
            ['ad' => "Dersten Dosya Silme İşlemleri", "icon" => "file-circle-xmark"],
            ['ad' => "Ders Planı Güncelleme İşlemleri", "icon" => "file-pen"],
            ['ad' => "Ders Programı Oluşturma İşlemleri", "icon" => "calendar-plus"],
            ['ad' => "Yoklama Alımları", "icon" => "book"],

        ]);
        DB::table('kurum_log_kategori')->insert([
            ['ad' => "Giriş İşlemleri", "icon" => "key"],
            ['ad' => "Çıkış İşlemleri", "icon" => "right-from-bracket"],
            ['ad' => "Öğrenci Kayıtları", "icon" => "user-graduate"],
            ['ad' => "Veli Kayıtları", "icon" => "user"],
            ['ad' => "Öğretmen Onayları", "icon" => "check-to-slot"],
            ['ad' => "Öğretmen Retleri", "icon" => "circle-xmark"],
            ['ad' => "Öğretmen Talepleri", "icon" => "hand"],
            ['ad' => "Sınıf Oluşturmaları", "icon" => "person-chalkboard"],
            ['ad' => "Sınıfa Öğrenci Eklemeleri", "icon" => "user-plus"],
            ['ad' => "Kurum Okul İşlemleri", "icon" => "school-flag"],
            ['ad' => "Ders Oluşturma İşlemleri", "icon" => "book-open"],
            ['ad' => "Derse Öğretmen Atamaları", "icon" => "chalkboard-user"],
            ['ad' => "Dersten Öğretmeni Kaldırmaları", "icon" => "user-xmark"],
            ['ad' => "Sınıftan Öğrenci Çıkarmaları", "icon" => "user-xmark"],
            ['ad' => "Ders Planı Eklemeleri", "icon" => "file-circle-plus"],
            ['ad' => "Ders Planına Dosya Eklemeleri", "icon" => "file-circle-plus"],
            ['ad' => "Ders Planından Dosya Silme İşlemleri", "icon" => "file-circle-xmark"],
            ['ad' => "Ders Planı Güncelleme İşlemleri", "icon" => "file-pen"],
            ['ad' => "Ders Programı Oluşturma İşlemleri", "icon" => "calendar-plus"],
            ['ad' => "Yoklama Alımları", "icon" => "book"],
        ]);
        // DB::table('kurumlar')->insert([
        //     [
        //         'unvan' => "Roosecs eğitim",
        //         'telefon' => $faker->phoneNumber(),
        //         'adres' => $faker->address(),
        //         'vergi_dairesi' => $faker->streetAddress,
        //         'vergi_no' => $faker->numerify('###'),
        //         'yetkili_kisi' => $faker->firstName() . " " . $faker->lastName(),
        //         'yetkili_telefon' => $faker->phoneNumber(),
        //         'wp_hatti' => "5367653403",
        //         'created_at' => now(),
        //         'updated_at' => now(),

        //     ],
        // ]);
        // DB::table("kurum_hizmetler")->insert([
        //     ['kurum_id' => 1, "hizmet" => "Robotik", 'created_at' => now(), 'updated_at' => now()],
        //     ['kurum_id' => 1, "hizmet" => "Etüt", 'created_at' => now(), 'updated_at' => now()],
        //     ['kurum_id' => 1, "hizmet" => "Kodlama", 'created_at' => now(), 'updated_at' => now()],
        //     ['kurum_id' => 1, "hizmet" => "Türkçe", 'created_at' => now(), 'updated_at' => now()],
        //     ['kurum_id' => 1, "hizmet" => "İngilizce", 'created_at' => now(), 'updated_at' => now()],
        // ]);
        // DB::table("kurum_user")->insert([
        //     ['kurum_id' => 1, "user_id" => 2, 'created_at' => now(), 'updated_at' => now()],
        // ]);
        // DB::table("ogretmen_kurum")->insert([
        //     ['ogretmen_id' => 3, "kurum_id" => 1, 'created_at' => now(), 'updated_at' => now()],
        //     ['ogretmen_id' => 4, "kurum_id" => 1, 'created_at' => now(), 'updated_at' => now()],
        // ]);


        // Öğretmen CV Seeds
        // DB::table("ogretmen_cv")->insert([
        //     [
        //         'ogretmen_id' => 3,
        //         "okul" => "Nişantaşı Üniversitesi",
        //         "bolum" => "İlkokul Öğretmenlik",
        //         "mezun_tarihi" => $faker->date(),
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'ogretmen_id' => 4,
        //         "okul" => "Güzel Üniversitesi",
        //         "bolum" => "Ortaokul Öğretmenlik",
        //         "mezun_tarihi" => $faker->date(),
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("cv_calismasaatleri")->insert([
        //     [
        //         'cv_id' => 1,
        //         'calismaSaatleri' => "Tam Zamanlı",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 1,
        //         'calismaSaatleri' => "Yarı Zamanlı",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 1,
        //         'calismaSaatleri' => "Uzaktan Eğitim",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 2,
        //         'calismaSaatleri' => "Yarı Zamanlı",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 2,
        //         'calismaSaatleri' => "Uzaktan Eğitim",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("cv_oncekiisler")->insert([
        //     [
        //         'cv_id' => 1,
        //         'isler' => "Güngören şehitler i.ö.o 5 sene tam zamanlı çalıştım",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 1,
        //         'isler' => "Ataşehir İMTEM lisesine  2 senedir aktif olarak uzaktan eğitim veriyorum.",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 2,
        //         'isler' => "Ataşehir İMTEM lisesine  2 senedir aktif olarak uzaktan eğitim veriyorum.",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("cv_sertifikalar")->insert([
        //     [
        //         'cv_id' => 1,
        //         'sertifika' => "Çok iyi öğretmen sertifikası",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 1,
        //         'sertifika' => "Muhteşem öğretmen sertifikası",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 1,
        //         'sertifika' => "ÜĞğf fena öğretmen sertifikası",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'cv_id' => 2,
        //         'sertifika' => "ÜĞğf fena öğretmen sertifikası",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        DB::table("gunler")->insert([
            ['ad' => "Pazartesi"],
            ['ad' => "Salı"],
            ['ad' => "Çarşamba"],
            ['ad' => "Perşembe"],
            ['ad' => "Cuma"],
            ['ad' => "Cumartesi"],
            ['ad' => "Pazar"],
        ]);
        // DB::table("ogretmen_photo")->insert([
        //     [
        //         'ogretmen_id' => 3,
        //         'photo_path' => "teacher.jpg",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'ogretmen_id' => 4,
        //         'photo_path' => "teacher.jpg",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("kurum_ders")->insert([
        //     [
        //         'kurum_id' => 1,
        //         'ad' => "Robotik Kodlama",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'ad' => "Yazılım",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'ad' => "İngilizce",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("ogretmen_ders")->insert([
        //     [
        //         'ogretmen_id' => 3,
        //         'ders_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'ogretmen_id' => 3,
        //         'ders_id' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'ogretmen_id' => 4,
        //         'ders_id' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'ogretmen_id' => 4,
        //         'ders_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
          
        // ]);
        // DB::table("kurum_okul")->insert([
        //     [
        //         'kurum_id' => 1,
        //         'okul_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'okul_id' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("sinif")->insert([
        //     [
        //         'kurum_id' => 1,
        //         'okul_id' => 1,
        //         'ad' => "Kelebekler",
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
        // DB::table("ders_programi")->insert([
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "09:00",
        //         'bitis' => "09:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "09:30",
        //         'bitis' => "10:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "10:15",
        //         'bitis' => "11:00",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "11:00",
        //         'bitis' => "11:45",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "11:45",
        //         'bitis' => "12:30",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 1,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 2,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 3,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 4,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 5,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 6,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'kurum_id' => 1,
        //         'sinif_id' => 1,
        //         'ders_id' => 1,
        //         'gun_id' => 7,
        //         'baslangic' => "12:30",
        //         'bitis' => "13:15",
        //         'ogretmen_id' => 3,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ]);
    }
}
