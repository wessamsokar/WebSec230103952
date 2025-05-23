<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'Admin')->get(); // Exclude Admin role
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        if (strtolower($request->name) === 'admin') {
            return redirect()->back()->with('error', 'Creating an Admin role is not allowed.');
        }

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->permissions) {
            $permissions = Permission::pluck('id')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        if (strtolower($role->name) === 'admin') {
            return redirect()->route('roles.index')->with('error', 'Editing Admin role is not allowed.');
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id,
        'permissions' => 'array', // Ensure permissions is an array
    ]);

    if (strtolower($role->name) === 'admin') {
        return redirect()->route('roles.index')->with('error', 'Updating Admin role is not allowed.');
    }

    // Update the role name
    $role->update(['name' => $request->name]);

    // Sync permissions using IDs
    if ($request->permissions) {
        // Fetch permissions by their IDs and sync them
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
    } else {
        $role->syncPermissions([]); // Remove all permissions if none selected
    }

    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}
    public function destroy(Role $role)
    {
        if (strtolower($role->name) === 'admin') {
            return redirect()->route('roles.index')->with('error', 'Deleting Admin role is not allowed.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
