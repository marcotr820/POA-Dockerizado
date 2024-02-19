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

function edit(mediano_plazo_accion_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            e.preventDefault();
            d.querySelector('.overlay').classList.add('show');
            $(document).find('[data-error="input"]').removeClass('is-invalid');
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            $(document).find('[data-error="span"]').text('');
            axios.put(`${app_url}/mediano_plazo_acciones/`+ mediano_plazo_accion_uuid, {
                codigo_mediano_plazo: d.getElementById('codigo_mediano_plazo').value,
                accion_mediano_plazo: d.getElementById('accion_mediano_plazo').value,
            })
            .then(function (resp){
                $('#modal').modal('hide');
                $('#acciones_mediano_plazo').DataTable().ajax.reload();
            })
            .catch(function (error){
                const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
                if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
                {
                    d.querySelector('.overlay').classList.remove('show');
                    for (let key in  objeto)
                    {
                        d.getElementById(key).classList.add('is-invalid');
                        d.getElementById(key+'-error').textContent = objeto[key];
                    }
                }
            })
        }
    }
}

function delet(mediano_plazo_accion_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        axios.delete(`${app_url}/mediano_plazo_acciones/`+ mediano_plazo_accion_uuid)
        .then(function (resp){
            $('#modal_delete').modal('hide');
            $('#acciones_mediano_plazo').DataTable().ajax.reload();
        })
        .catch(function (error){
            $('#modal_delete').modal('hide');
            Toast.fire({
                padding: '6px',
                width: '320px',
                icon: 'error',
                title: 'Error al realizar la acción'
            })
        })
    }
}

// EVENTO CLICK
d.addEventListener('click', (e)=>{
    if(e.target.matches('[data-objetivo_gestion]')){
        let data = $('#acciones_mediano_plazo').DataTable().row($(e.target).parents('tr') ).data();
        location.href=`${app_url}/mediano_plazo_acciones/${data.uuid}/pei_objetivos_especificos`;
    }

    if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="span"]').text('');
        d.getElementById('form').setAttribute('data-form', '');
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nueva Accion Mediano Plazo");
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
      d.querySelector('.overlay').classList.remove('show');
      $(document).find('[data-error="input"]').removeClass('is-invalid');
      $(document).find('[data-error="textarea"]').removeClass('is-invalid');
      $(document).find('[data-error="span"]').text('');
      d.getElementById('form').removeAttribute('data-form');
      let data = $('#acciones_mediano_plazo').DataTable().row($(e.target).parents('tr') ).data();
      $("#codigo_mediano_plazo").val(data.codigo_mediano_plazo);
      $("#accion_mediano_plazo").val(data.accion_mediano_plazo);
      $("#modal .modal-title").text("Editar Accion Mediano Plazo");
      $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')){
        let data = $('#acciones_mediano_plazo').DataTable().row($(e.target).parents('tr') ).data();
        d.querySelector('.message').innerHTML = data.accion_mediano_plazo;
        $('#modal_delete').modal('show');
    }
})

//Evento Submit
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        if(e.target.hasAttribute('data-form')){
            e.preventDefault();
            d.querySelector('.overlay').classList.add('show');
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            $(document).find('[data-error="span"]').text('');
            const datos = new FormData(e.target);
            axios.post(`${app_url}/mediano_plazo_acciones/`+ resultado_uuid, datos)
            .then(function (resp){
                $('#modal').modal('hide');
                $('#acciones_mediano_plazo').DataTable().ajax.reload(null, false);
            })
            .catch(function (error){
                // console.log(error.response.data.errors);
                const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
                if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
                {
                    d.querySelector('.overlay').classList.remove('show');
                    for (let key in  objeto)
                    {
                        d.getElementById(key).classList.add('is-invalid');
                        d.getElementById(key+'-error').textContent = objeto[key];
                    }
                }
            })
        }
    }
})