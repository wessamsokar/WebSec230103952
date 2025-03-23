<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'display_name' => 'nullable|string|max:128',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'guard_name' => 'web',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        // Get all users who have this permission via their roles
        $users = User::permission($permission->name)->get();
        return view('permissions.edit', compact('permission', 'users'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'display_name' => 'nullable|string|max:128',
            'users' => 'array', // For assigning/unassigning users
        ]);

        // Update only the display_name (name is not editable)
        $permission->update([
            'display_name' => $request->display_name,
        ]);

        // Sync users with this permission via their roles
        if ($request->has('users')) {
            $users = User::find($request->users);
            foreach (User::all() as $user) {
                if ($users->contains($user)) {
                    $user->givePermissionTo($permission); // Assign permission directly or via role
                } else {
                    $user->revokePermissionTo($permission); // Remove permission
                }
            }
        }

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
