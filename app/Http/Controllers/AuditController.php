<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Audit;
use App\User;
use DB;

class AuditController extends Controller
{
    public function list_all_audits()
    {
        $audits = audit::all();
        $user = user::all();
        return view('admin.auditoria.listAllAudits',compact('audits', 'user'));
    }

    public function filter(Request $request)
    {
        $audits = new audit();
        $user = user::all();
        $audits = $audits->where(function ($query) use ($request){
        if($request->search){
            $query->where('auditable_type', "LIKE", "%{$request->search}%"); 
        }
        if ($request->user_id) {
            $query->where('user_id', "LIKE", "%{$request->user_id}%");
        }
        if ($request->event) {
            $query->where('event', "LIKE", "%{$request->event}%");
        }
        if ($request->id) {
            $query->where('id', "LIKE", "%{$request->id}%");
        }
        if($request->data_inicial && $request->data_final){
            $query->whereDate('created_at', ">=", $request->data_inicial)->whereDate('created_at', "<=", $request->data_final);
        }
        })->get();
            return view('admin.auditoria.listAllAudits', compact('audits', 'user'));
    }

    public function show($id)
    {
        $audit = audit::find($id);
        if($audit){
            return view('admin.auditoria.showAudits', compact('audit'));
        }
        return redirect()->back();
    }
}