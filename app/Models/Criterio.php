<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','modulo_id'];

    // One to many (modulo inverso)

     public function modulo(){
        return $this->belongsTo('App\Models\Modulo');
    }

    //many to many (questions)

    public function questions(){
        return $this->belongsToMany('App\Model\Question');
    }

    // Many to Many (obtiene user)
    public function obtieneUser(){
        return $this->belongsToMany('App\Models\User');
    }
}
