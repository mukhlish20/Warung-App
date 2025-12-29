<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Warung;
use Illuminate\Http\Request;

class WarungController extends Controller
{
    public function index()
    {
        $warungs = Warung::orderBy('nama_warung')->get();

        return view('owner.warung.index', compact('warungs'));
    }

    public function create()
    {
        return view('owner.warung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:100',
        ]);

        Warung::create([
            'nama_warung' => $request->nama_warung,
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
            'nama_warung' => 'required|max:100',
            'alamat' => 'nullable|max:255',
            'no_hp' => 'nullable|max:30',
            'catatan' => 'nullable',
        ]);

        $warung = Warung::findOrFail($id);
        $warung->update($request->all());

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
