<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Admin::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'genre' => 'required|in:Mr,Mme',
        'email' => 'required|email|unique:admins',
        'contact' => 'required|string|size:10|unique:admins',
        'password' => 'required|string|min:6',
        'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('images')) {
        $imagePath = $request->file('images')->store('admins', 'public');
    }

    $admin = Admin::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'genre' => $request->genre,
        'email' => $request->email,
        'contact' => $request->contact,
        'password' => $request->password,
        'images' => $imagePath,
    ]);

    return response()->json(['message' => 'Admin ajouté !', 'data' => $admin], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin non trouvé'], 404);
        }
        return response()->json(['data' => $admin], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $admin = Admin::find($id);
    if (!$admin) {
        return response()->json(['message' => 'Admin non trouvé'], 404);
    }

    $request->validate([
        'email' => 'nullable|email|unique:admins,email,' . $id,
        'contact' => 'nullable|string|size:10|unique:admins,contact,' . $id,
        'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('images')) {
        Storage::disk('public')->delete($admin->images);
        $admin->images = $request->file('images')->store('admins', 'public');
    }

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->update($request->except(['password', 'images']));

    return response()->json(['message' => 'Admin mis à jour !', 'data' => $admin->fresh()], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $admin = Admin::find($id);
    if (!$admin) {
        return response()->json(['message' => 'Admin non trouvé'], 404);
    }

    Storage::disk('public')->delete($admin->images);
    $admin->delete();

    return response()->json(['message' => 'Admin supprimé'], 200);
}
}
