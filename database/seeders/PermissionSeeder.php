<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'edit_own_profile',
            'access_user_management',
            'access_settings',
            'access_sliders',
            'show_sliders',
            'create_sliders',
            'edit_sliders',
            'delete_sliders',
            'access_blogs',
            'show_blogs',
            'create_blogs',
            'edit_blogs',
            'delete_blogs',
            'access_advertisements',
            'show_advertisements',
            'create_advertisements',
            'edit_advertisements',
            'delete_advertisements',
            'access_teams',
            'show_teams',
            'create_teams',
            'edit_teams',
            'delete_teams',
            'access_faqs',
            'show_faqs',
            'create_faqs',
            'edit_faqs',
            'delete_faqs',
            'access_testimonials',
            'show_testimonials',
            'create_testimonials',
            'edit_testimonials',
            'delete_testimonials',
            'access_vacancies',
            'show_vacancies',
            'create_vacancies',
            'edit_vacancies',
            'delete_vacancies',
            'access_restaurent',
            'show_restaurent',
            'create_restaurent',
            'edit_restaurent',
            'delete_restaurent',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
