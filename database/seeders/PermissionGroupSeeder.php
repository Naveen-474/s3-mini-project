<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = [
            [
                'name' => 'User',
            ],
            [
                'name' => 'Role',
            ],
            [
                'name' => 'Category',
            ],
            [
                'name' => 'Sub Category',
            ],
            [
                'name' => 'Image',
            ],
            [
                'name' => 'Company Details',
            ],
        ];

        foreach ($permissionGroups as $key => $value) {
            $permisionGroup = new PermissionGroup;
            $permisionGroup->name = $value['name'];
            $permisionGroup->save();
        }
    }
}
