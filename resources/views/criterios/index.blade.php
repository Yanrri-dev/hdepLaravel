<x-app-layout>
   
    <style>
		
		/*Overrides for Tailwind CSS */
		
		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #4a5568; 			/*text-gray-700*/
			padding-left: 1rem; 		/*pl-4*/
			padding-right: 1rem; 		/*pl-4*/
			padding-top: .5rem; 		/*pl-2*/
			padding-bottom: .5rem; 		/*pl-2*/
			line-height: 1.25; 			/*leading-tight*/
			border-width: 2px; 			/*border-2*/
			border-radius: .25rem; 		
			border-color: #edf2f7; 		/*border-gray-200*/
			background-color: #edf2f7; 	/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;	/*bg-indigo-100*/
		}
		
		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button		{
			font-weight: 700;				/*font-bold*/
			border-radius: .25rem;			/*rounded*/
			border: 1px solid transparent;	/*border border-transparent*/
		}
		
		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current	{
			color: #fff !important;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			background: #667eea !important;		/*bg-indigo-500*/
			border: 1px solid transparent;		/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
			color: #fff !important;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			background: #667eea !important;		/*bg-indigo-500*/
			border: 1px solid transparent;		/*border border-transparent*/
		}
		
		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}
		
		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important; /*bg-indigo-500*/
		}	
    </style>
    <style>
        .tooltip {
            position: relative;
            display: inline-block;
            
        }

        /* Tooltip text */
        .tooltip .tooltiptext {
        visibility: hidden;
        width: 80px;
        background-color: gray;
        color: #fff;
        text-align: center;
        padding: 3px 0;
        border-radius: 4px;
        font-family: sans-serif;
        font-size: 12px;
        font-weight: normal;
        
        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip:hover .tooltiptext {
        visibility: visible;
        }
    </style>
    
    <div class="container w-full md:w-4/5  mx-auto px-2 py-4">
        <h1 class="text-4xl font-bold text-gray-500 py-5 mb-4">           
            Criterios de <a href="{{route('preguntas.index',[$modulo,$evaluation])}}">{{$pregunta->name}}</a>
        </h1>
        
        @if (session('info'))
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>{{session('info')}}</p>
            </div>
        @endif
        {{-- <div class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg"> --}}
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
            
            <div id='recipients' class="p-2 mt-6 mb-6 lg:mt-0 rounded bg-white">
                <a class="p-2 my-2 bg-blue-500 text-white rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2" href="{{route('criterios.create',[$modulo,$evaluation,$pregunta])}}">Agregar Criterio</a>
            </div>
           
            <table class="stripe hover" id="example" style="width:100%; padding-top: 1em;  padding-bottom: 1em; text-align: center;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Puntaje</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pregunta->criterios as $criterio)
                        <tr>
                            <td>{{$criterio->name}}</td>
                            <td>{{$criterio->pivot->score}}</td>
                        
                            <td width="10px">
                                <a class="tooltip p-2 my-2 bg-yellow-300 text-yellow-800 rounded-md focus:outline-none focus:ring-2 ring-yellow-300 ring-offset-2 fas fa-pen" href="{{route('criterios.edit',[$modulo,$evaluation,$pregunta,$criterio])}}"><span class="tooltiptext">Editar Pregunta</span></a>
                            </td>

                            <td width="10px">
                                <form action="{{route('preguntas.destroy', [$modulo,$evaluation,$pregunta])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="tooltip p-2 my-2 bg-red-400 text-red-900 rounded-md focus:outline-none focus:ring-2 ring-red-300 ring-offset-2  fas fa-trash"><span class="tooltiptext">Eliminar Pregunta</span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   

    
    <script>
		$(document).ready(function() {
			
			var table = $('#example').DataTable( {
					responsive: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    "columnDefs": [ {
                        "targets": '_all',
                        "orderable": false,
                    }]
				} ).columns.adjust().responsive.recalc();
		});

	
	</script>
    
</x-app-layout>