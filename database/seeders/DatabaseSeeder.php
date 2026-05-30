<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admins
        $admin = User::create([
            'name' => 'Admin HealthyWay',
            'email' => 'admin@healthyway.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Premium Admin Account for Screen Testing
        $adminAraxa = User::create([
            'name' => 'Aranxa Admin',
            'email' => 'aranxa.admin@healthyway.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Masyarakat Users
        $araxa = User::create([
            'name' => 'Aranxa',
            'email' => 'aranxa@healthyway.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'masyarakat',
        ]);

        $budi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@healthyway.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'masyarakat',
        ]);

        $siti = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@healthyway.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'masyarakat',
        ]);

        // 3. Create Travel Logs for Budi
        $budi->perjalanans()->createMany([
            [
                'tanggal' => '2026-05-25',
                'jam' => '08:30',
                'lokasi' => 'Bandara Soekarno-Hatta Terminal 3',
                'suhu_tubuh' => 36.4,
                'catatan' => 'Pemeriksaan rutin pintu keberangkatan domestik.',
            ],
            [
                'tanggal' => '2026-05-26',
                'jam' => '13:15',
                'lokasi' => 'Stasiun Gambir Jakarta',
                'suhu_tubuh' => 37.8, // Alert!
                'catatan' => 'Terasa sedikit lelah setelah perjalanan kereta, disarankan istirahat oleh petugas medis.',
            ],
            [
                'tanggal' => '2026-05-28',
                'jam' => '10:00',
                'lokasi' => 'Mall Grand Indonesia',
                'suhu_tubuh' => 36.7,
                'catatan' => 'Suhu normal, masuk pintu timur.',
            ],
        ]);

        // 4. Create Travel Logs for Siti
        $siti->perjalanans()->createMany([
            [
                'tanggal' => '2026-05-24',
                'jam' => '09:00',
                'lokasi' => 'Klinik Medika Sehat',
                'suhu_tubuh' => 38.2, // Alert!
                'catatan' => 'Konsultasi dokter umum karena gejala demam dan flu ringan.',
            ],
            [
                'tanggal' => '2026-05-27',
                'jam' => '14:30',
                'lokasi' => 'Apotek Kimia Farma',
                'suhu_tubuh' => 37.1,
                'catatan' => 'Menebus resep obat penurun demam.',
            ],
        ]);

        // Note: Araxa begins as a fresh user with 0 logs to test our new premium chart empty state view.
    }
}
