const d = document;
d.addEventListener('click', (e) => {
    if (e.target.matches('[data-accion]')) {
        // let data = tabla_poa.row($(this).parents('tr') ).data();
        let data = $('#poa').DataTable().row($(e.target).parents('tr')).data();
        location.href = `${app_url}/pei_objetivos_especifico/${data.uuid}/corto_plazo_acciones`;
    }
})

d.addEventListener('change', (e) => {
    if (e.target.matches('#select_gerencia')) {
        gerencia_uuid = e.target.value;
        axios.get('/obtener_unidades/' + gerencia_uuid)
            .then(function (response) {
                var html_select = '<option value="" hidden>Selecciones...</option>';
                response.data.forEach((element) => {
                    html_select += `<option value="${element.uuid}">${element.nombre_unidad}</option>`;
                });
                d.getElementById('select_unidad').innerHTML = html_select;
            })
            .catch(function (error) {

            });
    }

    if(e.target.matches('#select_unidad')){
        
    }
});