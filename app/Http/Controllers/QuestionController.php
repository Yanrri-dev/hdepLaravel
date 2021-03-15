<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Modulo;
use App\Models\Evaluation;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Modulo $modulo, Evaluation $evaluation)
    {
        $this->authorize('isProfessor',$modulo);

        $preguntas = Question::where('evaluation_id','=',$evaluation->id)->get();


        return view('preguntas.index',compact(['modulo','evaluation','preguntas']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo, Evaluation $evaluation)
    {
        $this->authorize('isProfessor',$modulo);

        return view('preguntas.create',compact(['modulo','evaluation']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Modulo $modulo, Evaluation $evaluation, Request $request)
    {
        $this->authorize('isProfessor',$modulo);

        $request->merge(['evaluation_id' => $evaluation->id]);

        $request->validate([
            'name' => ['required', Rule::unique('questions')->where(function($query) use ($request){
                return $query->where('evaluation_id',$request->evaluation_id);
            })],
            'number' => ['required',Rule::unique('questions')->where(function ($query) use ($request) {
                return $query->where('evaluation_id', $request->evaluation_id);
            })],
            'total_score' => 'required',
        ]);

        $pregunta = Question::create($request->all());

        $evaluation->num_preguntas++;
        $evaluation->save();

        return redirect()->route('preguntas.index',[$modulo,$evaluation])->with('info','La pregunta se agregó exitosamente');
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
        $this->authorize('isProfessor',$modulo);

        return view('preguntas.edit',compact(['modulo','evaluation','pregunta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Modulo $modulo,Evaluation $evaluation, Question $pregunta,Request $request)
    {
        $this->authorize('isProfessor',$modulo);

        $request->merge(['evaluation_id' => $evaluation->id]);

        $request->validate([
            'name' => ['required', Rule::unique('questions')->where(function($query) use ($pregunta,$request){
                return $query->where('evaluation_id',$request->evaluation_id)->where('id','!=',$pregunta->id);
            })],
            'number' => ['required',Rule::unique('questions')->where(function ($query) use ($pregunta,$request) {
                return $query->where('evaluation_id', $request->evaluation_id)->where('id','!=',$pregunta->id);
            })],
            'total_score' => 'required',
        ]);

        $pregunta->update($request->all());

        return redirect()->route('preguntas.index',[$modulo,$evaluation])->with('info','La pregunta se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo, Evaluation $evaluation, Question $pregunta)
    {
        $this->authorize('isProfessor',$modulo);

        $res = Question::where('id','=',$pregunta->id)->delete();
        
        $evaluation->num_preguntas--;
        $evaluation->save();

        return redirect()->route('preguntas.index',[$modulo,$evaluation])->with('info','La pregunta se eliminó con éxito');
    }
}
