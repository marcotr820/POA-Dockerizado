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

function edit(actividad_uuid){
	d.getElementById('form').onsubmit = function (e){
		e.preventDefault();
		if(! e.target.hasAttribute('data-form')){
			d.querySelector('.overlay').classList.add('show');
			d.querySelectorAll('[data-error="textarea"]').forEach( (el) => { el.classList.remove('is-invalid') });
			d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
    		d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
			axios.put(`${app_url}/actividades/` + actividad_uuid, {
				nombre_actividad: d.getElementById('nombre_actividad').value,
				resultado_esperado: d.getElementById('resultado_esperado').value
			})
			.then(function (response) {
				// console.log(response);
				$('#actividades').DataTable().ajax.reload(null, false);
				$('#modal').modal('hide');
			})
			.catch(function (error) {
				//console.log(error.response.data.errors);
				let objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
				if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
				{
					d.querySelector('.overlay').classList.remove('show');
					for (let key in  objeto) 
					{
						d.getElementById(key).classList.add('is-invalid');
						d.getElementById(key+'-error').textContent = objeto[key];
					}
				}
			});
		}
	}
}

function delet(actividad_uuid){
	d.getElementById('form_delete').onsubmit = function(e){
		e.preventDefault();
		axios.delete(`${app_url}/actividades/` + actividad_uuid)
		.then(function (response) {
			$('#modal_delete').modal('hide');
			$('#actividades').DataTable().ajax.reload(null, false);
		})
		.catch(function (error) {
			$('#modal_delete').modal('hide');
			Toast.fire({
                padding: '6px',
                width: '320px',
                icon: 'error',
                title: 'Error al realizar la acción'
            })
		});
	}
}
// evento click
d.addEventListener('click', (e)=>{
	if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
		d.querySelector('.overlay').classList.remove('show');
		d.querySelectorAll('[data-error="textarea"]').forEach( (el) => { el.classList.remove('is-invalid') });
		d.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
    	d.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' }); //limpiamos el span del error
		d.getElementById('form').setAttribute('data-form', '');
		d.querySelector('.modal-title').textContent = 'Nueva Actividad';
		d.getElementById('form').reset();
		$('#modal').modal('show');
		d.getElementById('form').setAttribute('data-form', '');
	}

	if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *'))
	{
		d.querySelector('.overlay').classList.remove('show');
		d.querySelectorAll('[data-error="textarea"]').forEach( (el) => { el.classList.remove('is-invalid') });
		d.querySelectorAll('[data-error="input"]').forEach(el => { el.classList.remove('is-invalid') }); //limpiamos el input del error
		d.querySelectorAll('[data-error="span"]').forEach(el => { el.textContent = '' }); //limpiamos el span del error
		d.querySelector('.modal-title').textContent = 'Editar Actividad';
		// const data = tabla_actividades.row($(this).parents('tr') ).data();
		const data = $('#actividades').DataTable().row($(e.target).parents('tr') ).data();
		d.getElementById('nombre_actividad').value = data['nombre_actividad'];
		d.getElementById('resultado_esperado').value = data['resultado_esperado'];
		d.getElementById('form').removeAttribute('data-form');
		$("#modal").modal("show");
	}

	if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *'))
	{
		e.preventDefault();
		// const data = tabla_actividades.row($(this).parents('tr') ).data();
		let data = $('#actividades').DataTable().row($(e.target).parents('tr') ).data();
		d.querySelector('.message').innerHTML = data.nombre_actividad;
		$('#modal_delete').modal('show');
	}

	if(e.target.matches('[data-tareas]'))
	{
		let data = $('#actividades').DataTable().row($(e.target).parents('tr') ).data();
		location.href=`${app_url}/actividades/${data.uuid}/tareas_especificas`;
	}

	if(e.target.matches('[data-items]'))
	{
		let data = $('#actividades').DataTable().row($(e.target).parents('tr') ).data();
		this.location.href=`${app_url}/actividades/${data.uuid}/items`;
	}

})

// evento submit
d.addEventListener('submit', (e)=>{
	if(e.target.matches('#form')){
		e.preventDefault();
		if(e.target.hasAttribute('data-form')) //verificamos si tiene el atributo data-form
		{	//POST
			d.querySelector('.overlay').classList.add('show');
			d.querySelectorAll('[data-error="textarea"]').forEach( (el) => { el.classList.remove('is-invalid') });
			d.querySelectorAll('[data-error="input"]').forEach((el) => { el.classList.remove('is-invalid') }); //limpiamos el input del error
			d.querySelectorAll('[data-error="span"]').forEach((el) => { el.textContent = '' }); //limpiamos el span del error
			const datos = new FormData(e.target);
			axios.post(`${app_url}/actividades/${operacion_uuid}`, datos) //enviamos todos los input del form
        	.then(function (response) {
				// console.log(response);
				$('#actividades').DataTable().ajax.reload(null, false);
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
                    //console.log(key);
                    //console.log(errores[key]);
                    //key nombre del campo ej. nombre_operacion
                    //objeto[key] valor ej. "El campo nombre operacion es obligatorio. SU VALOR"
                    d.getElementById(key).classList.add('is-invalid');
                    d.getElementById(key+'-error').textContent = objeto[key];
                }
            }
        	});
		}
	}
});