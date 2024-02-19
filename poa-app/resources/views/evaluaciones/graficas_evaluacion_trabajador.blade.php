@extends('layouts.plantillabase')

@section('title', 'Gráficas')

@section('contenido')
   <div class="card">
      <div class="card-header">
         <table class="table table-bordered table-sm m-0">
            <tr>
               <td width="15%" class="font-weight-bold">Trabajador</td>
               <td>{{ $corto_plazo_accion->trabajador->nombre }}</td>
            </tr>
            <tr>
               <td width="15%" class="font-weight-bold">Unidad</td>
               <td>{{ $corto_plazo_accion->trabajador->unidad->nombre_unidad }}</td>
            </tr>
            <tr>
                <td width="15%" class="font-weight-bold">Acción Corto Plazo</td>
                <td>{{ $corto_plazo_accion->accion_corto_plazo }} </td>
            </tr>
         </table>
         <a href="javascript:history.back()" class="boton red mt-2"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  {{-- <h5 class="card-title">Special title treatment</h5> --}}
                  <canvas id="evaluaciones" width="500" height="300"></canvas>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <canvas id="presupuesto" width="500" height="300"></canvas>
                </div>
              </div>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('js')
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script>
      const cpa_uuid = '{{ $corto_plazo_accion->uuid }}';
      $.get(`${app_url}/evaluacion_graficas/${ cpa_uuid }`, function(data){
         console.log(data);
         const esperados = [];
         esperados.push(data.planificacion.primer_trimestre);
         esperados.push(data.planificacion.segundo_trimestre);
         esperados.push(data.planificacion.tercer_trimestre);
         esperados.push(data.planificacion.cuarto_trimestre);
         
         const logrados = [];
         var presupuesto_ejecutado = 0;
         data.evaluaciones.forEach(el => {
            logrados.push(el.resultado_logrado);
            presupuesto_ejecutado += el.presupuesto_ejecutado;
         });

         const ctx = document.getElementById('evaluaciones');
         const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Primer Trimestre', 'Segundo Trimestre', 'Tercer Trimestre', 'Cuarto Trimestre'],
            datasets: [
               {
                  label: 'Resultado Esperado',
                  data: esperados,
                  backgroundColor: 'rgba(20, 36, 222, 0.4)',
                  hoverBackgroundColor: 'rgba(20, 36, 222, 0.7)',
                  borderColor: 'rgba(20, 36, 222, 0.6)',
                  // barPercentage: 0.5,
                  borderWidth: 2
               },
               {
                  label: 'Resultado Logrado',
                  data: logrados,
                  backgroundColor: 'rgba(255, 0, 0, 0.4)',
                  hoverBackgroundColor: 'rgba(255, 0, 0, 0.7)',
                  borderColor: 'rgba(255, 0, 0, 0.6)',
                  // barPercentage: 0.5,
                  borderWidth: 2
               }
            ]
            },
            options: {
               scales: {
                  y: {
                     beginAtZero: true
                  }
               },
               responsive: true,
               plugins: {
                  legend: {
                  position: 'top',
                  },
                  title: {
                  display: true,
                  text: 'Gráfica Evaluación Trimestre Expresado En Porcentaje (%)'
                  }
               }
            }
         });

         const ctx2 = document.getElementById('presupuesto');
         const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
            labels: ['Presupuesto'],
            datasets: [
               {
                  label: 'Presupuesto Programado',
                  data: [`${ data.presupuesto_programado }`],
                  backgroundColor: 'rgba(20, 36, 222, 0.4)',
                  hoverBackgroundColor: 'rgba(20, 36, 222, 0.7)',
                  borderColor: 'rgba(20, 36, 222, 0.6)',
                  // barPercentage: 0.5,
                  borderWidth: 2
               },
               {
                  label: 'Presupuesto Ejecutado',
                  data: [`${ presupuesto_ejecutado }`],
                  backgroundColor: 'rgba(255, 0, 0, 0.4)',
                  hoverBackgroundColor: 'rgba(255, 0, 0, 0.7)',
                  borderColor: 'rgba(255, 0, 0, 0.6)',
                  // barPercentage: 0.5,
                  borderWidth: 2
                  
               }
            ]
            },
            options: {
               categoryPercentage: 0.4,   //width de columnas
               barPercentage: 0.85,  //espacio entre columnas
               scales: {
                  y: {
                     beginAtZero: true
                  }
               },
               responsive: true,
               plugins: {
                  legend: {
                  position: 'top',
                  },
                  title: {
                  display: true,
                  text: 'Gráfica Presupuesto Expresado en (Bs.)'
                  }
               }
            }
         });
      });
   </script>
@endsection
