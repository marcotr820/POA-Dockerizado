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

function edit(partida_uuid){
   d.getElementById('form').onsubmit = function(e){
      if(! e.target.hasAttribute('data-form')){
         e.preventDefault();
         d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
         d.querySelectorAll('[data-error="select"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
         d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
         d.querySelector('.overlay').classList.add('show');
         axios.put(`${app_url}/partidas/`+ partida_uuid, {
            nombre_partida: d.getElementById('nombre_partida').value,
            codigo_partida: d.getElementById('codigo_partida').value,
            tipo_partida: d.getElementById('tipo_partida').value
         }) //enviamos todos los input del form
         .then(function (response) {
            $('#partidas').DataTable().ajax.reload(null, false);
            $('#modal').modal('hide');
         })
         .catch(function (error) {
            // console.log(error.response.data.errors);
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
               d.querySelector('.overlay').classList.remove('show');
               for (let key in  objeto) {
                  d.getElementById(key).classList.add('is-invalid');
                  d.getElementById(key+'-error').textContent = objeto[key];
               }
            }
         });
      }
   }
}

// EVENTO CLICK
d.addEventListener('click', (e)=>{
   if(e.target.matches('#nuevo') || e.target.matches('#nuevo *'))
   {
      d.getElementById('form').reset();
      d.querySelector('.overlay').classList.remove('show');
      d.querySelector('.modal-title').textContent = 'Nueva Partida';
      d.getElementById('form').setAttribute('data-form', '');
      d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
      d.querySelectorAll('[data-error="select"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
    	d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *'))
   {
      const data =  $('#partidas').DataTable().row($(e.target).parents('tr') ).data();
      d.querySelector('.overlay').classList.remove('show');
      d.querySelector('.modal-title').textContent = 'Editar Partida';
      d.getElementById('nombre_partida').value = data['nombre_partida'];
      d.getElementById('codigo_partida').value = data['codigo_partida'];
      d.getElementById('tipo_partida').value = data.tipo_partida;
      d.getElementById('form').removeAttribute('data-form');
      d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
      d.querySelectorAll('[data-error="select"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
    	d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
      id_partida = data['id'];
      $('#modal').modal('show');
   }
});

// EVENTO SUBMIT
d.addEventListener('submit', (e)=>{
   if(e.target.matches('#form')){
      if(e.target.hasAttribute('data-form')){
         e.preventDefault();
         d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
         d.querySelectorAll('[data-error="select"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el select del error
         d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
         const datos = new FormData(e.target);
         d.querySelector('.overlay').classList.add('show');
         axios.post(`${app_url}/partidas`, datos) //enviamos todos los input del form
         .then(function (response) {
            $('#partidas').DataTable().ajax.reload(null, false);
            $('#modal').modal('hide');
         })
         .catch(function (error) {
            // console.log(error.response.data.errors);
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
               d.querySelector('.overlay').classList.remove('show');
               for (let key in  objeto) {
                  d.getElementById(key).classList.add('is-invalid');
                  d.getElementById(key+'-error').textContent = objeto[key];
               }
            }
         });
      }
   }

   if(e.target.matches('[data-formdelete]')){
      e.preventDefault();
      let data = $('#partidas').DataTable().row($(e.target).parents('tr') ).data();
      Swal.fire({
			html: "Desea Eliminar el Registro : <br> <u><b>"+data.nombre_partida+"</b></u>",
			width: '20%',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			confirmButtonText: 'Si eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) 
			{
				axios.delete(`${app_url}/partidas/` + data.uuid)
				.then(function (response) {
					$('#partidas').DataTable().ajax.reload(null, false);
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
		})
   }
});