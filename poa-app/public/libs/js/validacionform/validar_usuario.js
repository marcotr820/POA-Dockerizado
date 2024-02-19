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
    theme: 'bootstrap4',
});

function edit(usuario_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(!e.target.hasAttribute('data-form')){
            e.preventDefault();
            d.querySelector('.overlay').classList.add('show');
            var array_roles = [];
            d.querySelectorAll('input[type=checkbox]:checked').forEach((el)=>{
                array_roles.push(el.value);
            });
            axios.put(`${app_url}/usuarios/`+ usuario_uuid,{
                // password: d.getElementById('password').value,
                roles: array_roles, //enviamos los roles con checked
            })
            .then(function (resp){
                $("#modal").modal("hide");
                $('#usuarios').DataTable().ajax.reload();
            })
            .catch(function (error){
                // console.log(error.response.data.errors);
                const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
                if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
                {
                    d.querySelector('.overlay').classList.remove('show');
                    for (let key in  objeto) 
                    {
                        //key: llave    objeto[key]: valor respuesta
                        // d.getElementById(key).classList.add('is-invalid');
                        d.getElementById(key+'-error').textContent = objeto[key];
                    }
                }
            })
        }
    }
}

function delet(usuario_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        //rescatamos el token del formulario de eliminar para enviarlo
        let datosform = $('#form_delete').serializeArray();
        $.ajax({
            url: `${app_url}/usuarios/` + usuario_uuid,
            type: 'DELETE', 
            data: datosform,  
            success:function(respuesta)
            {
                //console.log(respuesta);
                $('#modal_delete').modal('hide');
                $('#usuarios').DataTable().ajax.reload(null, false);
            },
            error:function()
            {
                $('#modal_delete').modal('hide');
                Toast.fire({
                    padding: '6px',
                    width: '320px',
                    icon: 'error',
                    title: 'Error al realizar la acción'
                })
            }
        })
    };
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
        d.querySelector('.overlay').classList.remove('show');
        //si cerramos el modal con errores al volver a abrirlo quitamos los errores anterires 
        $(document).find('[data-error="select"]').removeClass('is-invalid');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        d.getElementById('trabajador_id').removeAttribute('disabled');
        d.getElementById('form').setAttribute('data-form', '');
        d.querySelector('[data-block="btn"]').style.display = 'none';
        d.querySelector('[data-block="input"]').style.display = 'block';
        //quitamos los valores seleccionados del input multiple
        axios.get(`${app_url}/selectTrabajadores`)
        .then(function (datos){
            let $options = '<option value="">seleccione...</option>';
            for(let i=0; i<datos.data.length; i++){
                $options += '<option value="'+datos.data[i].id+'">'+datos.data[i].documento+' - '+datos.data[i].nombre+'</option>';
            }
            d.getElementById('trabajador_id').innerHTML = $options;
        })
        .catch(function (error){

        });

        $("#form").trigger("reset");
        $("#modal .modal-title").text("Registrar Usuario"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *'))
    {
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="span"]').text('');
        d.querySelector('.select2').classList.remove('is-invalid');
        d.getElementById('form').reset(); //limpiamos el formulario
        d.getElementById('form').removeAttribute('data-form');
        d.querySelector('[data-block="btn"]').style.display = 'block';
        d.querySelector('[data-block="input"]').style.display = 'none';
        //si cerramos el modal con errores al volver a abrirlo quitamos los errores anterires 
        $(document).find('span.error-text').text('');
        $(document).find('input.validacion').removeClass('is-invalid');
        //rescatamos la fila de datos del boton clickeado
        let data = $('#usuarios').DataTable().row($(e.target).parents('tr') ).data();
        d.getElementById('u_password').setAttribute('value', data.uuid);
        //obtenemos el valor del token
        //let _token = document.querySelector('[name="_token"]').value;
        $option = `<option value="">${data.usuario} - ${data.nombre}</option>`;
        d.getElementById('trabajador_id').innerHTML = $option;
        d.getElementById('trabajador_id').setAttribute('disabled', true);
        // d.getElementById('password').value = data.password;

        axios.get(`${app_url}/rolesUsuario/` + data.uuid)
        .then(function (datos){
            // let roles=[] //para trabajar con select2 multiple
            // for(let i=0; i<datos.data.length; i++){
            //     // console.log('rol'+datos.data[i].role_id);
            //     roles.push(datos.data[i].role_id);
            //     $('#roles').val(roles).trigger('change');
            // }
            for(let i=0; i<datos.data.length; i++){
                // console.log('rol'+datos.data[i].role_id);
                d.querySelector('[data-role="rol'+datos.data[i].role_id+'"]').checked = true;
            }
        })
        .catch(function (error){
            // console.log('error'+error);
        })
        $("#modal .modal-title").text("Editar Usuario"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *'))
    {
        let data = $('#usuarios').DataTable().row($(e.target).parents('tr') ).data();
        d.querySelector('.message').innerHTML = `${data.usuario} - ${data.nombre}`;
        $('#modal_delete').modal('show');
    }

    if(e.target.matches('#u_password') || e.target.matches('#u_password *')){
        location.href = `${app_url}/usuarios/${d.getElementById('u_password').value}/update_password`;
    }
})

// EVENTO SUBMIT
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form'))
    {
        e.preventDefault();
        if(e.target.hasAttribute('data-form'))//si contiene el data-form significa que es una insercion
        {
            d.querySelector('.overlay').classList.add('show');
            d.querySelector('.select2').classList.remove('is-invalid');
            d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
            d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
            const datos = new FormData(e.target);
            axios.post(`${app_url}/usuarios`, datos) //enviamos todos los input del form
            .then(function (response) {
                // console.log(response);
                $("#modal").modal("hide");
                $('#usuarios').DataTable().ajax.reload(null, false);
            })
            .catch(function (error) {
                d.querySelector('.overlay').classList.remove('show');
                // console.log(error.response.data.errors);
                const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
                if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
                {
                    for (let key in  objeto) 
                    {   //key: llave    objeto[key]: valor respuesta
                        // console.log(key);
                        if(key !== 'roles'){
                            d.getElementById(key).classList.add('is-invalid');
                            d.getElementById(key+'-error').textContent = objeto[key];
                        }else{
                            d.getElementById(key+'-error').textContent = objeto[key];
                        }
                    }
                }
            });
        }
    }
})