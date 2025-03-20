<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcelle;
use Illuminate\Http\Request;

class ParcelleController extends Controller
{

    // 🔹 Récupérer toutes les parcelles
    public function index()
    {
        $parcelles = Parcelle::with('producteur')->get();

        return response()->json([
            'message' => 'Liste des parcelles récupérée avec succès!',
            'data' => $parcelles,
        ], 200);
    }

   // Méthode pour créer une parcelle
   public function store(Request $request)
   {
       // Validation des données entrantes
       $request->validate([
           'nom' => 'required|string',
           'superficie' => 'required|numeric',
           'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
           'producteur_id' => 'required|exists:producteurs,id', // Validation du producteur
       ]);

       // Création d'une nouvelle parcelle
       $parcelle = Parcelle::create([
           'nom' => $request->nom,
           'superficie' => $request->superficie,
           'latitude' => $request->latitude,
           'longitude' => $request->longitude,
           'producteur_id' => $request->producteur_id, // ID du producteur
       ]);

       // Retourner la réponse après l'insertion
       return response()->json([
           'message' => 'Parcelle créée avec succès!',
           'data' => $parcelle,
       ], 201);
   }
}