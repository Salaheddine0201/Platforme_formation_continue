<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domaine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DomaineadminController extends Controller
{
// In your DomaineController.php file
public function index(Request $request)
{
    $query = Domaine::query();
    
    // Apply search filter if provided
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = $request->search;
        $query->where('nom', 'like', "%{$searchTerm}%");
        // Add more fields to search if needed
        // $query->orWhere('another_field', 'like', "%{$searchTerm}%");
    }
    
    // Order by created_at or any other field you prefer
    $query->orderBy('created_at', 'desc');
    
    // Get paginated results
    $domaines = $query->paginate(10);
    
    return view('admin.domaines.index', compact('domaines'));
}

    public function edit($id)
    {
        $domaine = Domaine::findOrFail($id);
        return response()->json($domaine);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $domaine = new Domaine($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('/domaines');
            $domaine->image = basename($imagePath);
        }

        $domaine->save();

        return redirect()->route('admin.domaines.index')->with('success', 'Domaine ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $domaine = Domaine::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($domaine->image) {
                Storage::delete('domaines/' . $domaine->image);
            }

            $imagePath = $request->file('image')->store('/domaines');
            $domaine->image = basename($imagePath);
        }

        // Remove image from validated data as we've handled it separately
        unset($validated['image']);
        $domaine->update($validated);

        return redirect()->route('admin.domaines.index')->with('success', 'Domaine mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $domaine = Domaine::findOrFail($id);

        // Delete image if it exists
        if ($domaine->image) {
            Storage::delete('domaines/' . $domaine->image);
        }

        $domaine->delete();

        return redirect()->back()->with('success', 'Domaine supprimé avec succès.');
    }
}
