<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,student_affairs_staff',
        ]);

        // Membuat User Baru dengan Role
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role'), // Tambahkan role ke dalam user
        ]);

        $user->save();

        return redirect('/users')->with('success', 'Staff Berhasil Ditambahkan');
    }

    public function show(User $user)
    {

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,student_affairs_staff',
        ]);


        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role = $request->get('role');
        if ($request->get('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect('/users')->with('success', 'Staff Berhasil di Update');
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect('/users')->with('success', 'Staff Berhasil DI Hapus');
    }

    public function resetPassword(User $user)
    {
        // Generate a new password
        $newPassword = 'admin@smkn4Garut'; // Generate password

        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Optionally, you can send the new password to the user via email
        // Mail::to($user->email)->send(new ResetPasswordMail($newPassword));

        return redirect()->route('users.index')->with('success', 'Password Dari Staff '. $user->name. 'Berhasil DI Ubah dengan Password '.$newPassword);
    }
}
