const d = document;
$('.js-example-basic-single').select2();
function update(accion_uuid){
    d.getElementById('form').onsubmit = function (e){
        e.preventDefault();
        d.querySelector('.overlay').classList.add('show');
        let datosform = $(e.target).serializeArray();
        $.ajax({
            url: `${app_url}/update_status_corto_plazo_accion/`+ accion_uuid,
            type: 'PUT',
            data: datosform,
            success:function(resp){
                // console.log(resp);
                $('#modal').modal('hide');
                $('#table').DataTable().ajax.reload(null, false);
                // contamos las acciones que tengan un status 1 para mostrarlos como notificacion en el sidebar
                axios.get(`${app_url}/notificacion`)
                .then(function(response){
                    if(response.data === 0){
                        d.getElementById('notificacion').setAttribute('hidden', true);
                    }else{
                        d.getElementById('notificacion').removeAttribute('hidden');
                        d.getElementById('notificacion').innerHTML = response.data;
                    }
                })
                .catch(function(error){
                    // console.log(error);
                });
            }
        })
    }
    
}

// EVENTO CHANGE CAMBIO
$('.select2').on('select2:select', function (e) {
    var data = e.params.data;
    // console.log(data.uuid);
    var obj_uuid = data.uuid;
        axios.get(`${app_url}/data_pei/` + obj_uuid)
        .then(function (resp) {
            d.querySelector('.objetivo_especifico').innerHTML = resp.data.objetivo_institucional;
            d.querySelector('.gerencia').textContent = resp.data.nombre_gerencia;
        })
        .catch(function (error) {
        });

        $('#table').DataTable({
            "destroy": true, /*metodo para destriur la tabla que tenemos al inicio y remplazarla por una nueva con nuevos datos*/
            "processing": true,
            "serverSide": true,
            "ajax": {
               "url": `${app_url}/listar_acciones/`+obj_uuid,
               "type": "GET"
            },
            columns: [
                { data: 'accion_corto_plazo', name:'accion_corto_plazo'},
                { 
                    data: 'presupuesto_programado',
                    render: function(data, type, row) {
                    var number = $.fn.dataTable.render.number( ',', '.', 2, 'Bs ').display(data);
                        return number;
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        switch(data){
                            case 'editar': 
                                return `<span class="badge badge-primary p-1"><b>EDICION</b></span>`;
                            break;

                            case 'presentado': 
                                return `<span class="badge badge-danger p-1">PRESENTADO</span>`;
                            break;

                            case 'aprobado': 
                                return `<span class="badge badge-success p-1">APROBADO</span>`;
                            break;

                            case 'monitoreo': 
                                return `<span class="badge badge-warning p-1">MONITOREO</span>`;
                            break;
                        }
                    }
                },
                { 
                    data: 'uuid',
                    render: function(data, type, row) {
                        switch(row.status){
                            case 'editar': 
                                return `<button class="boton blue" data-accion="" onclick="update('${data}')"><i class="fas fa-cogs"></i></button>`;
                            break;

                            case 'presentado': 
                                return `<button class="boton red" data-accion="" onclick="update('${data}')"><i class="fas fa-cogs"></i></button>`;
                            break;

                            case 'aprobado':
                                return `<button class="boton green" data-accion="" onclick="update('${data}')"><i class="fas fa-cogs"></i></button>`;
                            break;

                            case 'monitoreo':
                                return `<button class="boton default" data-accion="" onclick="update('${data}')"><i class="fas fa-cogs"></i></button>`;
                            break;

                            // default: return `<button class="btn btn-primary btn-sm" data-accion="" onclick="update('${data}')"><i class="fas fa-cogs"></i></button>`;
                        }
                    }
                }
            ],
            "drawCallback": function(){
                var api = this.api();
                var json = api.ajax.json();
                $( api.column(0).footer() ).html('<h5 style="margin:0;"><b>Total Ppto. Programado:</b> ' + json.total_programado + ' Bs.</h5>');
            },
            "columnDefs": [
                {
                    "targets": -1, // your case last column
                    "className": "text-center",
                    // "width": "4%"
                }
            ]
        });
});

// EVENTO CLICK
d.addEventListener('click', (e)=>{
    if(e.target.matches('[data-accion]') || e.target.matches('[data-accion] *')){
        d.querySelector('.overlay').classList.remove('show');
        let data = $('#table').DataTable().row($(e.target).parents('tr') ).data();
        axios.get(`${app_url}/status_corto_plazo_accion/` + data.uuid) //enviamos todos los input del form
        .then(function (resp) {
            d.getElementById('accion_corto_plazo').textContent = resp.data.accion_corto_plazo;
            const presupuesto = resp.data.presupuesto_programado.toLocaleString('es-MX');
            d.getElementById('presupuesto_accion').textContent = presupuesto;
            d.getElementById('status').value = resp.data.status;
            $("#modal").modal("show");
        })
        .catch(function (error) {
        });
    }
});