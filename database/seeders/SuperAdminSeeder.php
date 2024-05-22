<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super_Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => 'Super_Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $superAdminRole->syncPermissions($permissions);

        $user->assignRole([$superAdminRole->id]);
    }
}
