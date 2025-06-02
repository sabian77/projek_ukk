<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller

{
    public function index(): JsonResponse
    {
        $users = User::select('id', 'name', 'email', 'password', 'created_at')->get();

        return response()->json($users);
    }
}
    // Login GET (untuk pengecekan status)
    