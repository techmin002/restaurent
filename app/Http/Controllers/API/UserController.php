<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')->get();
        if($users){
            return response()->json([
                'status' => 'sucess',
                'code' => 200,
                'data' => $users,
                'message' => 'Users fetched successfully'
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Users not found'
            ]);
        }
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
        $existingUser = User::where('email', $request->email)->first();
        if($existingUser){
            return response()->json([
                'status' => 'error',
                'code' => 409,
                'message' => 'Email already exists'
            ]);
        }else{
       $user = new User();
         $user->name = $request->name;
         $user->email = $request->email;
         $user->password = bcrypt($request->password);
         $user->save();
         if(!$user){
             return response()->json([
                 'status' => 'error',
                 'code' => 500,
                 'message' => 'User not created'
             ]);
         }else{
                return response()->json([
                    'status' => 'success',
                    'code' => 201,
                    'data' => $user,
                    'message' => 'User created successfully'
                ]);
         }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            if($user){
                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'data' => $user,
                    'message' => 'User updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => 'User not updated'
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'User not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
        if($user){
            $user->delete();
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'User deleted successfully'
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'User not found'
            ]);
        }
    }
}
