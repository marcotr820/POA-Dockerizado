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

function edit(resultado_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            e.preventDefault();
            d.querySelector('.overlay').classList.add('show');
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            $(document).find('[data-error="span"]').text('');
            axios.put(`${app_url}/resultados/`+ resultado_uuid,{
                codigo_resultado: d.getElementById('codigo_resultado').value,
                nombre_resultado: d.getElementById('nombre_resultado').value,
            })
            .then(function (resp){
                $('#modal').modal('hide');
                $('#resultados').DataTable().ajax.reload(); // tabla_actividades.ajax.reload(null, false);
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

function delet(resultado_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        axios.delete(`${app_url}/resultados/`+ resultado_uuid)
        .then(function (resp){
            $('#modal_delete').modal('hide');
            $('#resultados').DataTable().ajax.reload();
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

//Evento click
d.addEventListener('click', (e)=>{
    if(e.target.matches('[data-mediano]')){
        // let data = $('#resultados').DataTable().row($(this).parents('tr') ).data();
        let data = $('#resultados').DataTable().row($(e.target).parents('tr') ).data();
        location.href=`${app_url}/resultados/${data.uuid}/acciones_mediano_plazo`;
    }

    if(e.target.matches('#nuevo')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nuevo Resultado"); 
        d.getElementById('form').setAttribute('data-form', '');
        //si cerramos el modal con errores al volver a abrirlo quitamos los errores anterires llamando a sus clases de cada elemento
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="span"]').text('');
        d.getElementById('form').removeAttribute('data-form');
        let data = $('#resultados').DataTable().row($(e.target).parents('tr') ).data();
        $("#codigo_resultado").val(data.codigo_resultado);
        $("#nombre_resultado").val(data.nombre_resultado);
        $(".modal-title").text("Editar Resultado"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')){
        // let data = $('#resultados').DataTable().row($(this).parents('tr') ).data();
        let data = $('#resultados').DataTable().row($(e.target).parents('tr') ).data();
        d.querySelector('.message').innerHTML = data.nombre_resultado;
        $('#modal_delete').modal('show');
    }
})

d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        e.preventDefault();
        if(e.target.hasAttribute('data-form')){
            d.querySelector('.overlay').classList.add('show');
            let datosform = $('#form').serializeArray();
            $(document).find('[data-error="textarea"]').removeClass('is-invalid');
            $(document).find('[data-error="span"]').text('');
            $.ajax({
                // url:$(this).attr('action'),
                url: `${app_url}/resultados/`+ meta_uuid,
                type: 'POST',
                data: datosform,
                beforeSend:function(resp){
                    $(document).find('span.error-text').text('');
                    //a los elementos que llevan la clase form control y que esten llenados les quita la clase is-invalid
                    $(document).find('input.form-control').removeClass('is-invalid');
                },
                success:function(resp){
                    console.log(resp);
                    $('#resultados').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                    //removemos la clase una ves registrado el trabajador
                    $('#form_resultado').removeClass('nuevo');
                },
                error:function(resp){
                  console.log(resp);
                  if(resp.responseJSON.hasOwnProperty('errors')){
                      d.querySelector('.overlay').classList.remove('show');
                      $.each(resp.responseJSON.errors, function(key, value){
                          $('textarea[id='+ key +']').addClass('is-invalid');
                          // console.log(key);
                          // console.log(value);
                          //mostramos los erroes que perteneve sl id del input donde se mostrara el error
                          $('span[id='+key+'-error]').text(value);
                      })
                  }
                }
            })
        }
    }
})