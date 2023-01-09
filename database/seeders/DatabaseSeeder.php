<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OgrenciOkulModel;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $ogrenciRole = Role::create(['name' => "Öğrenci"]);
        $veliRole = Role::create(['name' => "Veli"]);
        $adminRole = Role::create(['name' => "Admin"]);
        $faker = Factory::create("tr_TR");
        $yearNow = date('y');
        $yearSecond = (string)$yearNow;
        $start = intval($yearSecond[1]) * 100000;
        $end = $start + 99999;
        $ozel_id = rand($start, $end);
        DB::table('users')->insert([
            [
                'tc_kimlik' => "27256988692",
                'ozel_id' => $ozel_id,
                'ad' => "Yunus Emre",
                'soyad' => "Akbalık",
                'dogum_tarihi' => Carbon::parse("08/08/2000"),
                'kan_grubu' => "0RH(+)",
                'gsm_no' => "5367653403",
                'email' => "yunusroose@gmail.com",
                'password' => bcrypt("123"),
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'created_at' => now(),
            ],
        ]);
        for ($i = 0; $i < 49; $i++) {
            $ozel_id = rand($start, $end);
            DB::table('users')->insert([
                [
                    'tc_kimlik' => $faker->numerify('###########'),
                    'ozel_id' => $ozel_id,
                    'ad' => $faker->firstName(),
                    'soyad' => $faker->lastName(),
                    'dogum_tarihi' => $faker->date(),
                    'kan_grubu' => "0RH(+)",
                    'gsm_no' => $faker->phoneNumber(),
                    'email' => $faker->unique()->email(),
                    'password' => bcrypt("123"),
                    'onayli' => $faker->boolean(),
                    'ret' => false,
                    'ret_nedeni' => null,
                    'created_at' => now(),
                ]
            ]);
        }

        User::find(1)->assignRole("Admin");
        for ($i = 2; $i <= 50; $i++) {
            User::find($i)->assignRole($faker->randomElement(['Öğrenci', 'Veli']));
        }
        $ogrenciler = User::role('Öğrenci')->get();
        foreach ($ogrenciler as $ogrenci) {
            $randomOkul = rand(1, 8);
            $randomSinif = rand(1, 12);
            $randomSube = chr(rand(65, 90));
            OgrenciOkulModel::create([
                'okul_id' => $randomOkul,
                'ogrenci_id' => $ogrenci->id,
                'sinif' => $randomSinif,
                'sube' => $randomSube
            ]);
        }


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
            ['ad' => "Admin Kullanıcı Onayları", "icon" => "check-to-slot"],
            ['ad' => "Admin Kullanıcı Retleri", "icon" => "circle-xmark"],
            ['ad' => "Admin Öğrenci Kayıtları", "icon" => "user-graduate"],
            ['ad' => "Admin Veli Kayıtları", "icon" => "user"],
        ]);
    }
}
