<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            'manage statistics',
            'menage products',
            'menage principles',
            'menage testimonials',
            'menage clients',
            'menage teams',
            'menage abouts',
            'menage appointments',
            'menage hero sections',
        ];

        foreach($permission as $permission){
            Permission::firstOrCreate(
                [
                    'name' => $permission
                ]
            );
        }

        $designManagerRole = Role::firstOrCreate([
            'name' => 'designer_manager'
        ]);

        $designManagerPermissions = [
            'menage products',
            'menage principles',
            'menage testimonials',
        ];

        $designManagerRole->syncPermissions($designManagerPermissions);

        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin'
        ]);

        $user = User::create([
            'name' => 'ShaynaComp',
            'email' => 'super@admin.com',
            'password' => bcrypt('123123123')
        ]);

        $user->assignRole($superAdminRole);
    }
}
