<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\User;

class Modulo extends Model
{
    use HasFactory;
    //asignacion masiva
    protected $fillable= ['name', 'slug'];

    //slug en url en vez de id
    public function getRouteKeyName()
    {
        return "slug";
    }


    // Many to Many (modulos - users)
    public function participantes(){
        return $this->belongsToMany(User::class,'participantes','modulo_id','user_id')->withPivot('rol');
    }

    // One to many ( evaluaciones)

    public function evaluations(){
        return $this->hasMany('App\Models\Evaluation');
    }

    // One to many (criterios)

    public function criterios(){
        return $this->hasMany('App\Models\Criterio');
    }

    // polimorfic one to one
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
}
