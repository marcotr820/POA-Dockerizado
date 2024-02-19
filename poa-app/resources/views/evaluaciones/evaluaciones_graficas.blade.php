@extends('layouts.plantillabase')

@section('title', 'Gráficas Evaluación')

@section('contenido')

   <div class="row" id="card-body" style="margin: auto"></div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   $.get(`${app_url}/evaluaciones_graficas/71e4e3e9-ee5f-4cfa-8dbd-d79174a8df161658265913354`, function(datos){
      datos.forEach((el, i) => {
         // console.log(el);
         const card = `<div class="col-sm-6 mb-4">
                        <div class="card">
                           <p class="m-0 p-1 border-bottom bg-light">
                              <strong>Acción Corto Plazo:</strong>
                              ${ el.accion_corto_plazo }
                           </p>
                           <div class="card-body py-2">
                              <canvas id="can${ i }" width="500" height="300"></canvas>
                           </div>
                        </div>
                     </div>`;
         $('#card-body').append(card);
         const ctx = document.getElementById(`can${ i }`);
         // console.log(ctx);
         
         const esperados = [];
         esperados.push(el.planificacion.primer_trimestre);
         esperados.push(el.planificacion.segundo_trimestre);
         esperados.push(el.planificacion.tercer_trimestre);
         esperados.push(el.planificacion.cuarto_trimestre);
         // console.log(esperados);

         const logrados = [];
         el.evaluaciones.forEach(evaluacion => {
            esperados.push(evaluacion.resultado_esperado);
            logrados.push(evaluacion.resultado_logrado)
         });
         // console.log(esperados);
         // console.log(logrados);

         const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Primer Trimestre', 'Segundo Trimestre', 'Tercer Trimestre', 'Cuarto Trimestre'],
            datasets: [
               {
                  label: 'Resultado Esperado',
                  data: esperados,
                  backgroundColor: 'rgba(54, 162, 235, 0.9)',
               },
               {
                  label: 'Resultado Logrado',
                  data: logrados,
                  backgroundColor: 'rgba(255, 99, 71, 0.9)',
               }
            ]
            },
            options: {
               scales: {
                  y: {
                     beginAtZero: true
                  }
               },
            }
         });
      });
   });
</script>
@endsection
