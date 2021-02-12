@extends('adminlte::page')

@section('title', 'HDEP')

@section('content_header')
    <h1>Lista de Modulos</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href="{{route('admin.modulos.create')}}"> Agregar Modulo</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modulos as $modulo)
                        <tr>
                            <td>{{$modulo->id}}</td>
                            <td>{{$modulo->name}}</td>
                            <td width="10px">
                                <a class="btn btn-info btn-sm" href="{{route('admin.modulos.participantes.show',$modulo)}}">Participantes</a>
                            </td>
                            <td width="10px">
                                <a class="btn btn-warning btn-sm" href="{{route('admin.modulos.edit',$modulo)}}">Editar</a> 
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.modulos.destroy', $modulo)}}" method="POST">
                                    @csrf
                                    @method('delete')
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
@stop --}}

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>

    <script>
        $(document).ready( function() {
        $("#name").stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: '#slug',
            space: '-'
        });
        });
    </script>
@stop 