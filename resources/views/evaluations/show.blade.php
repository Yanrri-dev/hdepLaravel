<x-app-layout>


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
                        <th>Nombre Estudiante</th>
                        @php
                            $puntaje_total = 0;
                            $num_criterios= 0;
                        @endphp
                        @foreach ($criterios as $c)
                            @php
                                $num_criterios++;
                                $puntaje_total += $c->score;
                            @endphp
                            <th>{{$c->criterio_name}} <br> ({{$c->score}} puntos)</th>
                        @endforeach
                        <th>Nota</th>
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
                            
                            <td class="p-3 px-5 text-center">{{$p->score_obtenido}}</td>
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




</x-app-layout>