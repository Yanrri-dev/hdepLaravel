<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Criterio;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CriterioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        return view('criterios.index',compact(['modulo','evaluation','pregunta']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {

        $criterios = Criterio::where('modulo_id',$modulo->id)->pluck('name','id');

        return view('criterios.create',compact(['modulo','evaluation','pregunta','criterios']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Modulo $modulo, Evaluation $evaluation, Question $pregunta,Request $request)
    {
        if($request->accion == 'nuevo'){

            $request->validate([
                'name' => 'required',
            ]);
            
            $slug= Str::slug($request->name);
            $request->merge(['slug' => $slug]);
            
            //-- validation for max score available to new criterio --//
            $suma = 0;
            foreach ($pregunta->criterios as $c){
                $suma = $suma + $c->pivot->score;
            }
            $scoreAvailable = $pregunta->total_score - $suma;

            $request->validate([
                'slug' => 'required|unique:criterios',
                'score' =>  "required|numeric|min:0.1|max:$scoreAvailable"
            ]);
             //--//
            $request->merge(['modulo_id' => $modulo->id]);

            $criterio = Criterio::create($request->except(['score','criterio_id']));

            $pregunta->criterios()->attach($criterio->id,['score' => $request->score]);

            return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se creó y agregó a la pregunta exitosamente');

        }else{

             //-- validation for max score available to new criterio --//
            $suma = 0;
            foreach ($pregunta->criterios as $c){
                $suma = $suma + $c->pivot->score;
            }
            $scoreAvailable = $pregunta->total_score - $suma;

            $request->validate([
                'criterio_id' => ['required', Rule::unique('question_criterio')->where(function($query) use ($pregunta){
                    return $query->where('question_id',$pregunta->id);
                })],
                'score' =>  "required|numeric|min:0.1|max:$scoreAvailable",
            ]);

            $pregunta->criterios()->attach($request->criterio_id,['score' => $request->score]);
            
            return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se agregó a la pregunta exitosamente');
        }
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
    public function edit(Modulo $modulo, Evaluation $evaluation, Question $pregunta, Criterio $criterio)
    {
        $criterios = Criterio::where('modulo_id',$modulo->id)->pluck('name','id');

        //return $criterio->questions->find($pregunta->id)->pivot->score;

        return view('criterios.edit',compact(['modulo','evaluation','pregunta','criterio','criterios']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Modulo $modulo, Evaluation $evaluation, Question $pregunta,Criterio $criterio, Request $request)
    {
        $suma = 0;
        foreach ($pregunta->criterios as $c){
            $suma = $suma + $c->pivot->score;
        }
        $score_old = $criterio->questions->find($pregunta->id)->pivot->score;
        $scoreAvailable = $pregunta->total_score - $suma + $score_old; 


        $request->validate([
            'criterio_id' => ['required', Rule::unique('question_criterio')->where(function($query) use ($pregunta,$criterio){
                return $query->where('question_id',$pregunta->id)->where('criterio_id','!=',$criterio->id);
            })],
            'score' => "required|numeric|min:0.1|max:$scoreAvailable",
        ]);

        DB::table('question_criterio')
                                    ->where('question_id',$pregunta->id)
                                    ->where('criterio_id',$criterio->id)
                                    ->update([
                                        'score' => $request->score,
                                        'criterio_id' => $request->criterio_id                                            
                                    ]);

        //$pregunta->criterios()->updateExistingPivot($criterio->id,array('score' => $request->score, 'criterio_id' => $request->criterio_id));

        return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se actualizó exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo, Evaluation $evaluation, Question $pregunta, Criterio $criterio)
    {
        $pregunta->criterios()->detach($criterio->id);

        return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se eliminó de la pregunta exitosamente');
    }
}
