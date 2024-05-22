<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Give the permission to the auth user based on their permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:user.show|user.create|user.edit|user.delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::with('roles')->paginate(5);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
            ]);
            $roles = Role::where('id', $request->role_ids)->get();
            $user->assignRole([$roles]);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e);
            return redirect()->route('user.index')->with('failure', 'User not created');
        }
        DB::commit();

        return redirect()->route('user.index')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return view('users.show', compact('roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        if (!in_array('Super_Admin', $user->roles->pluck('name')->toarray())) {
            $roles = Role::get();

            return view('users.edit', compact('roles', 'user'));
        } else {
            return redirect()->route('user.index')->with('failure', 'This Role User Cannot be editable');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $users = User::all()->except($user->id);
        if (!in_array($request->email, $users->pluck('email')->toArray())) {
            DB::beginTransaction();
            try {
                $user->update($request->all());
                $roles = Role::where('id', $request->role_ids)->get();
                $user->syncRoles([$roles]);
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->route('user.index')->with('failure', 'User not updated');
            }
            DB::commit();

            return redirect()->route('user.index')->with('success', 'User Updated');
        } else {
            return redirect()->back()->with('failure', 'User email address already exit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::with('roles')->findOrFail($id);
        if (!in_array('Super_Admin', $user->roles->pluck('name')->toarray())) {
            DB::beginTransaction();
            try {
                $user->delete();
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->with('failure', 'User not deleted');
            }
            DB::commit();

            return redirect()->back()->with('success', 'User deleted successfully!');
        } else {
            return redirect()->back()->with('failure', 'This Role User Cannot be Delete');
        }
    }
}
