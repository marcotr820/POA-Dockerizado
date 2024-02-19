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

function edit(id){
   d.getElementById('form').onsubmit = function(e){
      if(! e.target.hasAttribute('data-form')){
         let datosform = $(e.target).serializeArray();
         d.querySelector('.overlay').classList.add('show');
         $.ajax({
            url: `${app_url}/permissions/` + id,
            type: 'put', 
            data: datosform,  
            success:function(resp){
               $("#permisos").DataTable().ajax.reload(null, false);
               $('#modal').modal('hide');
            },
            error:function(resp){
               d.querySelector('.overlay').classList.remove('show');
               if(resp.responseJSON.hasOwnProperty('errors')){
                  $.each(resp.responseJSON.errors, function(key, value){
                      $('input[name='+ key +']').addClass('is-invalid'); 
                     //  console.log(key);
                     //  console.log(value);
                      $('span[id='+key+'-error]').text(value);
                  })
               }
            }
         })
      }
   }
}

d.addEventListener('click', (e)=>{
   if(e.target.matches('#nuevo') || e.target.matches('#nuevo *')){
      d.querySelector('.overlay').classList.remove('show');
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.getElementById('form').reset();
      d.querySelector('.modal-title').textContent = 'Registrar Permiso';
      d.getElementById('form').setAttribute('data-form', '');
      $('#modal').modal('show');
   }

   if(e.target.matches('[data-edit]') || e.target.matches('[data-edit] *')){
      d.querySelector('.overlay').classList.remove('show');
      d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
      d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
      d.getElementById('form').removeAttribute('data-form');
      d.querySelector('.modal-title').textContent = 'Editar Permiso';
      let data = $('#permisos').DataTable().row($(e.target).parents('tr') ).data();
      d.getElementById('nombre_permiso').value = data.name;
      $('#modal').modal('show');
   }
})

// envio formulario
d.addEventListener('submit', (e)=>{
   if(e.target.matches('form')){
      e.preventDefault();
      if(e.target.hasAttribute('data-form')){
         d.querySelector('.overlay').classList.add('show');
         let datosform = $(e.target).serializeArray();
         $.ajax({
            url: `${app_url}/permissions`,
            type: 'post', 
            data: datosform,  
            success:function(resp){
               $("#permisos").DataTable().ajax.reload(null, false);
               $('#modal').modal('hide');
            },
            error:function(resp){
               d.querySelector('.overlay').classList.remove('show');
               if(resp.responseJSON.hasOwnProperty('errors')){
                  $.each(resp.responseJSON.errors, function(key, value){
                      $('input[name='+ key +']').addClass('is-invalid'); 
                     //  console.log(key);
                     //  console.log(value);
                      $('span[id='+key+'-error]').text(value);
                  })
               }
            }
         })
      }
   }

   if(e.target.matches('[data-delete]')){
      e.preventDefault();
      let data = $('#permisos').DataTable().row($(e.target).parents('tr') ).data();
      let datosform = $(e.target).serializeArray();
      Swal.fire({
         html: "Desea Eliminar El Registro? <br>" + data.name,
         width: '20%',
         showCancelButton: true,
         confirmButtonColor: '#d33',
         confirmButtonText: 'Si eliminar',
         cancelButtonText: 'Cancelar'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: `${app_url}/permissions/` + data.id,
               type: 'delete', 
               data: datosform,  
               success:function(resp){
                  $("#permisos").DataTable().ajax.reload(null, false);
               },
               error:function(){
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