<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //
    public function retrive(Request $request){

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('created_at')) {
            $query->where('created_at', 'like', '%' . $request->created_at . '%');
        }

        if ($request->filled('updated_at')) {
            $query->where('updated_at', 'like', '%' . $request->updated_at . '%');
        }

        $users = $query->get();

        
        $users->transform(function ($user) {
            return  [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'active' => $user->active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'links' => [
                        'self' => route('user.show', ['user' => $user->id]),
                        'update' => route('user.update', ['user' => $user->id]),
                        'delete' => route('user.destroy', ['user' => $user->id]),
                        'deactivate' => route('user.deactivate', ['user' => $user->id])
                    ]
        ];
        });
        
        $response = [
            'caption' => 'Usuarios',
            'create' => route('user.create'),
            'data' => $users,
        ];

        return response()->json($response);
        
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json(['data' => $user]);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->active = $request->active;
            $user->save();
            return response()->json(['message' => 'Usuario actualizado correctamente.']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }
    
    public function destroy($id)
    {
        
        $user = User::find($id);

        if ($user) {
           $user->delete(); // Realiza el soft delete
            return response()->json(['message' => 'Usuario eliminado correctamente.']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
        
    }
    
    public function deactivate($id)
    {

        $user = User::find($id);
        $user->active = !$user->active;

        $user->save();

        if ($user) {
            return response()->json(['message' => 'Usuario desactivado correctamente.']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }
}
