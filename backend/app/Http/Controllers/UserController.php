<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Get all users.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Add a new user.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 2,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $userData = $request->only(['name', 'email', 'contact']);
        $userData['password'] = bcrypt('password'); // Default password for newly added users

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $imageName, 'public');
            $userData['user_image'] = $imagePath;
        }

        $user = User::create($userData);

        return response()->json([
            'code' => 1,
            'message' => 'User Created Successfully!',
            'data' => $user
        ]);
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['code' => 2, 'message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'contact' => 'required|string|max:15',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 2,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $userData = $request->only(['name', 'email', 'contact']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $imageName, 'public');
            $userData['user_image'] = $imagePath;
        }

        $user->update($userData);

        return response()->json([
            'code' => 1,
            'message' => 'User Updated Successfully!',
            'data' => $user
        ]);
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user && $user->delete()) {
            return response()->json(['code' => 1, 'message' => 'User Deleted Successfully!']);
        }
        return response()->json(['code' => 2, 'message' => 'Error while Deleting User!'], 500);
    }
}
