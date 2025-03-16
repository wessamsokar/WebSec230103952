<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Artisan;
class ProfileController extends Controller
{

    public function register(Request $request)
    {
        return view('auth.register');
    }
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function details()
    {
        $user = Auth::user();

        return view('profile.details', compact('user'));
    }

    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login.form')->with('success', 'Password updated successfully! Please log in with your new password.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('welcome')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome')->with('success', 'Logged out successfully!');
    }
    public function profile(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('show_users'))
                abort(401);
        }
        $permissions = [];
        foreach ($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }
        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null)
    {
        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users'))
                abort(401);
        }
        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }
        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach (Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }
    public function save(Request $request, User $user)
    {
        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('show_users'))
                abort(401);
        }
        $user->name = $request->name;
        $user->save();
        if (auth()->user()->hasPermissionTo('edit_users')) {
            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);
            Artisan::call('cache:clear');
        }
        return redirect(route('profile', ['user' => $user]));
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            

        ]);

        if ($request->password != $request->password_confirmation)

            return redirect()->route('register', ['error' => 'Confirm password not matched.']);

        if (!$request->email || !$request->name || !$request->password)
            return redirect()->route('register', ['error' => 'Missing registration info.']);
        if (User::where('email', $request->email)->first()) //Secure
            return redirect()->route('register', ['error' => 'Missing registration info.']);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); //Secure
        $user->save();
        return redirect("/");
    }


}
