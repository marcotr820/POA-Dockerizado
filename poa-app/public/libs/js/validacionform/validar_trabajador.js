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

$('.select2').select2({
   theme: 'bootstrap4',
});

function edit(trabajador_uuid) {
   d.getElementById('form').onsubmit = function (e) {
      if (!e.target.hasAttribute('data-form')) {
         d.querySelectorAll('[data-error="input"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
         d.querySelectorAll('[data-error="select"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
         d.querySelectorAll('[data-error="span"]').forEach((el) => { el.textContent = '' }); //limpiamos el span del error
         d.querySelector('.overlay').classList.add('show');
         axios.put(`${app_url}/trabajadores/` + trabajador_uuid, {
            documento: d.getElementById('documento').value,
            unidad_id: d.getElementById('unidad_id').value,
            nombre: d.getElementById('nombre').value,
            cargo: d.getElementById('cargo').value,
         })
            .then(function (resp) {
               $('#modal').modal('hide');
               $('#trabajadores').DataTable().ajax.reload(null, false);
            })
            .catch(function (error) {
               d.querySelector('.overlay').classList.remove('show');
               const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
               if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
               {
                  for (let key in objeto) {
                     d.getElementById(key).classList.add('is-invalid');
                     d.getElementById(key + '-error').textContent = objeto[key];
                  }
               }
            })
      }
   };
}

function delet(trabajador_uuid) {
   d.getElementById('form_delete').onsubmit = function (e) {
      e.preventDefault();
      axios.delete(`${app_url}/trabajadores/` + trabajador_uuid)
         .then(function (resp) {
            $('#modal_delete').modal('hide');
            $('#trabajadores').DataTable().ajax.reload(null, false);
         })
         .catch(function (error) {
            $('#modal_delete').modal('hide');
            Toast.fire({
               padding: '6px',
               width: '320px',
               icon: 'error',
               title: 'Error al realizar la acción'
            })
         })
   };
}

// EVENTO CLICK
$(document).on('click', function (e) {
   // ENFOCAR input select2
   if (e.target.matches('.select2-selection__rendered')) {
      if (d.querySelector('.select2-search__field') != null) {
         d.querySelector('.select2-search__field').focus();
      }
   }

   if (e.target.matches('#nuevo') || e.target.matches('#nuevo *')) {
      $('#unidad_id').val(null).trigger('change'); //indicamos que el select2 su selected sea null al momento de abrir el modal e insertar un registro
      d.querySelector('.overlay').classList.remove('show');
      d.getElementById('form').reset()
      $('#form').trigger("reset");
      d.querySelector('.modal-title').textContent = 'Registrar Trabajador';
      d.querySelectorAll('[data-error="input"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
      d.querySelectorAll('[data-error="select"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
      d.querySelectorAll('[data-error="span"]').forEach((el) => { el.textContent = '' }); //limpiamos el span del error
      d.getElementById('form').setAttribute('data-form', '');
      $('#modal').modal('show');
   }

   if (e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')) {
      d.querySelector('.overlay').classList.remove('show');
      d.getElementById('form').reset();
      d.querySelectorAll('[data-error="input"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
      d.querySelectorAll('[data-error="select"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
      d.querySelectorAll('[data-error="span"]').forEach((el) => { el.textContent = '' }); //limpiamos el span del error
      // const data = tabla_trabajadores.row($(e.target).parents('tr') ).data();
      const data = $("#trabajadores").DataTable().row($(e.target).parents('tr')).data();
      d.querySelector('.modal-title').textContent = 'Editar Trabajador';
      d.getElementById('documento').value = data.documento;
      // $('#unidad_id').select2('val', String(data.unidad_id));
      $('#unidad_id').val(data.unidad_id).trigger('change');
      d.getElementById('nombre').value = data.nombre;
      d.getElementById('cargo').value = data.cargo;
      d.getElementById('form').removeAttribute('data-form');
      $('#modal').modal('show');
   }

   if (e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')) {
      const data = $("#trabajadores").DataTable().row($(e.target).parents('tr')).data();
      const nombre = data.nombre;
      d.querySelector('.message').innerHTML = nombre;
      $('#modal_delete').modal('show');
   }

});

// EVENTO SUBMIT
d.addEventListener('submit', (e) => {
   if (e.target.matches('#form')) {
      e.preventDefault();
      if (e.target.hasAttribute('data-form')) //si contiene el data-form significa que es una insercion
      {  //POST
         d.querySelectorAll('[data-error="input"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
         d.querySelectorAll('[data-error="select"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
         d.querySelectorAll('[data-error="span"]').forEach((el) => { el.textContent = '' }); //limpiamos el span del error
         d.querySelector('.overlay').classList.add('show');
         const datos = new FormData(e.target);
         axios.post(`${app_url}/trabajadores`, datos) //enviamos todos los input del form
            .then(function (response) {
               // console.log(response);
               $("#trabajadores").DataTable().ajax.reload(null, false);
               $('#modal').modal('hide');
            })
            .catch(function (error) {
               d.querySelector('.overlay').classList.remove('show');
               // console.log(error.response.data.errors);
               const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
               if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
               {
                  for (let key in objeto) {
                     //key: llave    objeto[key]: valor respuesta
                     d.getElementById(key).classList.add('is-invalid');
                     d.getElementById(key + '-error').textContent = objeto[key];
                  }
               }
            });
      }
   }

});

// evento keyup
d.addEventListener('keyup', (e) => {
   if (e.target.matches('[data-string]')) {
      // console.log(e.target);
      if (/\d/.test(e.target.value)) {
         e.target.value = e.target.value.replace(/\d/g, '');
      }
   }
})