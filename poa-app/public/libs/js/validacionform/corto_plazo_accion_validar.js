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

function edit(accion_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            let datosform = $('#form').serializeArray();
            $.ajax({
                url: `${app_url}/corto_plazo_acciones/` + accion_uuid,
                type: 'PUT',
                data: datosform,
                beforeSend:function(){
                    d.querySelector('.overlay').classList.add('show');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="textarea"]').removeClass('is-invalid');
                    $(document).find('[data-error="span"]').text('');
                },
                success:function(res){
                    // console.log(res);
                    $('#corto_plazo_acciones').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(respuesta){
                    if(respuesta.responseJSON.hasOwnProperty('errors')){
                        $.each(respuesta.responseJSON.errors, function(key, value){
                            d.querySelector('.overlay').classList.remove('show');
                            // console.log(key);
                            // console.log(value);
                            $('input[id='+ key +']').addClass('is-invalid');
                            $('span[id='+key+'-error]').text(value);
                            $('textarea[id='+ key +']').addClass('is-invalid'); 
                        })
                    }
                }
            })
        }
    }
}

function delet(accion_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        let datosform = $('#form_delete').serializeArray();
        $.ajax({
            url: `${app_url}/corto_plazo_acciones/` + accion_uuid,
            type: 'delete', 
            data: datosform,  
            success:function(resp)
            {
                $('#corto_plazo_acciones').DataTable().ajax.reload(null, false);
                $('#modal_delete').modal('hide');
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
    }
}

// evento click
d.addEventListener('click', (e)=>{
    if(e.target.matches('[data-planificacion]')){
        let data = $('#corto_plazo_acciones').DataTable().row($(e.target).parents('tr') ).data();
        location.href=`${app_url}/planificacion/${data.uuid}`;
    }

    if(e.target.matches('[data-operaciones]')){
        let data = $('#corto_plazo_acciones').DataTable().row($(e.target).parents('tr') ).data();
        location.href=`${app_url}/corto_plazo_acciones/${data.uuid}/operaciones`;
    }

    if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="span"]').text('');
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nueva Acción Corto Plazo"); 
        $("#modal").modal("show");
        d.getElementById('form').setAttribute('data-form', '');
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
        // quitamos al hiden a los campos fechas al abrir el formulario
        d.getElementById('fecha_inicio').parentElement.parentElement.hidden = false;
        d.getElementById('fecha_fin').parentElement.parentElement.hidden = false;

        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $(document).find('[data-error="span"]').text('');
        d.getElementById('form').removeAttribute('data-form');
        let data = $('#corto_plazo_acciones').DataTable().row($(e.target).parents('tr') ).data();
        if(data.evaluaciones > 0){
            // si la accion corto ya tiene evaluaciones se ocultara la fecha para que no pueda ser editada
            d.getElementById('fecha_inicio').parentElement.parentElement.hidden = true;
            d.getElementById('fecha_fin').parentElement.parentElement.hidden = true;
        }
        $("#accion_corto_plazo").val(data.accion_corto_plazo);
        $("#gestion").val(data.gestion);
        $("#resultado_esperado").val(data.resultado_esperado);
        $("#presupuesto_programado").val(data.presupuesto_programado);
        $("#fecha_inicio").val(data.fecha_inicio);
        $("#fecha_fin").val(data.fecha_fin);
        $("#modal .modal-title").text("Editar Acción Corto Plazo"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')){
        e.preventDefault();
        $('#modal_delete').modal('show');
        let data = $('#corto_plazo_acciones').DataTable().row($(e.target).parents('tr') ).data();
        d.querySelector('.message').innerHTML = data.accion_corto_plazo;
    }
})

// evento submit
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        e.preventDefault();
        if(e.target.hasAttribute('data-form')){
            let datosform = $('#form').serializeArray();
            $.ajax({
                // url:$(this).attr('action'),
                url: `${app_url}/corto_plazo_acciones/`+ pei_uuid,
                type: 'POST',
                data: datosform,
                beforeSend:function(resp){
                    d.querySelector('.overlay').classList.add('show');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="textarea"]').removeClass('is-invalid');
                    $(document).find('[data-error="span"]').text('');
                },
                success:function(resp){
                    $('#corto_plazo_acciones').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(resp){
                    if(resp.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(resp.responseJSON.errors, function(key, value){
                            $('input[id='+key+']').addClass('is-invalid');
                            $('span[id='+key+'-error]').text(value);
                            $('textarea[id='+ key +']').addClass('is-invalid'); 
                        })
                    }
                }
            })
        }
    }
})