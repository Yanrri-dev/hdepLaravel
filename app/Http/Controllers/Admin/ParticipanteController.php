<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\User;

class ParticipanteController extends Controller
{   


    public function __construct()
    {
        $this->middleware('can:admin.modulos.participantes.show')->only('show');
        $this->middleware('can:admin.modulos.participantes.create')->only('create','store');
        $this->middleware('can:admin.modulos.participantes.destroy')->only('destroy');
    }   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Modulo $modulo)
    {
        return view('admin.modulos.participantes.create', compact('modulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Modulo $modulo)
    {
        $emails =preg_split('/\r\n|\r|\n/',$request->users);
        $rol= $request->rol;

        foreach ($emails as $email){
            $user = User::where('email','=',$email)->first();
            if($user == null){
                //el usuario no existe por lo que se crea uno con datos por defecto
                
                $user = new User;
                $user->name= $email;
                $user->email= $email;
                $user->password = bcrypt($email);
                $user->save();
                
                $modulo->participantes()->attach($user->id,['rol' => $rol]);
         
            }else{
                //el usuario existe por lo que se agrega a la tabla interrelacional
                $modulo->participantes()->attach($user->id,['rol' => $rol]);
            }
        }

        return redirect()->route('admin.modulos.participantes.show',$modulo)->with('info','Se agregaron correctamente los participantes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Modulo $modulo)
    {
        return view('admin.modulos.participantes.show', compact('modulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo, Request $request)
    {
        $modulo->participantes()->detach($request->userID);

        return redirect()->route('admin.modulos.participantes.show',$modulo)->with('info','Se eliminó correctamente la/el participante');
    }
}
