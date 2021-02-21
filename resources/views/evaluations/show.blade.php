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
                @foreach ($criterios as $c)
                    @php
                        $num_criterios++;
                    @endphp
                    <th>{{$c->criterio_name}} <br> ({{$c->score}} puntos)</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($participantes as $p)
                @if ($i % $num_criterios == 0)
                    <tr>
                    <td>{{$p->name}} {{$p->last_name}}</td>
                @endif
                    </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>




</x-app-layout>