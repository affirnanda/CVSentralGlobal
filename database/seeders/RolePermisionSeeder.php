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
        // untuk role banyak
        $permissions = [
            'manage products',
            'manage orders',
            'manage FAQ',
            'manage testimonials',
            'manage Roles',
            'manage hero section',
        ];

        foreach ($permissions as $permission){
            Permission::firstOrCreate(
                [
                    'name' => $permission,   
                ]
            );
        }

        $admincvsolusiRole = Role::firstOrCreate([
            'name' => 'admin_cv_solusi'
        ]);
        $admincvsolusiPermissions = [
            'manage products',
            'manage orders',
           ];
        $admincvsolusiRole->syncPermissions($admincvsolusiPermissions);
        //kode diatas jika lebih dari 1 role super admin


        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin'
            ]);

         $user = User::create([
            'name' => 'AdminCv',
            'email' => 'super@admin.com',
            'password' => bcrypt('admin123')
            ]);
            
          $user->assignRole($superAdminRole);  
    }
}
