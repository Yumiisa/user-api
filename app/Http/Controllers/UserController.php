<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
    public function getUsers()
{
    $pdo = DB::connection()->getPdo();
    $stmt = $pdo->query('SELECT username, email FROM users');
    $users = $stmt->fetchAll();

    return view('users', ['users' => $users]);
}
    public function createUser(Request $request)
    {
    // Retrieve user details from the request body
    $userData = $request->all();

    // Create a new user in the database
    $user = User::create($userData);

    // Return a success response
    return response()->json(['message' => 'User created successfully'], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getUsersCountLast7Days()
{
    $count = DB::table('users')
                ->where('registration_date', '>=', now()->subDays(7))
                ->count();

    return $count;
}
}

