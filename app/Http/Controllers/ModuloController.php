<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModuloController extends Controller
{
    public function index(){

        $user =  auth()->user();
        $modulos = $user->modulos;

        //$modulos = Modulo::orderBy('id', 'DESC')->get();
        

        return view('modulos.index', compact('modulos'));
    }

    public function show(Modulo $modulo){
        
        $user = auth()->user();
        
        $modulo_user = DB::table('modulos')
        ->leftJoin('participantes', 'modulos.id', '=', 'participantes.modulo_id')
        ->where('participantes.user_id', '=', $user->id)
        ->where('participantes.modulo_id','=',$modulo->id)
        ->select('user_id','modulo_id','rol','name')
        ->get(); 

        return view('modulos.show', compact(['modulo_user','modulo']));
    }
}
