<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 pb-8">           
            Editar Criterio 
        </h1>

        <div class="card">
            <div class="card-body">
                {!! Form::model($criterio,['route' => ['criterios.update', [$modulo,$evaluation,$pregunta,$criterio]], 'method' => 'put']) !!}
    
                    <div class="form-group">
                        {!! Form::label('criterio_id', 'Seleccione el criterio') !!}
                        {!! Form::select('criterio_id', $criterios, null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('score', 'Puntaje') !!}
                        {!! Form::number('score',$criterio->questions->find($pregunta->id)->pivot->score, ['class' => 'form-control', 'min' => '0.1', 'step' => '0.1', 'placeholder' =>'Ingrese el puntaje del criterio en la pregunta']) !!}

                        @error('score')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>   
    
                    {!! Form::submit('Actualizar', ['class'=> 'btn btn-primary']) !!}
    
                {!! Form::close() !!}
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
            <script>
                //code for set option default as old criterio 
                var name = @json($criterio->name);
                console.log(name);

                $('[name=criterio_id] option').filter(function() { 
                    return ($(this).text() == name); //To select name of old criterio
                }).prop('selected', true);
            </script>

    </div>
</x-app-layout>