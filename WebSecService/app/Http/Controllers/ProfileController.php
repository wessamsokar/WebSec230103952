<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
class ProfileController extends Controller
{


    public function details()
    {
        $user = Auth::user(); // Fetch authenticated user data

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
            return redirect()->route('welcome');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form')->with('success', 'Logged out successfully!');
    }
    public function register(Request $request)
    {
        return view('users.register');
    }
    use ValidatesRequests;
    public function doRegister(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->numbers()->letters()->mixedCase()->symbols()
            ],
        ]);
        if ($request->password != $request->confirm_password)
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
