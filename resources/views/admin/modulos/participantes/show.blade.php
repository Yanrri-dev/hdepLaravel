@extends('adminlte::page')

@section('title', 'HDEP')

@section('content_header')
    <h1>Participantes de {{$modulo->name}}</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif

    <div class="card">

        <div class="card-header">
            <a class="btn btn-primary" href="{{route('admin.modulos.participantes.create', $modulo)}}"> Agregar Participante(s)</a>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Rol</th>
                        <th colspan="1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modulo->participantes as $participante)
                        <tr>
                            <td>{{$participante->name}}</td>
                            <td>{{$participante->last_name}}</td>
                            <td>{{$participante->pivot->rol}}</td>
                            <td width="10px">
                                <form action="{{route('admin.modulos.participantes.destroy', $modulo)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input name="userID" value="{{$participante->id}}" type="hidden">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop --}}