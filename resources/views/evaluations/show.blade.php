<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <div class="container w-full md:w-4/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 py-5 mb-4">           
            Pauta de {{$evaluation->name}}
        </h1>

        <div class="px-3 py-4 flex justify-center">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($preguntas as $p)
                            <th class="p-3 px-5 text-white bg-gray-800 border text-center border-gray-200" colspan="{{$p->num_criterios}}">{{$p->name}}</th>
                        @endforeach
                    </tr>
                    <tr class="border-b">
                        <th class="text-center">Nombre Estudiante</th>
                        @php
                            $puntaje_total = 0;
                            $num_criterios= 0;
                        @endphp
                        @foreach ($criterios as $c)
                            @php
                                $num_criterios++;
                                $puntaje_total += $c->score;
                            @endphp
                            <th class="text-center">{{$c->criterio_name}} <br> ({{$c->score}} puntos)</th>
                        @endforeach
                        <th class="text-center">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                        $j=0;
                    @endphp
                    @foreach ($participantes as $p)
                        @if ($i % $num_criterios == 0)
                            @if ($j % 2 == 0)
                                <tr class="border-b hover:bg-orange-100 bg-gray-100">
                            @else
                                <tr class="border-b hover:bg-orange-100">
                            @endif
                            <td class="p-3 px-5">{{$p->name}} {{$p->last_name}}</td>
                            @php
                                $suma=0;
                                $j++;
                            @endphp

                        @endif
                            @if ($rol != "Estudiante")
                                <td class="p-3 px-5 text-center">
                                    @foreach ($criterios as $c)
                                        @if ($c->criterio_id == $p->criterio_id)
                                            @php
                                                $score_criterio = $c->score;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <button class="btn btn-link" data-toggle="modal" data-target="#edit_porcentaje" onclick=update_data_modal({{json_encode($p)}},{{$score_criterio}})>{{$p->score_obtenido}}</button>
                                </td>
                            @else
                            <td class="p-3 px-5 text-center">{{$p->score_obtenido}}</td>
                            @endif

                            @php
                                $suma = $suma + $p->score_obtenido;
                            @endphp
                            @if (($i+1) % $num_criterios == 0)
                                @php
                                    $puntaje_corte = $puntaje_total * 0.6;
                                    $diferencia = $puntaje_total - $puntaje_corte; 
                                @endphp
                                @if ($suma < $puntaje_corte)
                                    @php
                                        $nota = ((3* $suma)/$puntaje_corte) +1;
                                    @endphp
                                @else
                                    @php
                                        $nota = ((3*($suma - $puntaje_corte))/$diferencia) + 4 ;
                                    @endphp                                
                                @endif
                            
                                <td class="p-3 px-5 text-center">{{round($nota,2)}}</td>
                                </tr>
                            @endif
                            @php
                                $i++;
                            @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

   {{--  Modal --}}
    @if ($rol != "Estudiante")
        
   
        <div id="edit_porcentaje" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                            <form id="edit_form" action={{route("evaluation.obtiene",[$modulo,$evaluation])}} method="post">                              
                               @method('PUT')
                               @csrf
                                    <div class="modal-header">
                                            <h4 class="modal-title">Editar Porcentaje</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control" name="name" id="name" required readonly="readonly">
                                            </div>
                                            <div class="form-group">
                                                    <input type="hidden" class="form-control" name="user_id" id="user_id">
                                            </div>
                                            <div class="form-group">
                                                    <label>Porcentaje</label>
                                                    <input type="number" step="0.01" min="0" max="100" class="form-control" name="porcentaje" id="porcentaje" required>
                                                    <input type="hidden" name="criterio_id" id="criterio_id">
                                                    <input type="hidden" name="question_id" id="question_id">
                                                    <input type="hidden" name="score_max" id="score_max">
                                            </div>
                                            <div class="from-group">
                                                <label>Puntaje</label>
                                                <input type="number" step="0.1" min="0" class="form-control" name="score_obtenido" id="score_obtenido" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                            <input type="submit" class="btn btn-info" value="Actualizar" id="boton_pts">
                                    </div>
                            </form>
                    </div>
            </div>
        </div>

    @endif

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript">

        //script para enviar los datos al modal update
        function update_data_modal(data,score_criterio){

            console.log(data);
            //console.log(score_criterio)
            $('#name').val(data.name);
            $('#user_id').val(data.user_id);
            $('#criterio_id').val(data.criterio_id);
            $('#question_id').val(data.question_id);
            $('#porcentaje').val(data.porcentaje);
            $('#score_obtenido').val(data.score_obtenido);
            $('#score_max').val(score_criterio);


            $("#porcentaje" ).change(function() {
                var porcentaje = $("#porcentaje").val();
                score_obtenido = porcentaje * score_criterio / 100; 
                $("#score_obtenido").val(score_obtenido);
            });

            $("#score_obtenido" ).change(function() {
                var score_obtenido = $("#score_obtenido").val();
                porcentaje = score_obtenido/score_criterio * 100; 
                $("#porcentaje").val(porcentaje);
            });
        }

    </script>



</x-app-layout>