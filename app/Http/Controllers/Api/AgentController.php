<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = Agent::paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Liste des agents',
            'data' => $agents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'contact' => 'required|string|size:10|unique:agents,contact',
            'email' => 'required|string|email|unique:agents,email',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image obligatoire
        ]);

        $imagePath = null;
        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('agents', 'public'); // Stockage dans storage/app/public/agents
        }

        $agent = Agent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Agent créé avec succès',
            'data' => $agent,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agent = Agent::with('admins', 'parcelles', 'producteurs')->find($id);

        if (!$agent) {
            return response()->json(['status' => false, 'message' => 'Agent introuvable'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $agent,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agent = Agent::findOrFail($id);
        if (!$agent) {
            return response()->json([
                'status' => false,
                 'message' => 'Agent introuvable'], 404);
        }
                $request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'contact' => 'nullable|string|size:10|unique:agents,contact,' . $id,
            'email' => 'nullable|string|email|unique:agents,email,' . $id,
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('images')) {
            // Supprimer l'ancienne image si elle existe
            if ($agent->images) {
                Storage::disk('public')->delete($agent->images);
            }
            $imagePath = $request->file('images')->store('agents', 'public');
            $agent->images = $imagePath;
        }

        $agent->update([
            'nom' => $request->nom ?? $agent->nom,
            'prenom' => $request->prenom ?? $agent->prenom,
            'contact' => $request->contact ?? $agent->contact,
            'email' => $request->email ?? $agent->email,
            'password' => $request->password ? Hash::make($request->password) : $agent->password,
            'image' => $agent->images,
        ]);

        
        return response()->json([
            'status' => true,
            'message' => 'Agent mis à jour avec succès',
            'data' => $agent->fresh(),
        ], 200);
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agent = Agent::findOrFail($id);

        if ($agent->image) {
            Storage::disk('public')->delete($agent->image);
        }

        $agent->delete();

        return response()->json([
            'status' => true,
            'message' => 'Agent supprimé avec succès',
        ], 200);
    }
    
}
