@extends('layouts.plantillabase')

@section('title', 'Estados Trabajadores')

@section('contenido')
    <div class="card">
        <div class="d-flex justify-content-between bg-light p-2">
            <div class="d-flex align-items-center">
                <h5 class="m-0">Estados Trabajadores</h5>
            </div>
            <div class="x-dropdown">
                <span><strong>Creación POA</strong></span>
                <button class="x-dropdown-button boton blue">Ver mas</button>
                <ul class="x-dropdown-menu menu-right">
                    <li>
                        <a data-habilitar="creacion">habilitar todos</a>
                    </li>
                    <li>
                        <a data-deshabilitar="creacion">deshabilitar todos</a>
                    </li>
                </ul>
            </div>
            <div class="x-dropdown">
                <span><strong>Evaluación POA</strong></span>
                <button class="x-dropdown-button boton blue">Ver mas</button>
                <ul class="x-dropdown-menu menu-right">
                    <li>
                        <a data-habilitar="evaluacion">habilitar todos</a>
                    </li>
                    <li>
                        <a data-deshabilitar="evaluacion">deshabilitar todos</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <table id="estados_trabajadores" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        <td width='20%'>TRABAJADOR</td>
                        <td width='20%'>UNIDAD</td>
                        <td width='15%'>GERENCIA</td>
                        <td width='15%'>CREAR POA</td>
                        <td width='15%'>EVALUAR POA</td>
                        <td width='15%'>EVALUACIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('js')
    
    <script type="text/javascript">
        $('#estados_trabajadores').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('estados_trabajadores.index') }}",
            columns: [
                { data: 'nombre', name:'trabajadores.nombre'},
                { data: 'nombre_unidad', name:'unidades.nombre_unidad'},
                { data: 'nombre_gerencia', name:'gerencias.nombre_gerencia'},
                { 
                    data: 'poa_status', name:'trabajadores.poa_status',
                    render: function( data, type, row)
                    {
                        if(data === '0') 
                        {
                            return ` <div class="custom-control custom-switch"> 
                                <input type="checkbox" name="poa_status" data-crear="" class="custom-control-input _switch" id="${row["id"]}"> 
                                <label class="custom-control-label" for="${row["id"]}"> 
                                    <span class="badge badge-danger p-1">deshabilitado</span> 
                                </label> 
                                </div> `;
                        }
                        else
                        {
                            return ` <div class="custom-control custom-switch"> 
                                <input type="checkbox" name="poa_status" data-crear="" class="custom-control-input" id="${row["id"]}" checked> 
                                <label class="custom-control-label" for="${row["id"]}"> 
                                    <span class="badge badge-success p-1">Activo</span> 
                                </label> 
                                    </div> `;
                        }
                    }
                },
                { 
                    data: 'poa_evaluacion', name:'trabajadores.poa_evaluacion',
                    render: function( data, type, row){
                        if(data === '0')
                        {
                            return ` <div class="custom-control custom-switch"> 
                                <input type="checkbox" name="poa_evaluacion" data-evaluar="" class="custom-control-input" id="${row["id"]}evaluacion"> 
                                <label class="custom-control-label" for="${row["id"]}evaluacion"> 
                                    <span class="badge badge-danger p-1">deshabilitado</span> 
                                </label> 
                                </div> `;
                        }
                        else
                        {
                            return ` <div class="custom-control custom-switch"> 
                                <input type="checkbox" name="poa_evaluacion" data-evaluar="" class="custom-control-input" id="${row["id"]}evaluacion" checked> 
                                <label class="custom-control-label" for="${row["id"]}evaluacion"> 
                                    <span class="badge badge-success p-1">Activo</span> 
                                </label> 
                                </div> `;
                        }
                    }
                },
                {
                    data: 'uuid', name: 'trabajadores.uuid',
                    render: function(data, type, row){
                        return `<a href="${app_url}/ver_evaluaciones/${data}" class="boton default">Ver Evaluación</a>`;
                    }
                }
            ],
            "columnDefs": [
                {
                    "targets": -1, // your case last column
                    "className": "text-center",
                    // "width": "4%"
                }
            ],
            "language": {
                "url" : "{{ asset('libs/datatables/es-ES.json') }}"
            }
        });

    </script>

    <script src="{{asset('libs/js/estado_trabajadores.js')}}"></script>

@endsection