document.addEventListener('submit', (e) => {
   if (e.target.matches('#form')) {
      e.preventDefault();
      let datosForm = new FormData(e.target);
      document.querySelectorAll('[data-error="input"]').forEach( (el) => { el.classList.remove('is-invalid') });
      document.querySelectorAll('[data-error="span"]').forEach( (el) => { el.textContent = '' });
      document.getElementById("btn-login").disabled = true;
      document.getElementById("btn-login").textContent = "Cargando...";
      document.getElementById("alertError").style.display = "none";
      axios.post(`${app_url}/autenticacion`, datosForm) //enviamos todos los input del form
         .then(function (response) {
            // console.log(response);
            window.location.href = "/index";
         })
         .catch(function (error) {
            console.log(error.response);
            document.getElementById("btn-login").textContent = "Ingresar";
            document.getElementById("btn-login").disabled = false;

            if (error.response.data.message && error.response.status === 401) {
               document.getElementById("alertError").textContent = error.response.data.message;
               document.getElementById("alertError").style.display = "block";
               return;
            }
            
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
               for (let key in objeto) {
                  //console.log(key);
                  //console.log(errores[key]);
                  //key nombre del campo ej. nombre_operacion
                  //objeto[key] valor ej. "El campo nombre operacion es obligatorio. SU VALOR"
                  document.getElementById(key).classList.add('is-invalid');
                  document.getElementById(key + '-error').textContent = objeto[key];
               }
            }
         });
   }
})