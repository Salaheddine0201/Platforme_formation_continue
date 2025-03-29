<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Domaine;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Storage;

class FormationadminController extends Controller
{
    public function index(Request $request)
    {
        // Préparation de la requête avec les relations nécessaires
        $query = Formation::with(['domaine', 'etablissement']);

        // Filtrage par recherche sur le nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtrage par domaine
        if ($request->filled('domaine')) {
            $query->where('domaine_id', $request->domaine);
        }

        // Filtrage par établissement
        if ($request->filled('etablissement')) {
            $query->where('etablissement_id', $request->etablissement);
        }

        // Récupération des formations paginées (ici 10 par page)
        $formations = $query->paginate(10);

        // Récupération des listes pour les filtres
        $domaines = Domaine::all();
        $etablissements = Etablissement::all();

        return view('admin.formations.index', compact('formations', 'domaines', 'etablissements'));
    }
    public function show($id)
    {
        $formation = Formation::with(['domaine', 'etablissement'])->find($id);
        
        // $formation->sub_titles = json_decode($formation->sub_titles);
        // $formation->requirements = json_decode($formation->requirements);
        // $formation->includes = json_decode($formation->includes);
        // $formation->for_whos = json_decode($formation->for_whos);
        // $formation->languages = json_decode($formation->languages);
        
        
        return response()->json($formation, 200,);
    }

    public function store(Request $request)
    {
        
        $formation = new Formation();
        $formation->nom = $request->nom;
        $formation->etablissement_id = $request->etablissement_id;
        $formation->domaine_id = $request->domaine_id;
        $formation->description = $request->description;
        $formation->trend = $request->has('trend') ? true : false;
        // dd($request->all());
        //Handle JSON fields

        $formation->sub_titles = $request->sub_titles ?? null ;
        $formation->requirements = $request->requirements ?? null;
        $formation->includes = $request->includes ?? null;
        $formation->for_whos = $request->for_whos ?? null;
        $formation->languages = json_encode($request->languages) ?? null;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $formation->image = $request->file('image')->store('formations', 'public');
        }
        
        $formation->save();
        
        return redirect()->route('admin.formations.index')->with('success', 'Formation created successfully!');
    }
    public function update(Request $request, $id)
    {
        $formation = Formation::find($id);
        $formation->nom = $request->nom;
        $formation->etablissement_id = $request->etablissement_id;
        $formation->domaine_id = $request->domaine_id;
        $formation->description = $request->description;
        $formation->trend = $request->has('trend') ? true : false;
        
        //Handle JSON fields
        $formation->sub_titles = $request->sub_titles ?? null ;
        $formation->requirements = $request->requirements ?? null;
        $formation->includes = $request->includes ?? null;
        $formation->for_whos = $request->for_whos ?? null;
        $formation->languages = json_encode($request->languages) ?? null;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            
            $formation->image = $request->file('image')->store('formations', 'public');
        }
        
        $formation->save();
        $formation=Formation::with(['domaine', 'etablissement'])->find($id);
        
        return response()->json(['success' => true,'formation'=>$formation, 'message' => 'Formation updated successfully!']);
    }





    function destroy($id)
    {
        $formation = Formation::find($id);
        if ($formation->image) {
            Storage::delete('formations/' . $formation->image);
        }
        $formation->delete();
        return redirect()->back()->with('success', 'Formation supprimée avec succès');
    }
}
