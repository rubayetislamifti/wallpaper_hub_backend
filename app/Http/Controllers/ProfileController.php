<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('profile')->get();

        $userData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $user->profile->bio ?? null,
                'avatar' => $user->profile->avatar ?? null,
            ];
        });

        return response()->json(['users' => $userData], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('profile')->find($id);
        $profile = $user->profile;
        return response()->json(['user'=>[
           'id'=> $user->id,
          'name'=>  $user->name,
           'email'=> $user->email,
            'bio' => $user->profile->bio ?? null,
            'avatar' => $user->profile->avatar ?? null,
        ]],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = UserProfile::where('user_id',$id)->first();

        $data = $request->only(['username','email', 'bio']);

        if ($request->hasFile('avatar')) {

            if ($user && $user->avatar) {
                $oldPath = public_path('avatars/' . basename($user->avatar));
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'avatars/' . $fileName;

            $file->move(public_path('avatars'), $fileName);

            $data['avatar'] = asset($filePath);
        }

        if ($user) {
            $user->update($data);
        } else {
            $data['user_id'] = $id;
            UserProfile::create($data);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
