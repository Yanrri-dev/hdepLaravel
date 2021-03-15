<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 pb-8">           
            Agregar pregunta en {{$evaluation->name}}
        </h1>

        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => ['preguntas.store',$modulo,$evaluation]]) !!}
    
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de la pregunta']) !!}
    
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        {!! Form::label('number', 'Enumeración') !!}
                        {!! Form::number('number',null, ['class' => 'form-control', 'min' => '1', 'step' => '1' , 'placeholder' =>'Ingrese el número de la pegunta']) !!}
                        
                        @error('number')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('total_score', 'Puntaje') !!}
                        {!! Form::number('total_score',null, ['class' => 'form-control', 'min' => '0.1', 'step' => '0.1', 'placeholder' =>'Ingrese el puntaje total de la pregunta']) !!}

                        @error('total_score')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>   
                    
    
                    {!! Form::submit('Agregar Pregunta', ['class'=> 'btn btn-primary']) !!}
    
                {!! Form::close() !!}
            </div>
        </div>

            {{-- <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
            <script>
                //String to slug
                $(document).ready( function() {
                    $("#name").stringToSlug({
                        setEvents: 'keyup keydown blur',
                        getPut: '#slug',
                        space: '-'
                    });
                });
            </script> --}}

    </div>


</x-app-layout>