@extends('layouts.plantillabase')

@section('title', 'Administrar Estados POA')

@section('css')
<style>
   table{
       font-size: 12px !important;
   }
</style>
@endsection

@section('contenido')
    <div class="cabecera_pagina">
        <h5>Administrar Estados POA</h5>
    </div>

    <div class="form-group mb-3">
        <label class="font-weight-bold">Seleccione Acción Institucional Especifica:</label>
        <select id="select2" class="select2" style="width: 100%, display:flex;">
            {{-- <option value=""> -- Seleccione Objetivo Institucional Especifico -- </option>
            @foreach ($objetivos_especificos as $obj)
                <option data-ej="{{$obj->id}}" value="{{$obj->uuid}}" data-gerencia="{{$obj->gerencia->nombre_gerencia}}">{{$obj->gerencia->nombre_gerencia}} >> {{$obj->objetivo_institucional}}</option>
            @endforeach --}}
        </select>
    </div>

    <div class="card">
        <div class="card-header p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="22%" class="font-weight-bold">ACCIÓN INSTITUCIONAL ESPECÍFICA</td>
                    <td><span class="objetivo_especifico"></span></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">GERENCIA</td>
                    <td><span class="gerencia"></span></td>
                </tr>
            </table>
        </div>
        <div class="card-body p-2">
        <table class="table table-striped table-sm table-bordered" id="table" width="100%">
            <thead style="background-color: skyblue">
                <tr>
                    <th width="55%">ACCION CORTO PLAZO</th>
                    <th width="20%">PRESUPUESTO REQUERIDO</th>
                    <th width="15%">STATUS</th>
                    <th width="10%">ACCIONES</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>

    @include('admin_poa.modal_admin_poa.admin_poa_form')

@endsection

@section('js')
    <script>
        function style_css(obj){
            if (!obj.id) {
                return obj.text;
            }
            if (obj.corto_plazo_acciones_presentado == 0) {
                return obj.gerencia + " >> " + obj.text;
            }
            var badge = $("<span>", {
                class: "badge badge-danger badge-pill",
                text: obj.corto_plazo_acciones_presentado
            });
            var span = $("<span>", {
                text: " - " + obj.gerencia + " >> " + obj.text
            });
            span.prepend(badge);
            return span;
        }

        $('.select2').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: -1,
            placeholder: '__Seleccione__',
            ajax: {
                url: "{{route('get_objetivos_ajax')}}",
                type: "get",
                dataType: 'json',
                delay: 200,
                processResults: function(data){
                    var results = [];
                    $.each(data, function(index, item){
                        results.push({
                            id: item.id,
                            uuid: item.uuid,
                            status: item.status,
                            gerencia: item.gerencia.nombre_gerencia,
                            corto_plazo_acciones_presentado: item.corto_plazo_acciones_presentado,
                            text: item.objetivo_institucional
                        })
                    });
                    return { results };
                }
                
            },
            templateResult: function(obj) {
                return style_css(obj);
            }
        });


        $('#table').DataTable({
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
    <script src="{{asset('libs/js/admin_poa.js')}}"></script>

@endsection