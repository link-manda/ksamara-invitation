<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Template;
use Illuminate\Database\Seeder;

class PackageAndTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Packages
        $packageBronze = Package::updateOrCreate(
            ['name' => 'Bronze'],
            [
                'price' => 99000,
                'max_photos' => 5,
                'enable_bgm' => false,
                'is_active' => true,
                'features' => [
                    'Undangan Digital Web Responsive',
                    'Maksimal 5 Foto Galeri',
                    'Form RSVP & Buku Tamu',
                    'Navigasi Peta Lokasi (Google Maps)',
                    'Masa Aktif 3 Bulan',
                ],
            ]
        );

        $packageSilver = Package::updateOrCreate(
            ['name' => 'Silver'],
            [
                'price' => 199000,
                'max_photos' => 15,
                'enable_bgm' => true,
                'is_active' => true,
                'features' => [
                    'Semua Fitur Paket Bronze',
                    'Maksimal 15 Foto Galeri',
                    'Musik Latar (Background BGM)',
                    'Amplop Digital & QRIS Hadiah',
                    'Masa Aktif 6 Bulan',
                ],
            ]
        );

        $packageGold = Package::updateOrCreate(
            ['name' => 'Gold'],
            [
                'price' => 299000,
                'max_photos' => 30,
                'enable_bgm' => true,
                'is_active' => true,
                'features' => [
                    'Semua Fitur Paket Silver',
                    'Maksimal 30 Foto Galeri',
                    'Desain Premium Eksklusif',
                    'Amplop Digital Multi Rekening & QRIS',
                    'Kutipan Ayat & Kata Mutiara Custom',
                    'Masa Aktif 12 Bulan',
                ],
            ]
        );

        // 2. Seed Templates & assign package availability
        $tplBaliClassic = Template::updateOrCreate(
            ['view_path' => 'themes.bali_classic'],
            [
                'name' => 'Bali Classic Tradisional',
                'is_active' => true,
            ]
        );
        // Universal (Tersedia untuk semua paket)
        $tplBaliClassic->packages()->sync([$packageBronze->id, $packageSilver->id, $packageGold->id]);

        $tplModernElegant = Template::updateOrCreate(
            ['view_path' => 'themes.modern_elegant'],
            [
                'name' => 'Modern Minimalist',
                'is_active' => true,
            ]
        );
        // Tersedia khusus untuk Paket Silver & Gold
        $tplModernElegant->packages()->sync([$packageSilver->id, $packageGold->id]);

        $tplRusticRomance = Template::updateOrCreate(
            ['view_path' => 'themes.rustic_romance'],
            [
                'name' => 'Rustic Floral Warm',
                'is_active' => true,
            ]
        );
        // Tersedia khusus untuk Paket Silver & Gold
        $tplRusticRomance->packages()->sync([$packageSilver->id, $packageGold->id]);

        $tplLuxuryGold = Template::updateOrCreate(
            ['view_path' => 'luxury_gold'],
            [
                'name' => 'Royal Luxury Gold',
                'thumbnail_path' => 'images/scrollytelling/candi-bentar/frame_030.webp',
                'is_active' => true,
            ]
        );
        // Tersedia khusus untuk Paket Gold
        $tplLuxuryGold->packages()->sync([$packageGold->id]);

        $tplCandiBentarScrolly = Template::updateOrCreate(
            ['view_path' => 'scrolly_candi_bentar'],
            [
                'name' => 'Candi Bentar Scrollytelling',
                'thumbnail_path' => '/images/scrollytelling/candi-bentar/frame_030.webp',
                'is_active' => true,
            ]
        );
        // Tersedia khusus untuk Paket Silver & Gold
        $tplCandiBentarScrolly->packages()->sync([$packageSilver->id, $packageGold->id]);
    }
}
