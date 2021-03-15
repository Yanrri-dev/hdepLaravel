<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluation;
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
        $this->authorize('participar', $modulo);

        /** @var App\Models\User $user */
        $user= auth()->user();
        $participa = $user->modulos()->where('modulo_id',$modulo->id)->first();
        $rol= $participa->pivot->rol;

        $pautas = Evaluation::has('category')->where('modulo_id','=',$modulo->id)->orderBy('id','DESC')->get();

        return view('evaluations.index', compact(['modulo','pautas','rol']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo)
    {   
        //return $c = auth()->user()->modulos()->where('modulo_id',$modulo->id)->get();
        $this->authorize('isProfessor',$modulo);

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
        $this->authorize('isProfessor',$modulo);

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
    public function show(Modulo $modulo, Evaluation $evaluation)
    {
        $this->authorize('participar', $modulo);

        $preguntas= DB::table('questions as preg')
            ->select(array('preg.name','preg.id',DB::raw('count(qc.criterio_id) as num_criterios')))
            ->join('question_criterio as qc','preg.id','=','qc.question_id')
            ->where('preg.evaluation_id',$evaluation->id)
            ->groupBy('preg.id')
            ->orderBy('preg.number')
            ->get();

        $criterios= DB::table('criterios as crit')
            ->select('crit.name as criterio_name','qc.score','preg.name as question_name','preg.id as question_id')
            ->join('question_criterio as qc','crit.id','=','qc.criterio_id')
            ->join('questions as preg','qc.question_id','=','preg.id')
            ->where('preg.evaluation_id',$evaluation->id)
            ->orderBy('preg.number','asc')
            ->orderBy('qc.score','desc')
            ->get();
        
        $participantes = DB::table('questions as preg')
            ->select('us.name','us.last_name','us.email','ob.score_obtenido','ob.porcentaje','crit.id as criterio_id','preg.id as question_id')
            ->join('question_criterio as qc','preg.id','=','qc.question_id')
            ->join('criterios as crit','qc.criterio_id','=','crit.id')
            ->join('obtiene as ob', function($join){
                $join->on('crit.id','=','ob.criterio_id');
                $join->on('qc.question_id','=','ob.question_id');
            })
            ->join('users as us','ob.user_id','=','us.id')
            ->join('participantes as p','us.id','=','p.user_id')
            ->where('p.modulo_id',$modulo->id)
            ->orderBy('us.last_name','desc')
            ->orderBy('us.name','desc')
            ->orderBy('preg.number','asc')
            ->orderBy('qc.score','desc')
            ->get();
        
        return view('evaluations.show',compact(['evaluation','preguntas','criterios','participantes']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo, Evaluation $evaluation)
    {
        $this->authorize('isProfessor',$modulo);

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
        $this->authorize('isProfessor',$modulo);

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
        $this->authorize('isProfessor',$modulo);

        $pauta = Evaluation::where('id','=',$id)->delete();

        return redirect()->route('evaluations.index',$modulo)->with('info','La pauta de evaluación se eliminó con éxito');
    }
}
