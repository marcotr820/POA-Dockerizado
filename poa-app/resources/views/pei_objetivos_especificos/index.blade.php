@extends('layouts.plantillabase')

@section('title', 'Pei Objetivo Institucional Especifico')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Pilar</td>
                    <td>
                        ( {{ $mediano_plazo_accion->resultado->meta->pilar->codigo_pilar }} ) 
                        {{$mediano_plazo_accion->resultado->meta->pilar->nombre_pilar}}
                     </td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Meta</td>
                    <td>
                        ( {{ $mediano_plazo_accion->resultado->meta->codigo_meta }} ) 
                        {{$mediano_plazo_accion->resultado->meta->nombre_meta}}
                     </td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Resultado</td>
                    <td>
                        ( {{ $mediano_plazo_accion->resultado->codigo_resultado }} ) 
                        {{$mediano_plazo_accion->resultado->nombre_resultado}}
                     </td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Mediano Plazo</td>
                    <td>
                        ( {{ $mediano_plazo_accion->codigo_mediano_plazo }} ) 
                        {{$mediano_plazo_accion->accion_mediano_plazo}}
                     </td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Acción Institucional Especificas
            <div>
                <a href="javascript:history.back()" class="boton red mr-3"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                <button type="button" id="nuevo" class="boton blue"><i class="fas fa-plus-circle"></i> Nueva Acción Gestion</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="pei_objetivos_especificos" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td width="45%">ACCIÓN INSTITUCIONAL ESPECIFICO</td> {{-- <td width="40%">OBJETIVO ESPECIFICO</td> --}}
                        <td width="10%">PONDERACION</td>
                        <td width="18%">INDICADOR DE PROCESO</td>
                        <td>GERENCIA RESPONSABLE</td>
                        <td width="10%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('pei_objetivos_especificos.modal_pei_objetivo_especifico.pei_objetivo_especifico_form')

@endsection

@section('js')
    <script>
        const mediano_plazo_accion_uuid = "{{ $mediano_plazo_accion->uuid }}";
        $('#pei_objetivos_especificos').DataTable({
            "order": [[ 0, "desc" ]],
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/mediano_plazo_acciones/${mediano_plazo_accion_uuid}/pei_objetivos_especificos/`,
            columns: [
                // { data: 'id', name:'pei_objetivos_especificos.id'},
                { data: 'objetivo_institucional', name:'pei_objetivos_especificos.objetivo_institucional'},
                { 
                    data: 'ponderacion', name:'pei_objetivos_especificos.ponderacion',
                    render: function( data, type, row)
                    {
                        return data + ' %';
                    }
                },
                { 
                    data: 'indicador_proceso', name:'pei_objetivos_especificos.indicador_proceso',
                    render: function( data, type, row)
                    {
                        return data;
                    }
                },
                { data: 'nombre_gerencia', name:'gerencias.nombre_gerencia'},
                { 
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                        </div>
                        `;
                    }
                },
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

    <script src="{{asset('libs/js/validacionform/pei_objetivo_especifico_validar.js')}}"></script>

@endsection