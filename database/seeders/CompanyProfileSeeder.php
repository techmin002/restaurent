<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;
use Modules\Setting\Entities\CompanyProfile as EntitiesCompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        EntitiesCompanyProfile::create([
            'company_name' => 'BG RestroCare',
            'company_email' => 'info@bgrestrocare.com',
            'company_phone' => '+977-9800000000',
            'company_address' => 'Dhangadhi, Kailali, Nepal',
            'logo' => 'uploads/logo.png',
            'footer_logo' => 'uploads/footer_logo.png',
            'favicon' => 'uploads/favicon.ico',
            'image' => 'uploads/company_image.jpg',
            'footer_text' => '© 2025 BG RestroCare. All rights reserved.',
            'introduction' => 'BG RestroCare is a restaurant order management system designed for small to medium businesses.',
            'vision' => 'To simplify restaurant operations with affordable digital solutions.',
            'mission' => 'Empower restaurants with technology that saves time, cost, and effort.',
            'map' => '<iframe src="https://maps.google.com/..." width="100%" height="200" frameborder="0"></iframe>',
            'facebook' => 'https://facebook.com/bgrestrocare',
            'instagram' => 'https://instagram.com/bgrestrocare',
            'twitter' => 'https://twitter.com/bgrestrocare',
            'youtube' => 'https://youtube.com/bgrestrocare',
            'meta_title' => 'Restaurant Order Management | BG RestroCare',
            'meta_description' => 'Affordable order management system for small restaurants in Nepal.',
            'meta_keywords' => 'restaurant, order, management, BG RestroCare, Nepal, QR ordering',
        ]);
    }
}
