<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Cria um usuario e retorna seu token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|max:255',
            'password' => 'required|string',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'OK',
            'data' => $user,
        ], 201);
    }

    public function create()
    {
        $user = User::all();

        return response()->json(compact('user'));
    }

    /**
     * Retorna o usuario logado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user);
    }
}
