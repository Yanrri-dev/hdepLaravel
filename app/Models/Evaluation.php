<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return "slug";
    }

    protected $fillable = ['name','slug','category_id','modulo_id'];


    public $timestamps = true;

    // One to many (reverse // modulo)

    public function modulo(){
        return $this->belongsTo('App\Models\Modulo');
    }

    // One to many (reverse // criterio)

    public function criterio(){
        return $this->belongsTo('App\Models\Criterio');
    }

    //One to Many (questions)

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    // One to many (reverse // categoria)

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
