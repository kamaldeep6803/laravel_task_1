<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[789]\d{9}$/',
            'description' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 400);
        }

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            $imageName = Str::random(10) . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'role_id' => $request->role_id,
            'profile_image' => $imageName,
        ]);

        return response()->json(['status' => 'success', 'data' => $user], 201);
    }

    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }
}
