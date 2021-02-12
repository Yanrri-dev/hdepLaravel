<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 pb-8">           
            Editar Pauta 
        </h1>

        <div class="card">
            <div class="card-body">
                {!! Form::model($evaluation,['route' => ['evaluations.update', [$modulo,$evaluation]], 'method' => 'put']) !!}
    
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de la evaluación']) !!}
    
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        {!! Form::label('slug', 'Slug') !!}
                        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => '', 'readonly']) !!}
                        
                        @error('slug')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('category_id', 'Categoría') !!}
                        {!! Form::select('category_id', $categories, null, ['class' => 'form-control','placeholder' => 'Elige una categoría']) !!}

                    </div>   
                    
    
                    {!! Form::submit('Actualizar', ['class'=> 'btn btn-primary']) !!}
    
                {!! Form::close() !!}
            </div>

            <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}"></script>
            <script>
                //String to slug
                $(document).ready( function() {
                    $("#name").stringToSlug({
                        setEvents: 'keyup keydown blur',
                        getPut: '#slug',
                        space: '-'
                    });
                });
            </script>

    </div>
</x-app-layout>