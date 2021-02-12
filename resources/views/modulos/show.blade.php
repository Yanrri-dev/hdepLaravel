<x-app-layout>
    @foreach ($modulo_user as $modulo)
        <div class="container py-8">
            <h1 class="text-4xl font-bold text-gray-500">           
                {{$modulo->name}} 
            </h1>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>N° Preguntas</th>
                    @if ($modulo->rol == "Profesor")
                        <th class="col-span-4">Soy {{$modulo->rol}}</th>
                    @else
                        <th class="col-span-1">Soy {{$modulo->rol}}</th>
                    @endif
                </tr>
            </thead>
        </table>
    @endforeach
</x-app-layout>