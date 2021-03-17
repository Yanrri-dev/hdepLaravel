<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Modulo;
use App\Models\Evaluation;

class ObtieneController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Modulo $modulo, Evaluation $evaluation, Request $request){
        
        $request->validate([
            'porcentaje' => "numeric|max:100",
            'score_max' => "numeric|max:$request->score_max"
        ]);
        
        $affected = DB::table('obtiene')
              ->where('user_id', $request->user_id )
              ->where('question_id', $request->question_id)
              ->where('criterio_id', $request->criterio_id)
              ->update([ 'score_obtenido' => $request->score_obtenido,
                         'porcentaje' => $request->porcentaje  
              ]);
        
        return redirect()->route('evaluations.show',[$modulo,$evaluation]);
    }
}
