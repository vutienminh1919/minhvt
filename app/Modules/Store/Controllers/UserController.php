<?php

namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Store\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('Store::user.list', [
            'data' => $data->toArray(),
        ]);

    }

    public function showFormLogin()
    {
        return view('Store::user.authen');
    }

    public function login(Request $request)
    {


    }

    public function logout(Request $request)
    {


    }

    public function register(Request $request)
    {


    }
}
