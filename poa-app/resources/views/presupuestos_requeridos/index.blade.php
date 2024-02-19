@extends('layouts.plantillabase')

@section('title', 'Presupuestos Requeridos')

@section('contenido')
    <div class="card p-2">
        <div class="">
            <h5>Rango de fechas:</h5>
        </div>
        <div class="">
            <form method="" class="d-flex" id="form_presupuestos">
                @csrf
                <div class="form-group mr-4">
                    <label for=""><b>fecha inicio</b><span class="text-danger"> *</span></label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                </div>
                <div class="form-group mr-4">
                    <label for=""><b>fecha fin</b><span class="text-danger"> *</span></label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Presupuestos Requeridos
            <div>
                <button type="button" id="generar_pdf" class="boton default"><i class="fas fa-file-pdf"></i> Exportar PDF</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="presupuestos" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        <td>ACCION CORTO PLAZO</td>
                        <td width="18%">PRESUPUESTO REQUERIDO</td>
                        <td>TRABAJADOR</td>
                        <td>UNIDAD</td>
                        <td>GERENCIA</td>
                        <td width="13%">FECHA REQUERIDA</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('presupuestos_requeridos.modal.modal_pdf')


@endsection

@section('js')
    <script src="{{asset('libs/js/validacionform/presupuestos_requeridos.js')}}"></script>
    <script>
        var URL = "{{ asset('libs/datatables/es-ES.json') }}";
        $('#presupuestos').DataTable({
            "language": {
                "url" : "{{ asset('libs/datatables/es-ES.json') }}"
            }
        });
    </script>
@endsection