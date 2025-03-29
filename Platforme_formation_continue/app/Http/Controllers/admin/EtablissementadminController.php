<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EtablissementadminController extends Controller
{
    public function index(Request $request)
    {
        $query = Etablissement::query();

        // Apply search filter
        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                ->orWhere('telephone', 'like', '%' . $request->search . '%');
        }

        $etablissements = $query->paginate(10);

        return view('admin.etablissements.index', compact('etablissements'));
    }
    public function edit($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        return response()->json($etablissement);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'localisation' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $etablissement = new Etablissement($validated);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('/logo');
            $etablissement->logo = basename($logoPath);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('/etablissements');
            $etablissement->image = basename($imagePath);
        }

        $etablissement->save();

        return redirect()->back()->with('success', 'Établissement ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $etablissement = Etablissement::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'localisation' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($etablissement->logo) {
                Storage::delete('logo/' . $etablissement->logo);
            }

            $logoPath = $request->file('logo')->store('/logo');
            $etablissement->logo = basename($logoPath);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($etablissement->image) {
                Storage::delete('etablissements/' . $etablissement->image);
            }

            $imagePath = $request->file('image')->store('/etablissements');
            $etablissement->image = basename($imagePath);
        }
        unset($validated['logo'], $validated['image']);
        $etablissement->update($validated);

        return redirect()->route('admin.etablissements.index')->with('success', 'Établissement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $etablissement = Etablissement::findOrFail($id);

        // Delete logo and image if they exist
        if ($etablissement->logo) {
            Storage::delete('logo/' . $etablissement->logo);
        }
        if ($etablissement->image) {
            Storage::delete('etablissements/' . $etablissement->image);
        }

        $etablissement->delete();

        return redirect()->route('admin.etablissements.index')->with('success', 'Établissement supprimé avec succès.');
    }
}
