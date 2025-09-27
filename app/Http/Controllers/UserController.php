<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('admin.user.index', compact('data'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin_putra',
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan')    ;
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        
        return view('admin.user.edit', compact('data'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
     'username' => 'required|unique:users,username,' . $request->user_id . ',id',
        'password' => 'nullable|min:6', 
    ]);

    $user = User::findOrFail($id);

    $data = [
        'username' => $request->username,
    ];

    // hanya update password jika ada input
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
}

}
