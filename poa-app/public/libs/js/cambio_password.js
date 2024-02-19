const d = document;
const inputs = d.querySelectorAll('#form input');

const expresion = /^[a-zA-Z0-9\_\-]{0,20}$/; //expresion regular letras, numeros, guiones
const validar_campo = (expre, input, campo)=>{
    if(expre.test(input.value)){
        d.getElementById(`${campo}`).classList.remove('is-invalid');
        d.getElementById(`${campo}`).classList.add('is-valid');
        // d.getElementById(`${campo}-error`).style.display = 'none';
    }else{
        d.getElementById(`${campo}`).classList.remove('is-valid');
        d.getElementById(`${campo}`).classList.add('is-invalid');
        // d.getElementById(`${campo}-error`).style.display = 'block';
    }
}

const validar_formulario = (e)=>{
    switch (e.target.id){
        case 'password':
            validar_campo(expresion, e.target, 'password');
        break;
    }
}

inputs.forEach((el)=>{
    el.addEventListener('keyup', validar_formulario);
    // el.addEventListener('blur', validar_formulario);
})

// EVENTO SUBMIT
d.addEventListener('submit', (e)=>{
    if(e.target.matches('#form')){
        e.preventDefault();
        d.querySelectorAll('[data-error="input"]').forEach((el)=>{ el.classList.remove('is-invalid') });
        d.querySelectorAll('[data-error="span"]').forEach((el)=>{ el.textContent = '' });
        axios.put(`${app_url}/update_password/`+ usuario_uuid,{
            password: d.getElementById('password').value,
            password_confirm: d.getElementById('password_confirm').value
        })
        .then(function (resp){
            location.href= `${app_url}/usuarios`;
        })
        .catch(function (error){
            // console.log(error.response.data.errors);
            const objeto = error.response.data.errors; //creamos el objeto para luego recorrerlo
            if (error.response.data.hasOwnProperty('errors')) //preguntamos si exite la propiedad donde se almacenan los errores false/true
            {
                for (let key in  objeto) 
                {
                    //key: llave    objeto[key]: valor respuesta
                    d.getElementById(key).classList.add('is-invalid');
                    d.getElementById(key+'-error').textContent = objeto[key];
                }
            }
        })
    }
})