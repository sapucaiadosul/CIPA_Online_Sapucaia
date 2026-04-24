<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroUsuarioRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $user = user::all();
        return view('admin.usuarios.listUser', compact('user'));
    }

    public function create()
    {
        return view('admin.usuarios.register');
    }

    public function store(CadastroUsuarioRequest $request)
    {
        $usuario = new user();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->cpf = $request->input('cpf');
        $usuario->password = Hash::make($request->password);
        $usuario->nivel = $request->input('nivel');
        $usuario->save();

        if ($usuario->save()) {
            return redirect()->route('Usuarios_listUser')->with('CadastrarUsuario', '402');
        } else {
            return redirect()->route('Usuarios_listUser')->with('CadastrarUsuario', '402');
        }
    }

    public function editar($id)
    {
        $usuario = user::find($id);
        if ($usuario) {
            return view('admin.usuarios.editUser', compact('usuario'));
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $usuario = user::find($request->user_id);
        if (!$usuario) {
            return redirect()->back();
        }
        $request->session()->put('AtualizarUsuario', [

            $usuario = $usuario->update([
                'name' => $request->name,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'password' => Hash::make($request->password),
                'nivel' => $request->nivel

            ])
        ]);
        return redirect()->route('Usuarios_listUser')->with('CadastrarUsuario', '402');
    }

    public function usuario_ativo(user $user, Request $request)
    {
        $user->ativo = $request->input('ativo');
        $user->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $usuario = user::find($id);
        if ($usuario) {
            $usuario->delete();
            flash('Exclusão realizada com sucesso!')->success();
            return redirect()->back()->with('ExcluirUsuario', '402');
        }
        return redirect()->back()->with('ExcluirUsuario', '402');
    }
}
