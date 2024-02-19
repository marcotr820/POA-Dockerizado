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

// calculo del presupuesto restante
// const presupuesto_restante = d.querySelector('[data-restante]').value;
// d.getElementById('presupuesto_ejecutado').onkeyup = function(e){
//    d.querySelector('[data-restante]').value = parseInt(presupuesto_restante) - (e.target.value === '' ? 0 : parseInt(e.target.value));
// }

function edit(evaluacion_uuid) {
   d.getElementById('form').onsubmit = function(e){
      if(! e.target.hasAttribute('data-form'))
      {
         d.querySelector('.overlay').classList.add('show');
         d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
         d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
         axios.put(`${app_url}/evaluacion/` + evaluacion_uuid, {
            resultado_logrado: d.getElementById('resultado_logrado').value,
            presupuesto_ejecutado: d.getElementById('presupuesto_ejecutado').value
         })
         .then(function (resp){
            // console.log(resp);
            location.reload();
         })
         .catch(function (error){
            // console.log(error.response.data.errors);
            d.querySelector('.overlay').classList.remove('show');
            if (error.response.data.hasOwnProperty('errors')){
               const objeto = error.response.data.errors;
               for (let key in  objeto) {
                  d.getElementById(key).classList.add('is-invalid');
                  d.getElementById(key+'-error').textContent = objeto[key];
               }
            }
         })
      }
   }
}

d.addEventListener('click', (e)=>{
   if(e.target.matches('#nuevo') || e.target.matches('#nuevo *'))
   {
      d.querySelector('.overlay').classList.remove('show');
      d.getElementById('form').reset();
      d.getElementById('form').setAttribute('data-form', '');
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.querySelector('.modal-title').textContent = 'Registrar Evaluacion Accion Corto Plazo';
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-edit]'))
   {
      d.querySelector('.overlay').classList.remove('show');
      d.getElementById('form').removeAttribute('data-form');
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      let evaluacion_uuid = e.target.getAttribute('data-edit');
      axios.get(`${app_url}/get_evaluacion/` + evaluacion_uuid)
      .then(function (resp){
         // console.log(resp.data);
         d.getElementById('resultado_logrado').value = resp.data.resultado_logrado;
         d.getElementById('presupuesto_ejecutado').value = resp.data.presupuesto_ejecutado;
      })
      .catch(function (error){

      })
      d.querySelector('.modal-title').textContent = 'Editar Evaluacion Accion Corto Plazo';
      $('#modal').modal('show');
   }
});

// evento submit
d.addEventListener('submit', (e)=>{
   if(e.target.matches('#form')){
      e.preventDefault();
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      if(e.target.hasAttribute('data-form'))
      {
         d.querySelector('.overlay').classList.add('show');
         const datos = new FormData(e.target);
         axios.post(`${app_url}/evaluacion/` + corto_plazo_accion_uuid, datos)
         .then(function (resp){
            // console.log(resp);
            location.reload();
         })
         .catch(function (error){
            // console.log(error.response.data.errors);
            d.querySelector('.overlay').classList.remove('show');
            if (error.response.data.hasOwnProperty('errors')){
               const objeto = error.response.data.errors;
               for (let key in  objeto) {
                  d.getElementById(key).classList.add('is-invalid');
                  d.getElementById(key+'-error').textContent = objeto[key];
               }
            }
         })
      }
   }
});