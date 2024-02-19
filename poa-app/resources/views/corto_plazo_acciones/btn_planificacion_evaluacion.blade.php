<button class="btn btn-warning btn-sm" data-planificacion="">Planificacion</button>
{{-- {{  date('m', strtotime($fecha_fin)) }} --}}
@if ( date('m') >= date('m', strtotime($fecha_inicio)) && date('m') <= date('m', strtotime($fecha_fin)) && Auth::guard('usuario')->user()->trabajador->poa_evaluacion === '1' )
   <button class="btn btn-secondary btn-sm" data-evaluar="">Evaluar</button>
@endif
{{-- @if (Auth::guard('usuario')->user()->trabajador->poa_evaluacion === '1')
   <button class="btn btn-secondary btn-sm" data-evaluar="">Evaluar</button>
@endif --}}