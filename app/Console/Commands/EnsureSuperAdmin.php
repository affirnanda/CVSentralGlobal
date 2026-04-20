<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EnsureSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'ensure:superadmin';

    /**
     * The console command description.
     */
    protected $description = 'Memastikan user super admin selalu ada di database tanpa menghapus data lain';

    public function handle(): void
    {
        // Reset cache Spatie Permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage products',
            'manage orders',
            'manage FAQ',
            'manage testimonials',
            'manage Roles',
            'manage hero section',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions($permissions);

        $user = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        if (!$user->hasRole('super_admin')) {
            $user->assignRole($superAdminRole);
        }

        $this->info('✅ Super Admin dipastikan ada: super@admin.com / admin123');
    }
}
