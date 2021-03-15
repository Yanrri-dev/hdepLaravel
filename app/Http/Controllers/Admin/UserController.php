<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{   

    public function __construct()
    {
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.create')->only('create','store');
        $this->middleware('can:admin.users.edit')->only('edit','update');
        $this->middleware('can:admin.users.destroy')->only('destroy');
    }   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'last_name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        
        $request->merge(['password' => bcrypt($request->password)]);

      
        $user = User::create($request->all());

        return redirect()->route('admin.users.edit', $user)->with('info','El usuario se agregó con éxito');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => "email|required|unique:users,email,$user->id",
            'password' => 'required|confirmed|same:password|min:6',
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        $user->update($request->all());

        return redirect()->route('admin.users.edit', $user)->with('info','El usuario se actualizó con éxito');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('info','El usuario se eliminó con éxito');
    }
}
