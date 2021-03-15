<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Modulo;

class ModuloPolicy
{
    use HandlesAuthorization;

    public function participar(User $user, Modulo $modulo){

        $c = $user->modulos()->where('modulo_id',$modulo->id)->get();
        
        if ($c->isEmpty()){
            return false;
        }else{
            return true;            
        }

    }

    public function isProfessor(User $user, Modulo $modulo){

        $c = $user->modulos()->where('modulo_id',$modulo->id)->first();
        if (empty($c)){
            return false;
        }else {
            $rol = $c->pivot->rol;
            if ($rol == 'Docente'){
                return true;
            }else{
                return false;
            }
        }
    }
}
