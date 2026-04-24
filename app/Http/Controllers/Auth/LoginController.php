<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if (!$user->ativo) {
            Auth::logout();
            // return redirect()->route('login')->with('CadastrarUsuario','402');
            return back()->withErrors([
                'email' => 'Seu login está desativado! Contate seu administrador!',
            ]);
        }
    }
}