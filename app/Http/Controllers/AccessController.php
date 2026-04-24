<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Access;
use App\User;
use DB;

class AccessController extends Controller
{
    public function list_all_access()
    {
        $access = Access::all();
        $user = User::all();
        return view('admin.auditoria.listAllAccess',compact('access', 'user'));
    }

    public function filter(Request $request)
    {
        $access = new Access();
        $user = User::all();
        $access = $access->where(function ($query) use ($request){
        if ($request->user_id) {
            $query->where('user_id', "LIKE", "%{$request->user_id}%");
        }
        if ($request->id) {
            $query->where('id', "LIKE", "%{$request->id}%");
        }
        if($request->data_inicial && $request->data_final){
            $query->whereDate('created_at', ">=", $request->data_inicial)->whereDate('created_at', "<=", $request->data_final);
        }
        if ($request->type) {
            $query->where('type', "LIKE", "%{$request->type}%");
        }
        })->get();
            return view('admin.auditoria.listAllAccess', compact('access','user'));
    }

    public function show($id)
    {
        $access = Access::find($id);
        if($access){
            return view('admin.auditoria.showAccess', compact('access'));
        }
        return redirect()->back();
    }
}