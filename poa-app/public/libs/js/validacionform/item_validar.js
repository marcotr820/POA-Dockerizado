const d = document;
const Toast = Swal.mixin({
   toast: true,
   position: 'top-right',
   iconColor: 'white',
   customClass: {
      popup: 'colored-toast'
   },
   showConfirmButton: false,
   timer: 1500,
   showClass: {
      popup: 'animate__animated animate__fadeInUp'
   },
   hideClass: {
      popup: 'animate__animated animate__fadeOutUp'
   }
})

//Initialize Select2 Elements
$('.select2').select2({
   theme: 'bootstrap4'
});

function edit(item_uuid){
   d.getElementById('form').onsubmit = function(e){
      if(! e.target.hasAttribute('data-form')){
         e.preventDefault();
         d.querySelector('.overlay').classList.add('show');
         d.querySelectorAll('[data-error="textarea"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
         d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         axios.put(`${app_url}/items/`+ item_uuid,{
            bien_servicio: d.getElementById('bien_servicio').value,
            fecha_requerida: d.getElementById('fecha_requerida').value,
            presupuesto: d.getElementById('presupuesto').value,
            partida_id: d.getElementById('partida_id').value
         })   
         .then(function (resp){
            // console.log(resp);
            location.reload();
            // $('#modal').modal('hide');
            // $('#items').DataTable().ajax.reload();
         })
         .catch(function (error){
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
               d.querySelector('.overlay').classList.remove('show');
                for (let key in  objeto) 
                {
                    console.log(key);
                    console.log(objeto[key]);
                    //key nombre del campo ej. nombre_operacion
                    //objeto[key] valor ej. "El campo nombre operacion es obligatorio. SU VALOR"
                    d.getElementById(key).classList.add('is-invalid');
                    d.getElementById(key+'-error').textContent = objeto[key];
                }
            }
         })
      }
   }
}

function delet(item_uuid){
   d.getElementById('form_delete').onsubmit = function(e){
      e.preventDefault();
      axios.delete(`${app_url}/items/` + item_uuid)
      .then(function (response) {
         location.reload();
         // $('#modal_delete').modal('hide');
         // $('#items').DataTable().ajax.reload(null, false);
      })
      .catch(function (error) {
         Toast.fire({
            padding: '6px',
            width: '320px',
            icon: 'error',
            title: 'Error al realizar la acción'
        })
      });
   }
}

// EVENTO CLICK
d.addEventListener('click', (e)=>{
   // ENFOCAR input select2
   if(e.target.matches('.select2-selection__rendered')){
      if(d.querySelector('.select2-search__field') != null){
          d.querySelector('.select2-search__field').focus();
      }   
   }

   if(e.target.matches('#nuevo') || e.target.matches('#nuevo *'))
   {
      $('#partida_id').val(null).trigger('change'); //indicamos que el select2 su selected sea null al momento de abrir el modal e insertar un registro
      d.querySelector('.overlay').classList.remove('show');
      d.querySelectorAll('[data-error="textarea"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.getElementById('form').reset();
      d.querySelector('.modal-title').textContent = 'Nuevo Item Servicio';
      d.getElementById('form').setAttribute('data-form', '');
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *'))
   {
      d.querySelector('.overlay').classList.remove('show');
      d.querySelectorAll('[data-error="textarea"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      const data = $('#items').DataTable().row($(e.target).parents('tr') ).data();
      d.querySelector('.modal-title').textContent = 'Editar Item Servicio';
      d.getElementById('form').removeAttribute('data-form');
      d.getElementById('bien_servicio').value = data['bien_servicio'];
      d.getElementById('fecha_requerida').value = data['fecha_requerida'];
      d.getElementById('presupuesto').value = data['presupuesto'];
      // $('#partida_id').select2('val', '1');
      $('#partida_id').val(data.partida_id).trigger('change');
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *'))
   {
      $('#modal_delete').modal('show');
      let data = $('#items').DataTable().row($(e.target).parents('tr') ).data();
      d.querySelector('.message').textContent = data.bien_servicio;
   }
});

// EVENTO SUBMIT
d.addEventListener('submit', (e)=>{
   if(e.target.matches('#form'))
   {
      if(e.target.hasAttribute('data-form'))
      {
         e.preventDefault();
         d.querySelector('.overlay').classList.add('show');
         d.querySelectorAll('[data-error="textarea"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
         d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         const datos = new FormData(e.target);
			axios.post(`${app_url}/items/`+ actividad_uuid, datos) //enviamos todos los input del form
        	.then(function (response) {
            //console.log(response);
            location.reload();
            // $('#items').DataTable().ajax.reload(null, false);
            // $('#modal').modal('hide');
         })
         .catch(function (error) {
            // console.log(error.response.data.errors);
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
               d.querySelector('.overlay').classList.remove('show');
               for (let key in  objeto) {
                  // console.log(key);
                  // console.log(objeto[key]);
                  d.getElementById(key).classList.add('is-invalid');
                  d.getElementById(key+'-error').textContent = objeto[key];
               }
            }
         });
      }
   }
})