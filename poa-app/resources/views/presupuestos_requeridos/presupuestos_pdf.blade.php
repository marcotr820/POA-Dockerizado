<style>
   table{
      border-collapse: collapse;
      font-size: 7px;
    }
    th, td{
      border:.5px solid #000;
    } 
</style>
<table width="100%" style="padding: 5px;">
   <thead>
      <tr style="background-color: #ddd;">
         <th><strong>ACCION CORTO PLAZO</strong></th>
         <th><strong>PRESUPUESTO REQUERIDO</strong></th>
         <th><strong>TRABAJADOR</strong></th>
         <th><strong>UNIDAD</strong></th>
         <th><strong>GERENCIA</strong></th>
         <th><strong>FECHA REQUERIDA</strong></th>
      </tr>
   </thead>
   <tbody>
      @forelse ($datos as $corto_plazo_accion)
      <tr>
         <td>{{$corto_plazo_accion->accion_corto_plazo}}</td>
         <td>{{number_format($corto_plazo_accion->presupuesto_programado, 2, ".", ",")}} Bs.</td>
         <td>{{ $corto_plazo_accion->trabajador->nombre }}</td>
         <td>{{ $corto_plazo_accion->trabajador->unidad->nombre_unidad }}</td>
         <td>{{ $corto_plazo_accion->trabajador->unidad->gerencia->nombre_gerencia }}</td>
         <td>{{$corto_plazo_accion->fecha_inicio}}</td>
      </tr>
      @empty
      <tr>
         <td colspan="6">No se encontraron registros.</td>
      </tr>
      @endforelse
   </tbody>
</table>