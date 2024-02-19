const d = document;
d.addEventListener('click', (e)=>{
   if(e.target.matches('#generar_pdf'))
   {
      if(d.getElementById('fecha_inicio').value !== '' && d.getElementById('fecha_fin').value !== ''){
         let fecha_inicio = d.getElementById('fecha_inicio').value || null; //agregar la toma de valor por defecto si no tiene algun valor
         let fecha_fin = d.getElementById('fecha_fin').value || null;
         window.open (`${app_url}/presupuestos_pdf/${fecha_inicio}/${fecha_fin}`);
      }
      else{
         
         Swal.fire({
            title: 'Error!!',
            text: "Las fechas son requeridas",
            icon: 'error',
            confirmButtonText: 'Aceptar',
         })
      }
   }
});

var inputs_date = document.querySelectorAll('input[type="date"]');
inputs_date.forEach((el)=>{
   el.addEventListener('change', (e)=>{
      if(d.getElementById('fecha_inicio').value != '' && d.getElementById('fecha_fin').value != ''){
         const dibujar_tabla = () =>{
            $('#presupuestos').DataTable({
               "destroy": true, /*metodo para destruir la tabla que tenemos al inicio y remplazarla por una nueva con nuevos datos*/
               "processing": true,
               "serverSide": true,
               "ajax": {
                  "url": `${app_url}/presupuestos_requeridos`,
                  "type": "GET",
                  "data": {
                     "fecha_inicio": document.getElementById('fecha_inicio').value,
                     "fecha_fin": document.getElementById('fecha_fin').value,
                  }
               },
               columns: [
                  { data: 'accion_corto_plazo', name:'corto_plazo_acciones.accion_corto_plazo'},
                  { 
                     data: 'presupuesto_programado', name: 'corto_plazo_acciones.presupuesto_programado',
                     render: function(data, type) {
                     var number = $.fn.dataTable.render.number( ',', '.', 2, 'Bs ').display(data);
                           return number;
                     }
                  },
                  { data: 'nombre', name: 'trabajadores.nombre' },
                  { data: 'nombre_unidad', name: 'unidades.nombre_unidad' },
                  { data: 'nombre_gerencia', name: 'gerencias.nombre_gerencia' },
                  { data: 'fecha_inicio', name: 'corto_plazo_acciones.fecha_inicio' }
               ],
               "language": {
                  "url" : URL
               }
            });
         }

         var fecha_inicio = d.getElementById('fecha_inicio').value;
         var fecha_fin = d.getElementById('fecha_fin').value;
         if(Date.parse(fecha_fin) > Date.parse(fecha_inicio)){
            dibujar_tabla(); /*llamamos a la funcion para refrescar el datatable*/
         }
         else{
            Swal.fire({
               icon: 'error',
               text: "Rango de fechas no valido",
               width: '20%',
               height: '20%',
               confirmButtonText: 'Aceptar',
           })
            d.getElementById('fecha_inicio').value = String(fecha_fin);
            dibujar_tabla(); /*llamamos a la funcion para refrescar la datatable*/
         }
         
      }
      
   })
});