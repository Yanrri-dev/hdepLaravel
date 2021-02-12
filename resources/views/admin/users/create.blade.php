
@extends('adminlte::page')

@section('title', 'HDEP')

@section('content_header')
    <h1>Agregar Nuevo Usuario</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.users.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario']) !!}

                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('last_name', 'Apellidos') !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese los apellidos del usuario']) !!}
                    
                    @error('last_name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el email del usuario']) !!}
                    
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Contraseña') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese una contraseña']) !!}
                    
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirme la contraseña']) !!}
                    
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                {!! Form::submit('Crear Usuario', ['class'=> 'btn btn-primary']) !!}

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