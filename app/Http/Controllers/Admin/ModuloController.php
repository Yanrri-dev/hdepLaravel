<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ModuloController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.modulos.index')->only('index');
        $this->middleware('can:admin.modulos.create')->only('create','store');
        $this->middleware('can:admin.modulos.edit')->only('edit','update');
        $this->middleware('can:admin.modulos.destroy')->only('destroy');
    }    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulos = Modulo::all();

        return view('admin.modulos.index',compact('modulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modulos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:modulos'
        ]);
        
        $modulo = Modulo::create($request->all());

        if ($request->file('file')) {

            $url = Storage::put('modulos', $request->file('file'));

            $modulo->image()->create([
                'url' => $url
            ]);
        }

        

        return redirect()->route('admin.modulos.edit', $modulo)->with('info','El módulo se agregó con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Modulo $modulo)
    {
    //return $modulo->participantes;

       return view('admin.modulos.show', compact('modulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modulo $modulo)
    {
        return view('admin.modulos.edit', compact('modulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:modulos,slug,$modulo->id"
        ]);

        $modulo->update($request->all());

        return redirect()->route('admin.modulos.edit', $modulo)->with('info','El módulo se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulo $modulo)
    {
        $modulo->delete();

        return redirect()->route('admin.modulos.index')->with('info','El módulo se eliminó con éxito');
    }

}
