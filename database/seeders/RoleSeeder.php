<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ── Reset cached roles and permissions ────────────────────
        // Without this, Spatie can throw errors on re-seed
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Create Roles ──────────────────────────────────────────
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $kitchen = Role::firstOrCreate(['name' => 'kitchen']);

        // ── Create Permissions ────────────────────────────────────
        $permissions = [
            // Admin permissions
            'view dashboard',
            'manage menu',
            'manage categories',
            'manage tables',
            'manage orders',
            'manage users',

            // Kitchen permissions
            'view kitchen',
            'update order status',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Assign All Permissions to Admin ───────────────────────
        $admin->syncPermissions(Permission::all());

        // ── Assign Kitchen-Specific Permissions ───────────────────
        $kitchen->syncPermissions(['view kitchen', 'update order status']);

        $this->command->info('  ✓ Roles and permissions created.');
    }
}