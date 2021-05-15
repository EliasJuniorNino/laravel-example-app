<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request)
    {

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'message' => 'Email ou senha invalido.',
        ]);
    }

    public function signup()
    {
        return view('auth.signup');
    }


    public function createAccount(Request $request)
    {
        $credentials = $request->only(['name', 'email', 'password']);

        try {
            User::create($credentials);
        } catch (Exception $e) {
            return back()->withErrors([
                'message' => 'Erro ao criar usuário, preencha os campos corretamente',
            ]);
        }

        $loginCredentials = $request->only(['email', 'password']);

        if (Auth::attempt($loginCredentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return redirect()->intended('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
