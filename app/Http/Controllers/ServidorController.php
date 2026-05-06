<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditServidorRequest;
use App\Servidor;
use Illuminate\Http\Request;

class ServidorController extends Controller
{
    public function index(Request $request)
    {
        $query = Servidor::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('matricula')) {
            $query->where('matricula', 'like', '%' . $request->matricula . '%');
        }

        if ($request->filled('cpf')) {
            $query->where('cpf', 'like', '%' . $request->cpf . '%');
        }

        $servidores = $query->orderBy('nome')->paginate(8)->withQueryString();

        return view('admin.servidores.listar_servidores', compact('servidores'));
    }

    public function edit(int $id)
    {
        $servidor = Servidor::findOrFail($id);

        return view('admin.servidores.edit_servidor', compact('servidor'));
    }

    public function update(EditServidorRequest $request, int $id)
    {
        $dados = $request->validated();

        $servidor = Servidor::findOrFail($id);

        $servidor->update($dados);

        return redirect()
            ->route('Servidor_Edit', $servidor->id)
            ->with('EditarServidor', true);
    }
}
