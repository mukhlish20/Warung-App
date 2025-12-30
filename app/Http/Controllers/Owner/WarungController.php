<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Warung;
use Illuminate\Http\Request;

class WarungController extends Controller
{
    public function index()
    {
        $warungs = Warung::orderBy('nama')->get();

        return view('owner.warung.index', compact('warungs'));
    }

    public function create()
    {
        return view('owner.warung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:warungs,nama',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30|regex:/^(\+62|62|0)[0-9]{7,15}$/',
            'catatan' => 'nullable|string|max:500',
        ]);

        Warung::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'owner_id' => auth()->id(),
            'persentase_owner' => 50,
            'persentase_penjaga' => 50,
            'no_hp' => $request->no_hp,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('owner.warung.index')
            ->with('success', 'Cabang warung berhasil ditambahkan');
    }

    public function edit($id)
    {
        $warung = Warung::findOrFail($id);
        return view('owner.warung.edit', compact('warung'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:warungs,nama,' . $id,
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30|regex:/^(\+62|62|0)[0-9]{7,15}$/',
            'catatan' => 'nullable|string|max:500',
        ]);

        $warung = Warung::findOrFail($id);
        $warung->update($request->only(['nama', 'alamat', 'no_hp', 'catatan']));

        return redirect()
            ->route('owner.warung.index')
            ->with('success', 'Profil warung berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $warung = Warung::findOrFail($id);

        // Lepaskan penjaga dari cabang ini
        \App\Models\User::where('warung_id', $warung->id)
            ->update(['warung_id' => null]);

        $warung->delete(); // soft delete

        return redirect()
            ->route('owner.warung.index')
            ->with('success', 'Cabang warung berhasil dihapus');
    }


}
