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

function edit(gerencia_uuid){
    d.getElementById('form').onsubmit = function(e){
        e.preventDefault();
        if(! e.target.hasAttribute('data-form')){
            let datosform = $(e.target).serializeArray();
            $.ajax({
                url: `${app_url}/gerencias/` + gerencia_uuid,
                type: 'PUT',
                data: datosform,
                beforeSend:function(){
                    d.querySelector('.overlay').classList.add('show');
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                },
                success:function(res){
                    $("#gerencias").DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(resp){
                    if(resp.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(resp.responseJSON.errors, function(key, value){
                            $('input[id='+ key +']').addClass('is-invalid'); 
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
        $("#form").trigger("reset");
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        d.getElementById('form').setAttribute('data-form', '');
        $("#modal .modal-title").text("Nueva Gerencia"); 
        $('#modal').modal('show');
    }

    if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
        d.querySelector('.overlay').classList.remove('show');
        d.getElementById('form').removeAttribute('data-form');
        $(document).find('[data-error="span"]').text('');
        $(document).find('[data-error="input"]').removeClass('is-invalid');
        $("#modal .modal-title").text("Editar Gerencia"); 
        // let data = $("#gerencias").DataTable().row($(this).parents('tr') ).data();
        let data = $("#gerencias").DataTable().row($(e.target).parents('tr') ).data();
        d.getElementById('nombre_gerencia').value = data.nombre_gerencia;
        $('#modal').modal('show');
    }

    if(e.target.matches('[data-delete]') || e.target.matches('[data-delete] *')){
        let data = $("#gerencias").DataTable().row($(e.target).parents('tr') ).data();
        let datosform = $('#form').serializeArray();
        
    }
})

// evento submit
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        e.preventDefault();
        if(e.target.hasAttribute('data-form')){
            let datosform = $(e.target).serializeArray();
            $.ajax({
                // url:$(this).attr('action'), //{{route('gerencias.store')}}
                url: `${app_url}/gerencias`,
                type: 'POST',
                data: datosform,
                beforeSend:function(resp){
                    d.querySelector('.overlay').classList.add('show');
                    $(document).find('[data-error="span"]').text('');
                    $(document).find('[data-error="input"]').removeClass('is-invalid');
                },
                success:function(resp){
                    $("#gerencias").DataTable().ajax.reload(null, false);
                    $("#modal").modal("hide");
                },
                error:function(resp){
                    if(resp.responseJSON.hasOwnProperty('errors')){
                        d.querySelector('.overlay').classList.remove('show');
                        $.each(resp.responseJSON.errors, function(key, value){
                            $('input[id='+ key +']').addClass('is-invalid');
                            $('span[id='+key+'-error]').text(value);
                        })
                    }
                }
            })
        }
    }

    if(e.target.matches('[data-formdelete]') || e.target.matches('[data-formdelete] *')){
        e.preventDefault();
        var datosform = $(e.target).serializeArray();
        let data = $("#gerencias").DataTable().row($(e.target).parents('tr') ).data();
        Swal.fire({
            html: "Desea Eliminar El Registro: <br> <u><b>"+data.nombre_gerencia+"</b></u>",
            width: '20%',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Si eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${app_url}/gerencias/` + data.uuid,
                    type: 'Delete', 
                    data: datosform,  
                    success:function(resp)
                    {
                        $("#gerencias").DataTable().ajax.reload(null, false);
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