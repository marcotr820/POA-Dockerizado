const d = document;

//CAMBIAR ESTADO POA
d.addEventListener('change', (e)=>{
    if(e.target.matches('[data-crear]')){
        let data = $('#estados_trabajadores').DataTable().row($(e.target).parents('tr') ).data();
        axios.put(`${app_url}/estados_trabajadores/poa_status/` + data.uuid)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }

    if(e.target.matches('[data-evaluar]')){
        let data = $('#estados_trabajadores').DataTable().row($(e.target).parents('tr') ).data();
        axios.put(`${app_url}/estados_trabajadores/poa_evaluacion/` + data.uuid)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }
});

// EVENTO CLICK
d.addEventListener('click', (e)=>{
    if(e.target.matches('[data-habilitar="creacion"]')){
        axios.get(`${app_url}/estados_trabajadores/habilitar_creacion_all`)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }

    if(e.target.matches('[data-deshabilitar="creacion"]')){
        axios.get(`${app_url}/estados_trabajadores/deshabilitar_creacion_all`)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }

    // EVALUACION POA
    if(e.target.matches('[data-habilitar="evaluacion"]')){
        axios.post(`${app_url}/estados_trabajadores/habilitar_evaluacion_all`)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }

    if(e.target.matches('[data-deshabilitar="evaluacion"]')){
        axios.post(`${app_url}/estados_trabajadores/deshabilitar_evaluacion_all`)
        .then(function (resp) {
            $('#estados_trabajadores').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
        });
    }
})