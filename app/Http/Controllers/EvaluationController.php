<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluation;
use PhpParser\Node\Expr\Eval_;
use App\Models\Category;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Modulo $modulo)
    {
        //$user = auth()->user();
        
        /* $modulo_user = DB::table('modulos')
        ->leftJoin('participantes', 'modulos.id', '=', 'participantes.modulo_id')
        ->where('participantes.user_id', '=', $user->id)
        ->where('participantes.modulo_id','=',$modulo->id)
        ->select('user_id','modulo_id','rol','name','slug')
        ->get();  */


        /* $modulo = Modulo::whereHas('participantes', function ($query) use($user,$modulo) {
            return $query->where('user_id', '=', $user->id)->where('modulo_id','=',$modulo->id);
        })->get();

        return $modulo; */

        $pautas = Evaluation::has('category')->where('modulo_id','=',$modulo->id)->orderBy('id','DESC')->get();

        //$pautas->category()->get();
        foreach($modulo->participantes as $participante){
            if($participante->pivot->user_id == auth()->user()->id){
                $rol = $participante->pivot->rol;
                break;
            }
        }
        //return $pautas;

        return view('evaluations.index', compact(['modulo','pautas','rol']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo)
    {

        $categories= Category::pluck('name','id');

        return view('evaluations.create',compact(['modulo','categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Modulo $modulo)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:evaluations',
            'category_id' => 'required',
        ]);

        $request->merge(['modulo_id' => $modulo->id]);

        $pauta = Evaluation::create($request->all());

        return redirect()->route('evaluations.index',$modulo)->with('info','La pauta de evaluación se creó exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo, Evaluation $evaluation)
    {
        $categories= Category::pluck('name','id');
        return view('evaluations.edit',compact(['modulo','evaluation','categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulo $modulo, Evaluation $evaluation)
    {
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:evaluations,slug,$evaluation->id",
            'category_id' => 'required',
        ]);
        $request->merge(['modulo_id' => $modulo->id]);

        $evaluation->update($request->all());

        return redirect()->route('evaluations.index', $modulo)->with('info','La pauta de evaluación se actualizó con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo, $id)

    {   
        $pauta = Evaluation::where('id','=',$id)->delete();

        return redirect()->route('evaluations.index',$modulo)->with('info','La pauta de evaluación se eliminó con éxito');
    }
}
