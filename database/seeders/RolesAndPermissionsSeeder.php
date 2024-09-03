<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roller oluştur
        $adminRole = Role::create(['name' => 'admin']);
        $companyRole = Role::create(['name' => 'company']);
        $userRole = Role::create(['name' => 'user']);

        // İzinler oluştur
        $adminPermission = Permission::create(['name' => 'admin access']);
        $companyPermission = Permission::create(['name' => 'company access']);
        $userPermission = Permission::create(['name' => 'user access']);

        // Roller ve izinleri ilişkilendir
        $adminRole->givePermissionTo($adminPermission);
        $companyRole->givePermissionTo($companyPermission);
        $userRole->givePermissionTo($userPermission);
    }
}
