<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
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

        DB::table('users')->insert([
            [
                'tc_kimlik' => "27256988692",
                'ad' => "Yunus Emre",
                'soyad' => "Akbalık",
                'dogum_tarihi' => Carbon::parse("08/08/2000"),
                'kan_grubu' => "0RH(+)",
                'gsm_no' => "+905367653403",
                'email' => "yunusroose@gmail.com",
                'password' => bcrypt("123"),
                'onayli' => true
            ]
        ]);
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
      
        User::find(1)->assignRole("Admin");
        
    }
}
