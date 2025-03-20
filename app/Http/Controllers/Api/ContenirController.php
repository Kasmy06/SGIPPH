<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcelle;
use App\Models\Culture;



class ContenirController extends Controller
{
    // Associer une culture à une parcelle
    public function attachCulture(Request $request)
    {
        $request->validate([
            'parcelle_id' => 'required|exists:parcelles,id',
            'culture_id' => 'required|exists:cultures,id',
        ]);

        $parcelle = Parcelle::findOrFail($request->parcelle_id);
        $parcelle->cultures()->attach($request->culture_id);

        return response()->json([
            'message' => 'Culture associée à la parcelle avec succès!',
            'data' => $parcelle->cultures
        ], 200);
    }

    // Détacher une culture d'une parcelle
    public function detachCulture(Request $request)
    {
        $request->validate([
            'parcelle_id' => 'required|exists:parcelles,id',
            'culture_id' => 'required|exists:cultures,id',
        ]);

        $parcelle = Parcelle::findOrFail($request->parcelle_id);
        $parcelle->cultures()->detach($request->culture_id);

        return response()->json(['message' => 'Culture détachée avec succès!'], 200);
    }

    // Lister les cultures d'une parcelle
    public function getCulturesByParcelle($parcelle_id)
    {
        $parcelle = Parcelle::with('cultures')->findOrFail($parcelle_id);

        return response()->json([
            'message' => 'Liste des cultures de la parcelle',
            'data' => $parcelle->cultures
        ], 200);
    }

    // Lister les parcelles pour une culture
    public function getParcellesByCulture($culture_id)
    {
        $culture = Culture::with('parcelles')->findOrFail($culture_id);

        return response()->json([
            'message' => 'Liste des parcelles cultivant cette culture',
            'data' => $culture->parcelles
        ], 200);
    }
}