<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Producteur;
use Illuminate\Http\Request;

class ProducteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //  Liste des producteurs
   
    public function index()
    {
        $producteurs = Producteur::paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Liste des producteurs',
            'data' => $producteurs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
     // Ajouter un producteur
     public function store(Request $request)
     {
        
         $data = $request->validate([
             'nom' => 'required|string',
             'prenom' => 'required|string',
             'genre' => 'required|in:Mr,Mme',
             'contact' => 'required|digits:10|unique:producteurs,contact', // Seuls 10 chiffres acceptés
             'localite' => 'required|string',
             'naissance' => 'required|date',
             'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Accepte images jusqu'à 2Mo
             'id_agent' => 'required|exists:agents,id', // Validation pour s'assurer que l'id_agent existe dans la table agents
         ]);
     
         // Sauvegarde de l'image si fournie
         if ($request->hasFile('images')) {
             $imagePath = $request->file('images')->store('images', 'public'); // Stocke dans storage/app/public/images/
             $data['images'] = $imagePath; // Stocke le chemin dans la BD
         }
     
         $producteur = Producteur::create($data);
     
         return response()->json([
             'status' => true,
             'message' => 'Producteur ajouté avec succès',
             'data' => $producteur,
         ], 201);
     }
 

    /**
     * Display the specified resource.
     */
    //  Voir les détails d'un producteur
    public function show($id)
    {
        $producteur = Producteur::find($id);
    
        if (!$producteur) {
            return response()->json(['status' => false, 'message' => 'Producteur introuvable'], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Détails du producteur',
            'data' => $producteur,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

   //  Modifier un producteur avec image
   public function update(Request $request, $id)
   {
    
    $producteur = Producteur::find($id);
    if (!$producteur) {
        return response()->json([
            'status' => false,
             'message' => 'Producteur introuvable'], 404);
    }

    // Valider uniquement les champs présents dans la requête
    $data = $request->validate([
        'nom' => 'sometimes|required|string',
        'prenom' => 'sometimes|required|string',
        'genre' => 'sometimes|in:Mr,Mme',
        'contact' => 'sometimes|required|digits:10|unique:producteurs,contact,' . $producteur->id,
        'localite' => 'sometimes|required|string',
        'naissance' => 'sometimes|required|date',
        'images' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        'id_agent' => 'sometimes|required|exists:agents,id', // Validation pour s'assurer que l'id_agent existe dans la table agents
    ]);

   // print_r($request->all());die;

    // Gérer l'upload de l'image si elle est présente
    if ($request->hasFile('images')) {
        if ($producteur->images) {
            Storage::disk('public')->delete($producteur->images);
        }
        $data['images'] = $request->file('images')->store('images', 'public');
    }

    // Vérification des changements
    $producteur->fill($data);
    if (!$producteur->isDirty()) {
        return response()->json([
            'status' => false, 
            'message' => 'Aucune modification détectée']);
    }

    // Enregistrer les modifications
    $producteur->save();

    return response()->json([
        'status' => true,
        'message' => 'Producteur mis à jour avec succès',
        'data' => $producteur->fresh(),
    ]);
   }


    /**
     * Remove the specified resource from storage.
     */
    //  Supprimer un producteur
    public function destroy($id)
    {
        $producteur = Producteur::find($id);
        if (!$producteur) {
            return response()->json(['status' => false, 'message' => 'Producteur introuvable'], 404);
        }
         // Suppression de l'image associée
         if ($producteur->images) {
            Storage::disk('public')->delete($producteur->images);
        }
        $producteur->delete();

        return response()->json([
            'status' => true,
            'message' => 'Producteur supprimé avec succès',
        ]);
    }
}