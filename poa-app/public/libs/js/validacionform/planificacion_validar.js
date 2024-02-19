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

d.querySelector('.alert').style.display = 'none';

function delet(planificacion_uuid){
   d.getElementById('form_delete').onsubmit = function(e){
      e.preventDefault();
         axios.delete(`${app_url}/planificacion/` + planificacion_uuid)
         .then(function (response) {
            //console.log(response.data);
            $('#modal_delete').modal('hide');
            $('#planificacion').DataTable().ajax.reload(null, false);
            d.getElementById('nuevo').style.display = 'inline';
         })
         .catch(function (error) {

         });
   }
}

d.addEventListener('click', (e)=>{
   if(e.target.matches('#nuevo') || e.target.matches('#nuevo *'))
   {
      d.querySelector('.overlay').classList.remove('show');
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.getElementById('form_planificacion').reset();
      d.querySelector('.modal-title').textContent = 'Registrar Planificacion Accion Corto Plazo';
      d.getElementById('form_planificacion').setAttribute('data-form', '');
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *'))
   {
      e.preventDefault();
      const data = $('#planificacion').DataTable().row($(e.target).parents('tr') ).data();
      d.querySelector('.message').innerHTML = 'planificacion';
      $('#modal_delete').modal('show');
   }
});

d.addEventListener('submit', (e)=>{
   if(e.target.matches('#form_planificacion'))
   {
      e.preventDefault();
      if(e.target.hasAttribute('data-form'))
      {
         d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
         const lista = d.querySelectorAll('#lista input');
         var bb = 0;
         lista.forEach((el)=>{
             bb += parseInt(el.value); //sumamos todos los campos para que den un valor de 100
         })
         // console.log(bb);
         if(bb != 100)
         {
            d.querySelector('.alert').style.display = 'block';
            setTimeout( () =>{
               d.querySelector('.alert').style.display = 'none';
           }, 2500);
         }
         else
         {
            d.querySelector('.overlay').classList.add('show');
            const datos = new FormData(e.target);
            axios.post(`${app_url}/planificacion/`+ corto_plazo_uuid, datos) //enviamos todos los input del form
            .then(function (response) {
               // console.log(response);
               d.getElementById('nuevo').style.display = 'none';
               $('#planificacion').DataTable().ajax.reload(null, false);
               $('#modal').modal('hide');
            })
            .catch(function (error) {
               // console.log(error.response.data.errors);
               const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
               if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
               {
                  d.querySelector('.overlay').classList.remove('show');
                  for (let key in  objeto) 
                  {
                  // console.log(key);
                  // console.log(objeto[key]);
                  key !== 'error_validacion'? 
                     (d.getElementById(key).classList.add('is-invalid'), d.getElementById(key+'-error').textContent = objeto[key]) 
                     : (d.getElementById(key+'-error').textContent = objeto[key]);
                  }
               }
            });
         }
      }
   }
});