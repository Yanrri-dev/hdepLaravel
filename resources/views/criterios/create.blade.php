<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 pb-8">           
            Agregar criterio en {{$pregunta->name}}
        </h1>

        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => ['criterios.store',$modulo,$evaluation,$pregunta]]) !!}


                    <div class="form-group">
                        {!! Form::label('accion', 'Elija el tipo de criterio') !!}

                        <br>
                        <label>
                            {!! Form::radio('accion', 'viejo', true, ['id' => 'old']) !!}
                            Existente
                        </label>

                        <label>
                            {!! Form::radio('accion', 'nuevo', false, ['id' => 'new']) !!}
                            Nuevo
                        </label>
                    </div>

                    <div class="form-group">
                        {!! Form::label('criterio_id', 'Seleccione el criterio') !!}
                        {!! Form::select('criterio_id', $criterios, null, ['class' => 'form-control']) !!}
                    </div>

                    @error('criterio_id')
                            <span class="text-danger">{{$message}}</span>
                    @enderror

                    <div class="form-group">
                        {!! Form::label('name', 'Nombre',['style' => 'display:none;']) !!}
                        {!! Form::hidden('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del nuevo criterio']) !!}
    
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        @error('slug')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('score', 'Puntaje') !!}
                        {!! Form::number('score',null, ['class' => 'form-control', 'min' => '0.1', 'step' => '0.1', 'placeholder' =>'Ingrese el puntaje del criterio en la pregunta']) !!}

                        @error('score')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>   
                    
    
                    {!! Form::submit('Agregar Criterio', ['class'=> 'btn btn-primary']) !!}
    
                {!! Form::close() !!}
            </div>
        </div>
        
        <script>
            $('input[type=radio][name=accion]').change(function() {
                
                
                if (this.value == 'nuevo') {
                    //alert("Nuevo criterio");
                    $('#name').get(0).type = 'text';
                    $('label[for=name]').show();

                    $('label[for=criterio_id]').hide();
                    $('#criterio_id').hide();
                }
                else if (this.value == 'viejo') {
                    //alert("viejo criterio");
                    $('#name').get(0).type = 'hidden';
                    $('label[for=name]').hide();

                    $('label[for=criterio_id]').show();
                    $('#criterio_id').show();
                }
                
                /* 
                var ele = document.getElementsByName('accion');

                for(i = 0; i < ele.length; i++) { 
                    if(ele[i].checked){
                        if(ele[i].value =='nuevo'){
                            console.log(ele[i].value);
                        }
                    }
                } */
            });

        </script>
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