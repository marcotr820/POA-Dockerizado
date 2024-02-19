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

function edit(unidad_uuid){
    d.getElementById('form').onsubmit = function(e){
        if(! e.target.hasAttribute('data-form')){
            e.preventDefault();
            let datosform = $(e.target).serializeArray();
            $.ajax({
                url: `${app_url}/unidades/` + unidad_uuid,
                type: 'PUT',
                data: datosform,
                beforeSend:function(){
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="select"]').removeClass('is-invalid');
                    d.querySelector('.overlay').classList.add('show');
                },
                success:function(res){
                    $('#unidades').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(respuesta){
                    if(respuesta.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(respuesta.responseJSON.errors, function(key, value){
                            $('input[id='+ key +']').addClass('is-invalid'); 
                            $('select[id='+ key +']').addClass('is-invalid'); 
                            // console.log(key);
                            // console.log(value);
                            $('span[id='+key+'-error]').text(value);
                        })
                    }
                }
            })
        }
    }
}

// evento click
d.addEventListener('click', (e)=>{
    if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
        d.querySelector('.overlay').classList.remove('show');
        d.getElementById('form').setAttribute('data-form', '');
        d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
        d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
        d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
        $("#form").trigger("reset");
        $("#modal .modal-title").text("Nueva Unidad"); 
        $("#modal").modal("show");
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
        d.querySelector('.overlay').classList.remove('show');
        d.getElementById('form').removeAttribute('data-form');
        d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
        d.querySelectorAll('[data-error="select"]').forEach((el)=>{ el.classList.remove('is-invalid') });
        d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
        // let data = $('#unidades').DataTable().row($(this).parents('tr') ).data();
        let data = $('#unidades').DataTable().row($(e.target).parents('tr') ).data();
        d.getElementById('nombre_unidad').value = data.nombre_unidad;
        d.getElementById('gerencia_id').value = data.gerencia_id;
        $("#modal .modal-title").text("Editar Unidad"); 
        $("#modal").modal("show");
    }
})

// evento submit
d.addEventListener('submit', (e)=>{
    if(e.target.matches('form')){
        if(e.target.hasAttribute('data-form')){
            e.preventDefault();
            let datosform = $(e.target).serializeArray();
            $.ajax({
                // url:$(this).attr('action'),
                url: `${app_url}/unidades`,
                type: 'POST',
                data: datosform,
                beforeSend:function(resp){
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                    $(document).find('[data-error="select"]').removeClass('is-invalid');
                    d.querySelector('.overlay').classList.add('show');
                },
                success:function(resp){
                    $('#unidades').DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(resp){
                    if(resp.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(resp.responseJSON.errors, function(key, value){
                            $('input[id='+ key +']').addClass('is-invalid'); //añadimos la clase is-invalid a los errores input
                            $('select[id='+ key +']').addClass('is-invalid'); //añadimos la clase is-invalid a los errores select
                            // console.log(key);
                            // console.log(value);
                            $('span[id='+key+'-error]').text(value);
                        })
                    }
                }
            })
        }
    }

    if(e.target.matches('[data-formdelete]')){
        e.preventDefault();
        let data = $('#unidades').DataTable().row($(e.target).parents('tr') ).data();
        let datosform = $(e.target).serializeArray();
        Swal.fire({
            html: "Desea Eliminar el Registro : <br> <u><b>"+data.nombre_unidad+"</b></u>",
            width: '20%',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Si eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${app_url}/unidades/` + data.uuid,
                    type: 'delete', 
                    data: datosform,  
                    success:function(resp)
                    {
                        $('#unidades').DataTable().ajax.reload(null, false);
                    },
                    error:function()
                    {
                        Toast.fire({
                            padding: '6px',
                            width: '320px',
                            icon: 'error',
                            title: 'Error al realizar la acción'
                        })
                    }
                })
            }
        })
    }
})