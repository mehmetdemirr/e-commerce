<?php

namespace Database\Seeders;

use App\Enum\UserRole;
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
        $superAdminRole = Role::create(['name' => UserRole::SUPERADMIN->value]);
        $adminRole = Role::create(['name' => UserRole::ADMIN->value]);
        $companyRole = Role::create(['name' => UserRole::COMPANY->value]);
        $userRole = Role::create(['name' => UserRole::USER->value]);

        // // İzinler oluştur
        // $adminPermission = Permission::create(['name' => 'admin access']);
        // $companyPermission = Permission::create(['name' => 'company access']);
        // $userPermission = Permission::create(['name' => 'user access']);

        // // Roller ve izinleri ilişkilendir
        // $adminRole->givePermissionTo($adminPermission);
        // $companyRole->givePermissionTo($companyPermission);
        // $userRole->givePermissionTo($userPermission);
    }
}
