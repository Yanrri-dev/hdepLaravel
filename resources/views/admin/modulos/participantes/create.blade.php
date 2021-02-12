@extends('adminlte::page')

@section('title', 'HDEP')

@section('content_header')
    <h1>Agregar Participantes a {{$modulo->name}}</h1>
@stop

@section('content')

   {{--  @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif --}}

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => ['admin.modulos.participantes.store',$modulo]]) !!}

                <div class="form-group">
                    {!! Form::label('users', 'Email(s) Participante(s)') !!}
                    {!! Form::textarea('users', null, ['class' => 'form-control']) !!}

                    @error('users')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {{-- <p class="font-bold">Rol</p> --}}
                    {!! Form::label('rol', 'Rol',) !!}
                    <br>
                    <label>
                        {!! Form::radio('rol', 'Estudiante', true) !!}
                        Estudiante
                    </label>

                    <label>
                        {!! Form::radio('rol', 'Docente') !!}
                        Docente
                    </label>

                    <label>
                        {!! Form::radio('rol', 'Ayudante') !!}
                        Ayudante
                    </label>
                    
                    
                    @error('rol')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                {!! Form::submit('Agregar Participante(s)', ['class'=> 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop


{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
--}}
{{-- @section('js')
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
@stop  --}}