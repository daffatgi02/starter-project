<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view settings', 'edit settings',
            'view activity-logs',
            'view media', 'upload media', 'delete media',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $this->createSuperAdminRole($permissions);
        $this->createAdminRole();
        $this->createManagerRole();
        $this->createUserRole();
    }

    private function createSuperAdminRole(array $permissions): void
    {
        Role::create(['name' => 'super-admin'])
            ->givePermissionTo($permissions);
    }

    private function createAdminRole(): void
    {
        Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'view users', 'create users', 'edit users',
                'view roles', 'create roles', 'edit roles',
                'view settings', 'edit settings',
                'view activity-logs',
                'view media', 'upload media', 'delete media',
            ]);
    }

    private function createManagerRole(): void
    {
        Role::create(['name' => 'manager'])
            ->givePermissionTo([
                'view users',
                'view roles',
                'view settings',
                'view activity-logs',
                'view media',
            ]);
    }

    private function createUserRole(): void
    {
        Role::create(['name' => 'user']);
    }
}
