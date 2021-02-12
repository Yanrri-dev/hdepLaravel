<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Many to Many (users)

    public function users(){
        $this->belongsToMany('App\Models\User');
    }
}
