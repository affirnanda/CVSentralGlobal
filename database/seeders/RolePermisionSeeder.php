<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles & permissions agar tidak konflik saat dijalankan ulang
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar semua permissions
        $permissions = [
            'manage products',
            'manage orders',
            'manage FAQ',
            'manage testimonials',
            'manage Roles',
            'manage hero section',
            'manage profile',
            'manage orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Role admin_cv_solusi dengan permission terbatas
        $admincvsolusiRole = Role::firstOrCreate(['name' => 'admin_cv_solusi']);
        $admincvsolusiRole->syncPermissions([
            'manage products',
            'manage orders',
        ]);

        // Role super_admin dengan semua permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions($permissions);

        // Buat user super admin jika belum ada (firstOrCreate = tidak akan duplikat)
        $user = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        // Assign role super_admin (cek dulu agar tidak duplikat)
        if (!$user->hasRole('super_admin')) {
            $user->assignRole($superAdminRole);
        }
    }
}
