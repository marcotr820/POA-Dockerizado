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

function edit(pei_objetivo_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            d.querySelector('.overlay').classList.add('show');
            let datosform = $('#form').serializeArray();
            $.ajax({
                url: `${app_url}/pei_objetivos_especificos/` + pei_objetivo_uuid,
                type: 'PUT',
                data: datosform,
                beforeSend:function(){
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="select"]').removeClass('is-invalid');
                    $(document).find('[data-error="textarea"]').removeClass('is-invalid');
                },
                success:function(res){
                    $('#pei_objetivos_especificos').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(respuesta){
                    if(respuesta.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(respuesta.responseJSON.errors, function(key, value){
                            // console.log(key);
                            // console.log(value);
                            $('input[id='+ key +']').addClass('is-invalid');
                            $('select[id='+ key +']').addClass('is-invalid'); 
                            $('textarea[id='+ key +']').addClass('is-invalid'); 
                            $('span[id='+key+'-error]').text(value);
                        })
                    }
                }
            })
        }
    }
}

function delet(pei_objetivo_uuid){
    d.getElementById('form_delete').onsubmit = function(e){
        e.preventDefault();
        let datosform = $('#form_delete').serializeArray();
        $.ajax({
            url: `${app_url}/pei_objetivos_especificos/` + pei_objetivo_uuid,
            type: 'delete', 
            data: datosform,
            success:function(resp)
            {
                $('#modal_delete').modal('hide');
                $('#pei_objetivos_especificos').DataTable().ajax.reload(null, false);
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

d.addEventListener('click', (e)=>{
    if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $(document).find('[data-error="select"]').removeClass('is-invalid');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nueva Acción Institucional");
        d.getElementById('form').setAttribute('data-form', '');
        //si cerramos el modal con errores al volver a abrirlo quitamos los errores anterires llamando a sus clases de cada elemento
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
        d.querySelector('.overlay').classList.remove('show');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $(document).find('[data-error="select"]').removeClass('is-invalid');
        $(document).find('[data-error="textarea"]').removeClass('is-invalid');
        d.getElementById('form').removeAttribute('data-form');
        // let data = $('#pei_objetivos_especificos').DataTable().row($(this).parents('tr') ).data();
        let data = $('#pei_objetivos_especificos').DataTable().row($(e.target).parents('tr') ).data();
        $("#objetivo_institucional").val(data.objetivo_institucional);
        $("#ponderacion").val(data.ponderacion);
        $("#indicador_proceso").val(data.indicador_proceso);
        $("#gerencia_id").val(data.gerencia_id);
        $("#modal .modal-title").text("Editar Objetivo Institucional"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')){
        // let data = $('#pei_objetivos_especificos').DataTable().row($(this).parents('tr') ).data();
        let data = $('#pei_objetivos_especificos').DataTable().row($(e.target).parents('tr') ).data();
        d.querySelector('.message').innerHTML = data.objetivo_institucional;
        $('#modal_delete').modal('show');
    }
})

d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        e.preventDefault();
        if(e.target.hasAttribute('data-form')){
            d.querySelector('.overlay').classList.add('show');
            var datosform = $('#form').serializeArray();
            $.ajax({
                // url:$(this).attr('action'),
                url: `${app_url}/pei_objetivos_especificos/` + mediano_plazo_accion_uuid,
                type: 'POST',
                data: datosform,
                beforeSend:function(resp){
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="select"]').removeClass('is-invalid');
                    $(document).find('[data-error="textarea"]').removeClass('is-invalid');
                },
                success:function(resp){
                    // console.log(resp);
                    $('#pei_objetivos_especificos').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(resp){
                    if(resp.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(resp.responseJSON.errors, function(key, value){
                            // console.log(key);
                            // console.log(value);
                            $('input[id='+ key +']').addClass('is-invalid');
                            $('select[id='+ key +']').addClass('is-invalid'); 
                            $('textarea[id='+ key +']').addClass('is-invalid'); 
                            $('span[id='+key+'-error]').text(value);
                        })
                    }
                }
            })
        }
    }
})