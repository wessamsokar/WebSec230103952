<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Artisan;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordEmail;


class UsersController extends Controller
{

    use ValidatesRequests;
    public function insufficientCredit()
    {
        return view('users.insufficient-credit');
    }


    public function updateCredit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'credit' => 'required|numeric|min:0',
        ]);

        $user = User::find($request->id);
        $user->credit = $request->credit;
        $user->save();

        return back()->with('success', 'Credit updated successfully!');
    }



    public function list(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('show_users')) {
            abort(401);
        }

        $query = User::query();

        if (auth()->user()->hasRole('Employee')) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Customer');
            });
        }
        // Exclude users with the Admin role
        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'Admin');
        });

        $query->when(
            $request->keywords,
            fn($q) => $q->where("name", "like", "%$request->keywords%")
        );

        $users = $query->get();
        return view('users.list', compact('users'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'credit' => 'required|numeric|min:0',
            'role' => 'required|exists:roles,name', // Ensure the role exists
        ], [
            'email.unique' => 'The email has already been taken.',
            'role.required' => 'Please select a role.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'credit' => $request->credit,
        ]);

        // Assign the selected role
        $user->assignRole($request->role);

        return redirect()->route('users.list')->with('success', 'User created successfully!');
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('Customer');

        Auth::login($user);

        $title = "Verification Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("verify", ['token' => $token]);
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
        return redirect('/');

    }

    public function showChangePasswordForm()
    {
        return view('users.change-password');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
        }

        // Check regular or temporary password
        if (Hash::check($request->password, $user->password) || ($user->temp_password && Hash::check($request->password, $user->temp_password))) {
            if (!$user->email_verified_at) {
                return redirect()->back()->withErrors(['email' => 'Your email is not verified yet.']);
            }

            Auth::login($user);
            if ($user->temp_password && Hash::check($request->password, $user->temp_password)) {
                return redirect()->route('change_password');
            }
            return redirect('/');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function forgotPassword()
    {
        return view('users.forgot_password');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'This email does not exist.']);
        }

        $tempPassword = Str::random(8);
        $user->temp_password = Hash::make($tempPassword);
        $user->save();

        Mail::to($user->email)->send(new ResetPasswordEmail($tempPassword, $user->name));

        return redirect()->route('login')->with('success', 'A temporary password has been sent to your email.');
    }


    public function changePassword()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Please log in first.']);
        }
        return view('users.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->temp_password = null; // Clear the temporary password
        $user->save();

        return redirect('/')->with('success', 'Password changed successfully.');
    }

    public function doLogout(Request $request)
    {

        Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null)
    {

        $user = $user ?? auth()->user();
        if (auth()->id() != $user->id) {
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

        if (auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }



        return redirect(route('profile', ['user' => $user->id]));
    }

    public function delete(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('delete_users'))
            abort(401);

        // Delete associated purchases first
        $user->purchases()->delete();

        // Then delete the user
        $user->delete();

        return redirect()->route('users.list');
    }

    public function editPassword(Request $request, User $user = null)
    {

        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users'))
                abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user)
    {

        if (auth()->id() == $user?->id) {



            if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {

                Auth::logout();
                return redirect('/');
            }
        } else if (!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function purchases()
    {
        $user = auth()->user();
        $purchases = Purchase::where('user_id', $user->id)->with('product')->get();

        return view('products.bought_products_list', compact('purchases'));
    }

    public function verify(Request $request)
    {
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if (!$user)
            abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return view('users.verified', compact('user'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists, verify email if not verified
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                    $user->save();
                }
                Auth::login($user);
                return redirect('/');
            } else {
                // If user doesn’t exist, create new user and verify email
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)), // Random password
                    'email_verified_at' => now(), // Verify email instantly
                ]);
                $newUser->assignRole('Customer');

                Auth::login($newUser);
                return redirect('/');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Failed to log in with Google. Please try again.']);
        }
    }
}
