<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class PenjagaController extends Controller
{
    public function index()
    {
        $penjagas = User::where('role', 'penjaga')
            ->with('warung')
            ->orderBy('name')
            ->get();

        return view('owner.penjaga.index', compact('penjagas'));
    }

    public function edit(User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        $warungs = Warung::orderBy('nama_warung')->get();

        return view('owner.penjaga.edit', compact('user', 'warungs'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'warung_id' => 'nullable|exists:warungs,id',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'warung_id' => $request->warung_id,
        ]);

        return redirect()
            ->route('owner.penjaga.index')
            ->with('success', 'Data penjaga berhasil diperbarui');
    }


    public function create()
    {
        $warungs = Warung::orderBy('nama_warung')->get();
        return view('owner.penjaga.create', compact('warungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8',
            'warung_id' => 'required|exists:warungs,id',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'penjaga',
            'warung_id' => $request->warung_id,
        ]);

        return redirect()
            ->route('owner.penjaga.index')
            ->with('success', 'Penjaga berhasil ditambahkan');
    }

    public function unassign(User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        $user->update([
            'warung_id' => null,
        ]);

        return redirect()
            ->route('owner.penjaga.index')
            ->with('success', 'Penjaga berhasil dilepas dari cabang');
    }

    public function resetPasswordForm(User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        return view('owner.penjaga.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('owner.penjaga.index')
            ->with('success', 'Password penjaga berhasil direset');
    }
    public function toggleActive(User $user)
    {
        abort_if($user->role !== 'penjaga', 403);

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return redirect()
            ->route('owner.penjaga.index')
            ->with('success', 'Status akun penjaga diperbarui');
    }


}
