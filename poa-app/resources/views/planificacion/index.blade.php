@extends('layouts.plantillabase')

@section('title', 'Planificación')

@section('contenido')
    <div class="card">
        <div class="card-header py-1">
            {{-- {{ $url_anterior }} --}}
            <p class="m-0 mb-1"><b>Accion Corto Plazo:</b> {{$corto_plazo_accion->accion_corto_plazo}}</p>
            <p class="m-0 mb-1"><b>Fecha Inicio:</b> {{$corto_plazo_accion->fecha_inicio}}</p>
            <p class="m-0 mb-1"><b>Fecha Fin:</b> {{$corto_plazo_accion->fecha_fin}}</p>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center py-2">
            Lista Planificacion
            <div>
                {{-- <a href="{{  route('corto_plazo_acciones', $corto_plazo_accion->pei_objetivo_especifico->uuid) }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a> --}}
                <a href="{{ $url_anterior }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver atras</a>
                @if (! $corto_plazo_accion->planificacion()->exists())
                    <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Crear Planificacion</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table id="planificacion" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        <td width="22%">1er Trimestre</td>
                        <td width="22%">2do Trimestre</td>
                        <td width="22%">3er Trimestre</td>
                        <td width="22%">4to Trimestre</td>
                        <td width="12%"></td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('planificacion.modal_planificacion.planificacion_form')

@endsection

@section('js')
    
    <script src="{{asset('libs/js/validacionform/planificacion_validar.js')}}"></script>
    <script>
        var corto_plazo_uuid = "{{ $corto_plazo_accion->uuid }}";
        $('#planificacion').DataTable({
            "searching": false,
            "bPaginate": false, 
            "serverSide": true,
            "processing": true,
            "order": [[ 0, "desc" ]],
            "ajax": `${app_url}/planificacion/`+ corto_plazo_uuid,
            columns: [
                { 
                    data: 'primer_trimestre', name: 'planificaciones.primer_trimestre',
                    render: function( data, type, row)
                    {
                        if(data == 0){
                            return '<span class="text-muted">No evalúa</span>'
                        }else{
                            return data + ' %';
                        }
                    }
                },
                { 
                    data: 'segundo_trimestre', name: 'planificaciones.segundo_trimestre',
                    render: function( data, type, row)
                    {
                        if(data == 0){
                            return '<span class="text-muted">No evalúa</span>'
                        }else{
                            return data + ' %';
                        }
                    }
                },
                { 
                    data: 'tercer_trimestre', name: 'planificaciones.tercer_trimestre',
                    render: function( data, type, row)
                    {
                        if(data == 0){
                            return '<span class="text-muted">No evalúa</span>'
                        }else{
                            return data + ' %';
                        }
                    }
                },
                { 
                    data: 'cuarto_trimestre', name: 'planificaciones.cuarto_trimestre',
                    render: function( data, type, row)
                    {
                        if(data == 0){
                            return '<span class="text-muted">No evalúa</span>'
                        }else{
                            return data + ' %';
                        }
                    }
                },
                {
                    data: 'uuid',
                    render: function( data, type, row){
                        var fecha_inicio = Date.parse(row.fecha_inicio);
                        var fecha_actual = Date.now();
                        if(fecha_actual < fecha_inicio){
                            //si la fecha actual es mayor a la inicial ya no se mostrara el boton de eliminar planificacion
                            return `
                                <div class="btn-group">
                                    <button class="boton red" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                                </div>
                            `;
                        }else{
                            return '';
                        }
                        
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
@endsection