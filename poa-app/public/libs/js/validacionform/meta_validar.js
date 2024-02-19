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

function edit(meta_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            d.querySelector('.overlay').classList.add('show');
            $(document).find('[data-error="span"]').text('');
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            axios.put(`${app_url}/metas/`+ meta_uuid,{
                codigo_meta: d.getElementById('codigo_meta').value,
                nombre_meta: d.getElementById('nombre_meta').value,
            })
            .then(function (resp){
                $('#modal').modal('hide');
                $('#metas').DataTable().ajax.reload(); // tabla_actividades.ajax.reload(null, false);
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
        
    };
}

function delet(meta_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        axios.delete(`${app_url}/metas/`+ meta_uuid)
        .then(function (resp){
            $('#modal_delete').modal('hide');
            $('#metas').DataTable().ajax.reload();
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
    if(e.target.matches('[data-resultados]'))
    {
        let data = $('#metas').DataTable().row($(e.target).parents('tr') ).data();
        location.href=`${app_url}/metas/${data.uuid}/resultados`;
    }

    if(e.target.matches('#nuevo') || e.target.matches('#nuevo *'))
    {
        d.querySelector('.overlay').classList.remove('show');
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nueva Meta"); 
        $("#modal").modal("show");
        d.getElementById('form').setAttribute('data-form', '');
        //si cerramos el modal con errores al volver a abrirlo quitamos los errores anterires llamando a sus clases de cada elemento
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *'))
    {
        d.querySelector('.overlay').classList.remove('show');
        d.getElementById('form').removeAttribute('data-form');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        // let data = tabla_metas.row($(this).parents('tr') ).data();
        let data = $('#metas').DataTable().row($(e.target).parents('tr') ).data();
        $("#codigo_meta").val(data.codigo_meta);
        $("#nombre_meta").val(data.nombre_meta);
        $("#modal .modal-title").text("Editar Meta"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *'))
    {
        e.preventDefault();
        // let data = tabla_metas.row($(this).parents('tr') ).data();
        let data = $('#metas').DataTable().row($(e.target).parents('tr') ).data();
        let nombre_meta = data['nombre_meta'];
        $("#modal_delete").modal("show");
        d.querySelector('.message').innerHTML = nombre_meta;
    }
})

// envio de formulario
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form'))
    {
        e.preventDefault();
        if(e.target.hasAttribute('data-form'))
        {
            d.querySelector('.overlay').classList.add('show');
            $(document).find('[data-error="span"]').text('');
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            $(document).find('[data-error="input"]').removeClass('is-invalid');
            const datos = new FormData(e.target);
            axios.post(`${app_url}/metas/`+ pilar_uuid, datos) //enviamos todos los input del form
        	.then(function (response) {
                // console.log(response);
                $('#metas').DataTable().ajax.reload(null, false);
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
                        d.getElementById(key).classList.add('is-invalid');
                        d.getElementById(key+'-error').textContent = objeto[key];
                    }
                }
            });
        }
    }
})