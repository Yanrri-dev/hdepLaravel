<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Criterio;
use App\Rules\AvailableScore;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class CriterioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function index(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        $this->authorize('isProfessor',$modulo);

        return view('criterios.index',compact(['modulo','evaluation','pregunta']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        $this->authorize('isProfessor',$modulo);

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
        $this->authorize('isProfessor',$modulo);

        if($request->accion == 'nuevo'){
            //validaciones para al crear nuevo criterio
            $request->validate([
                'name' => 'required',
            ]);
            
            $slug= Str::slug($request->name);
            $request->merge(['slug' => $slug]);
            
            $request->validate([
                'slug' => 'required|unique:criterios',
                'score' =>   ['required','numeric','min:0.1',new AvailableScore($pregunta,NULL)],
            ]);

            $request->merge(['modulo_id' => $modulo->id]);

            $criterio = Criterio::create($request->except(['score','criterio_id']));

            $pregunta->criterios()->attach($criterio->id,['score' => $request->score]);

            foreach ($modulo->participantes as $participante){
                if($participante->pivot->rol == 'Estudiante'){
                    DB::table('obtiene')->insert([
                        'score_obtenido' => 0,
                        'porcentaje' => 0,
                        'user_id' => $participante->id,
                        'criterio_id' => $criterio->id,
                        'question_id' => $pregunta->id,
                        'created_at' => Carbon::now('America/Santiago')->toDateTimeString(),
                        'updated_at' => Carbon::now('America/Santiago')->toDateTimeString()
                    ]);
                }
                
            }

            return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se creó y agregó a la pregunta exitosamente');

        }else{
            //validaciones para insertar criterio existente
            $request->validate([
                'criterio_id' => ['required', Rule::unique('question_criterio')->where(function($query) use ($pregunta){
                    return $query->where('question_id',$pregunta->id);
                })],
                'score' =>   ['required','numeric','min:0.1',new AvailableScore($pregunta,NULL)],
            ]);

            $pregunta->criterios()->attach($request->criterio_id,['score' => $request->score]);

            //al asignar el criterio se debe agregar a la tabla obtiene por cada estudiante del modulo
            
            foreach ($modulo->participantes as $participante){
                if($participante->pivot->rol == 'Estudiante'){
                    DB::table('obtiene')->insert([
                        'score_obtenido' => 0,
                        'porcentaje' => 0,
                        'user_id' => $participante->id,
                        'criterio_id' => $request->criterio_id,
                        'question_id' => $pregunta->id,
                        'created_at' => Carbon::now('America/Santiago')->toDateTimeString(),
                        'updated_at' => Carbon::now('America/Santiago')->toDateTimeString()
                    ]);
                }
            }

            
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
        $this->authorize('isProfessor',$modulo);

        $criterios = Criterio::where('modulo_id',$modulo->id)->pluck('name','id');

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
        $this->authorize('isProfessor',$modulo);

        $request->validate([
            'criterio_id' => ['required', Rule::unique('question_criterio')->where(function($query) use ($pregunta,$criterio){
                return $query->where('question_id',$pregunta->id)->where('criterio_id','!=',$criterio->id);
            })],
            'score' => ['required','numeric','min:0.1',new AvailableScore($pregunta,$criterio)],
        ]);

        DB::table('question_criterio')
            ->where('question_id',$pregunta->id)
            ->where('criterio_id',$criterio->id)
            ->update([
                'score' => $request->score,
                'criterio_id' => $request->criterio_id                                            
            ]);
        //En caso de que el criterio cambie es necesario actualizar el id en la tabla obtiene
        if ($criterio->id != $request->criterio_id){
            
            foreach ($modulo->participantes as $participante){
                if ($participante->pivot->rol == 'Estudiante'){
                    DB::table('obtiene')
                        ->where('question_id',$pregunta->id)
                        ->where('user_id',$participante->id)
                        ->where('criterio_id',$criterio->id)
                        ->update([
                            'criterio_id' => $request->criterio_id
                    ]);
                }
            }
        }

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
        $this->authorize('isProfessor',$modulo);

        $pregunta->criterios()->detach($criterio->id);
        
        //al eliminar el criterio de la pregunta se debe tambien eliminar los registros de la tabla obtiene
        foreach ($modulo->participantes as $p){
            if ($p->pivot->rol == 'Estudiante'){
                $criterio->obtieneUser()->wherePivot('question_id',$pregunta->id)->detach($p->id); 
            }
        }
        
        return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se eliminó de la pregunta exitosamente');
    }
}
