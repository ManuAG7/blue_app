<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserCollection::make(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),

    ]);

    return response()->json([
        'user' => new UserResource($user),
        'message' => 'User created successfully!',
    ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $user = User::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
    ]);

    $user->update($validatedData);

    return response()->json([
        'user' => new UserResource($user),
        'message' => 'User updated successfully!',
    ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $user = User::findOrFail($id);

    $user->delete();

    return response()->json([
        'message' => 'User deleted successfully!',
    ]);
    }


}
