<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $rules = [
            'level_id'   => 'required|integer',
            'username'   => 'required|string|min:3|unique:m_user,username',
            'nama'       => 'required|string|max:100',
            'password'   => 'required|min:6',
            'file_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Prepare the new request data
        $newReq = [
            'level_id' => $request->level_id,
            'username' => $request->username,
            'name'     => $request->nama,
            'password' => $request->password, // hash the password
        ];

        $user = UserModel::create($newReq);

        // Handle profile image file upload
        $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
        $fileName = 'profile_' . $user->user_id . '.' . $fileExtension;

        // Check if an existing profile picture exists and delete it
        $oldFile = 'profile_pictures/' . $fileName;
        if (Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        // Store the new file with the user id as the file name
        $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');

        // Add the profile file name to the new request data
        $user = UserModel::find($user->user_id);
        $user->image_profile = $path;
        $user->save();

        // Create the new user record in the database

        return response()->json($user, 201);
    }

    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }

    public function update(Request $request, UserModel $user)
    {
        $rules = [
            'level_id'   => 'required|integer',
            'username'   => 'required|max:20|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama'       => 'required|max:100',
            'password'   => 'nullable|min:6|max:20',
            'file_profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Prepare the request data
        $newReq = [
            'level_id' => $request->level_id,
            'username' => $request->username,
            'name'     => $request->nama,
        ];

        $check = UserModel::find($user->user_id);
        if ($check) {
            // If password is provided, add it to the update request
            if ($request->filled('password')) {
                $newReq['password'] = $request->password; // hash the password
            }

            // Handle profile image file upload
            if ($request->hasFile('file_profil')) {
                // Define the file name using the user's id and the file extension
                $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
                $fileName = 'profile_' . $user->user_id . '.' . $fileExtension;

                // Check if an existing profile picture exists and delete it
                $oldFile = 'profile_pictures/' . $fileName;
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                // Store the new file with the user id as the file name
                $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');

                // Add file name to the update request
                $newReq['image_profile'] = $path;
            }
            // Update the user data in the database
            $check->update($newReq);

            return response()->json($check, 201);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}
