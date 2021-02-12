<x-app-layout>

    <div class="container py-8" >
        
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            @foreach ($modulos as $modulo)
                <article class="w-full h-80 bg-cover bg-center"style="background-image: url(@if($modulo->image){{Storage::url($modulo->image->url)}}@else https://cdn.pixabay.com/photo/2016/11/22/23/09/fountain-pen-1851096_960_720.jpg @endif) ">
                    <div class="w-full h-full px-8 flex flex-col justify-center">
                        <h1 class="text-4xl text-white leading-8 font-bold">
                            <a href="{{route('evaluations.index',$modulo)}}">
                                {{$modulo->name}}
                            </a>
                        </h1>
                    </div>
                </article>
            @endforeach

        </div>

    </div>

    
</x-app-layout>