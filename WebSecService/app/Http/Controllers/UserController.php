<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        \Log::info('Store Request Data:', $request->all());

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ], [
            'email.unique' => 'The email has already been taken.'
        ]);

        \Log::info('Validation passed');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);


        \Log::info('User created successfully', ['user' => $user]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            if (is_numeric($search)) {
                $query->where('id', $search);
            } else {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'email.unique' => 'The email has already been taken.'
        ]);

        $user->update($request->only('name'));

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
