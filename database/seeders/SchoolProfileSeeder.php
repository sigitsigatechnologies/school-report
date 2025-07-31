<?php

namespace Database\Seeders;

use App\Models\SchoolProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolProfile::create([
            'nama_sekolah' => 'SD Bopkri Turen Bantul',
            'npsn' => '17081945',
            'nss' => '10101',
            'alamat' => 'Jalan Merdeka No. 17',
            'kode_pos' => '171717',
            'kalurahan' => 'Pantang Mundur',
            'kapanewon' => 'Bantul',
            'kabupaten' => 'Bantul',
            'provinsi' => 'Daerah Istimewa Yogyakarta',
            'website' => 'www.sdmerdeka.com',
            'email' => 'sdmerdeka@gmail.com',
            'kepala_sekolah' => 'Suparman, M.Pd.',
            'nip_kepala_sekolah' => 'NIP 123456789',
            'wali_kelas' => 'Himawan Sulistyo, M.Pd',
            'nip_wali_kelas' => 'NIP 987654321',
            'kelas' => 'Kelas III (Tiga)',
            'fase' => 'C',
            'semester' => '2 (Dua)',
            'tahun_ajaran' => '2024/2025',
            'tempat_tanggal_rapor' => 'Bantul, 26 Juni 2025',
        ]);
    }
}
