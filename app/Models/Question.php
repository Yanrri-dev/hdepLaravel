<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Criterio;

class Question extends Model
{
    use HasFactory;

    protected $fillable= ['name','number','total_score','evaluation_id'];


    //One to Many (reverse evaluaciones)

    public function evaluation(){
        return $this->belongsTo('App\Models\Evaluation');
    }

    //many to many (criterios)

    public function criterios(){
        return $this->belongsToMany(Criterio::class,'question_criterio','question_id','criterio_id')->withPivot('score');
    }

    // Many to Many (obtiene user)
    public function obtieneUser(){
        return $this->belongsToMany('App\Models\User');
    }
}
