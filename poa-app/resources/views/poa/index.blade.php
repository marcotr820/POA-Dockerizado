@extends('layouts.plantillabase')

@section('title', 'Crear POA')

@section('contenido')
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">POA lista de Acciones Institucionales Específicas</h5>
        </div>
        <div class="card-body">
            <table id="poa" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td width="30%">ACCIÓN INSTITUCIONAL ESPECÍFICA</td>
                        <td width="15%">PONDERACION</td>
                        <td width="20%">INDICADOR DE PROCESO</td>
                        <td width="15%">GERENCIA</td>
                        <td width="20%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
      </div>

    @include('resultados.modal_resultado.resultado_form')

@endsection

@section('js') 
    <script>
        $('#poa').DataTable({    
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('poa.index') }}",
            columns: [
                // { data: 'id', name:'pei_objetivos_especificos.id'},
                { data: 'objetivo_institucional', name:'pei_objetivos_especificos.objetivo_institucional'},
                { data: 'ponderacion', name:'pei_objetivos_especificos.ponderacion',
                    render: function( data, type, row)
                    {
                        return data + ' %';
                    }
                },
                { data: 'indicador_proceso', name:'pei_objetivos_especificos.indicador_proceso',
                    render: function( data, type, row)
                    {
                        return data;
                    }
                },
                { data: 'nombre_gerencia', name:'gerencias.nombre_gerencia'},
                { data: 'uuid', name:'pei_objetivos_especificos.uuid',
                    render: function( data, type, row)
                    {
                        return '<button class="boton blue" data-accion="">Acciones Corto Plazo</button>';
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

    <script src="{{asset('libs/js/validacionform/poa_validar.js')}}"></script>
@endsection