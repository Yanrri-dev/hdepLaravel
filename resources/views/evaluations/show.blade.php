<x-app-layout>

    <table>
        <thead>
            <tr>
                <th></th>
                @foreach ($preguntas as $p)
                    <th colspan="{{$p->num_criterios}}">{{$p->name}}</th>
                @endforeach
            </tr>
            <tr>
                <th>Nombre Estudiante</th>
                @php
                    $puntaje_total = 0;
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
            @foreach ($participantes as $p)
                @if ($i % $num_criterios == 0)
                    <tr>
                        <td>{{$p->name}} {{$p->last_name}}</td>
                @endif
                        <td>{{$p->score_obtenido}}</td>
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
                        
                            <td>{{round($nota,2)}}</td>
                            </tr>
                        @endif
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>




</x-app-layout>