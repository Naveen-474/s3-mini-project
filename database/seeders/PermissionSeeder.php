<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userGroupId = PermissionGroup::where('name', 'User')->first()->id;
        $roleGroupId = PermissionGroup::where('name', 'Role')->first()->id;
        $billGroupId = PermissionGroup::where('name', 'Category')->first()->id;
        $productGroupId = PermissionGroup::where('name', 'Sub Category')->first()->id;
        $customerDetailsGroupId = PermissionGroup::where('name', 'Image')->first()->id;
        $companyDetailsGroupId = PermissionGroup::where('name', 'Company Details')->first()->id;

        $permissions = [
            [
                'name' => 'user.create',
                'group_id' => $userGroupId,
            ],
            [
                'name' => 'user.show',
                'group_id' => $userGroupId,
            ],
            [
                'name' => 'user.edit',
                'group_id' => $userGroupId,
            ],
            [
                'name' => 'user.delete',
                'group_id' => $userGroupId,
            ],
            [
                'name' => 'role.create',
                'group_id' => $roleGroupId,
            ],
            [
                'name' => 'role.show',
                'group_id' => $roleGroupId,
            ],
            [
                'name' => 'role.edit',
                'group_id' => $roleGroupId,
            ],
            [
                'name' => 'role.delete',
                'group_id' => $roleGroupId,
            ],
            [
                'name' => 'category.create',
                'group_id' => $billGroupId,
            ],
            [
                'name' => 'category.show',
                'group_id' => $billGroupId,
            ],
            [
                'name' => 'category.edit',
                'group_id' => $billGroupId,
            ],
            [
                'name' => 'category.delete',
                'group_id' => $billGroupId,
            ],
            [
                'name' => 'sub.category.create',
                'group_id' => $productGroupId,
            ],
            [
                'name' => 'sub.category.show',
                'group_id' => $productGroupId,
            ],
            [
                'name' => 'sub.category.edit',
                'group_id' => $productGroupId,
            ],
            [
                'name' => 'sub.category.delete',
                'group_id' => $productGroupId,
            ],
            [
                'name' => 'image.create',
                'group_id' => $customerDetailsGroupId,
            ],
            [
                'name' => 'image.show',
                'group_id' => $customerDetailsGroupId,
            ],
            [
                'name' => 'image.edit',
                'group_id' => $customerDetailsGroupId,
            ],
            [
                'name' => 'image.delete',
                'group_id' => $customerDetailsGroupId,
            ],
            [
                'name' => 'company.details.create',
                'group_id' => $companyDetailsGroupId,
            ],
            [
                'name' => 'company.details.show',
                'group_id' => $companyDetailsGroupId,
            ],
            [
                'name' => 'company.details.edit',
                'group_id' => $companyDetailsGroupId,
            ],
            [
                'name' => 'company.details.delete',
                'group_id' => $companyDetailsGroupId,
            ],
        ];

        try {
            DB::beginTransaction();
            foreach ($permissions as $permission) {
                $existingPermission = Permission::where('name', $permission['name'])->first();

                if ($existingPermission) {
                    Permission::updateOrCreate(
                        ['name' => $permission['name']],
                        ['permission_group_id' => $permission['group_id']]
                    );
                } else {
                    Permission::create([
                        'name' => $permission['name'],
                        'permission_group_id' => $permission['group_id']
                    ]);
                }
            }

            // Deleting permissions not listed in the seeder
            Permission::whereNotIn('name', array_column($permissions, 'name'))->delete();

            // Update permissions to super admin role
            $superAdminRole = Role::firstOrCreate(['name' => 'Super_Admin']);
            $permissions = Permission::pluck('id', 'id')->all();
            $superAdminRole->syncPermissions($permissions);
            DB::commit();

            info('Permission Seeder Run Successfully !!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
//            logError($e, 'Error while updating permission', 'PermissionSeeder@run');
        }
    }
}
