<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Criterio;
use Illuminate\Support\Str as Str;

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

            $request->validate([
                'slug' => 'required|unique:criterios',
                'score' => 'required',
            ]);
            
            $request->merge(['modulo_id' => $modulo->id]);

            $criterio = Criterio::create($request->except(['score','criterio_old']));

            $pregunta->criterios()->attach($criterio->id,['score' => $request->score]);

            return redirect()->route('criterios.index',[$modulo,$evaluation,$pregunta])->with('info','El criterio se creó y agregó a la pregunta exitosamente');

        }else{
            $request->validate([
                'criterio_old' => 'required',
                'score' => 'required',
            ]);

            $pregunta->criterios()->attach($request->criterio_old,['score' => $request->score]);
            
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
    public function edit(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Modulo $modulo, Evaluation $evaluation, Question $pregunta,Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        //
    }
}
