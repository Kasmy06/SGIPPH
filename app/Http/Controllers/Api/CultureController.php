<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Culture;

class CultureController extends Controller
{
     /**
     * Lister toutes les cultures.
     */
    public function index()
    {
        return response()->json(Culture::all(), 200);
    }

     /**
     * Ajouter une nouvelle culture.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_culture' => 'required|string|max:255',
            'date_culture' => 'required|date',
        ]);

        $culture = Culture::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Culture ajoutée avec succès',
            'data' => $culture,
        ], 201);
    }

    /**
     * Afficher une culture spécifique.
     */
    public function show(string $id)
    {
        $culture = Culture::find($id);

        if (!$culture) {
            return response()->json(['message' => 'Culture non trouvée'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $culture,
        ], 200);
    }


    /**
     * Mettre à jour une culture.
     */
    public function update(Request $request, string $id)
    {
        $culture = Culture::find($id);

        if (!$culture) {
            return response()->json(['message' => 'Culture non trouvée'], 404);
        }

        $request->validate([
            'type_culture' => 'nullable|string|max:255',
            'date_culture' => 'nullable|date',
        ]);

        $culture->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Culture mise à jour avec succès',
            'data' => $culture->fresh(),
        ], 200);
    }


   /**
     * Supprimer une culture.
     */
    public function destroy(string $id)
    {
        $culture = Culture::find($id);

        if (!$culture) {
            return response()->json(['message' => 'Culture non trouvée'], 404);
        }

        $culture->delete();

        return response()->json([
            'status' => true,
            'message' => 'Culture supprimée avec succès',
        ], 200);
    }
}
