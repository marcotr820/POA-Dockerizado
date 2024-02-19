@extends('layouts.plantillabase')

@section('title', 'Gráficas Presupuesto')

@section('contenido')

   <div class="row" id="card-body" style="margin: auto"></div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   $.get(`${app_url}/evaluaciones_presupuesto_grafica/71e4e3e9-ee5f-4cfa-8dbd-d79174a8df161658265913354`, function(datos){
      datos.forEach((el, i) => {
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

         var presupuesto_ejecutado = 0;
         el.evaluaciones.forEach(ev => {
            presupuesto_ejecutado += parseInt(ev.presupuesto_ejecutado);
         });

         const ctx = document.getElementById(`can${ i }`);
         const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
               labels: [''],
               datasets: [
                  {
                     label: 'Presupuesto Asignado',
                     data: [`${el.presupuesto_programado}`],
                     backgroundColor: 'rgba(8, 10, 149, 0.3)',
                     hoverBackgroundColor: 'rgba(8, 10, 149, 0.6)',
                     borderColor: 'rgba(8, 10, 149, 0.6)',
                  },
                  {
                     label: 'Presupuesto Ejecutado',
                     data: [`${ presupuesto_ejecutado }`],
                     backgroundColor: 'rgba(233, 4, 21, 0.3)',
                     borderColor: 'rgba(233, 4, 21, 0.7)',
                     hoverBackgroundColor: 'rgba(233, 4, 21, 0.7)',
                  }
               ]
            },
            options: {
               indexAxis: 'x',
               // Elements options apply to all of the options unless overridden in a dataset
               // In this case, we are setting the border of each horizontal bar to be 2px wide
               elements: {
                  bar: {
                  borderWidth: 2,
                  }
               },
               responsive: true,
               plugins: {
                  legend: {
                  position: 'top',
                  }
               },
            },
         });
      });
   });
</script>
@endsection
