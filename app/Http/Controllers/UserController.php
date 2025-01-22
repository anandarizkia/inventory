<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(UserStoreRequest $request)
    {
        try {
            // Create User
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Return Json Response
            return response()->json([
                'message' => 'User successfully created.'
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => 'Something went really wrong!'
            ], 500);
        }
    }


    public function show($id)
    {
        // User Detail
        $users = User::find($id);
        if (!$users) {
            return response()->json([
                'message' => 'User Not Found.'
            ], 404);
        }

        // Return Json Response
        return response()->json([
            'users' => $users
        ], 200);
    }

    
    public function edit($id)
    {
        // Logic for editing a user can be implemented here
    }

    public function update(UserStoreRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                'message' => 'User  successfully updated.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went really wrong!'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'User  successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went really wrong!'
            ], 500);
        }
    }
}