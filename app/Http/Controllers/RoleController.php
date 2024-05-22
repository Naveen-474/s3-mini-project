<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Give the permission to the auth user based on their permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:role.show|role.create|role.edit|role.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('roles.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        info($request);
        DB::beginTransaction();
        try {
            $role = Role::create($request->all());
            $permissions = Permission::where('id', $request->permission_ids)->get();
            $role->syncPermissions($permissions);
            info($role);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e);
            return redirect()->route('role.index')->with(['failure' => 'Role Created']);
        }
        DB::commit();

        return redirect()->route('role.index')->with(['success' => 'Role Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Role $role)
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('roles.show', compact('role', 'permissionGroups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Role $role)
    {
        if ($role->name != 'Super_Admin') {
            $permissionGroups = PermissionGroup::with('permissions')->get();

            return view('roles.edit', compact('role', 'permissionGroups'));
        } else {
            return redirect()->route('role.index')->with('failure', 'This Role Cannot be editable');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $roles = Role::WhereNot('id', $role->id)->get();
        if (!in_array($request->name, $roles->pluck('name')->toArray())) {
            DB::beginTransaction();
            try {
                $role->name = $request->name;
                $role->save();
                $permissions = Permission::where('id', $request->permission_ids)->get();
                $role->syncPermissions($permissions);
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->route('role.index')->with('failure', 'Role not updated');
            }
            DB::commit();

            return redirect()->route('role.index')->with('success', 'Role Updated');
        } else {
            return redirect()->back()->with('failure', 'Role name already exit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        if ($role->name != 'Super_Admin') {
            DB::beginTransaction();
            try {
                $role->delete();
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('failure', 'Role not deleted');
            }
            DB::commit();

            return redirect()->back()->with('success', 'Role deleted successfully!');
        } else {
            return redirect()->back()->with('failure', 'This Role Cannot be deleted');
        }
    }
}
