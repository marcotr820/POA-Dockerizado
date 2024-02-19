const d = document;
d.addEventListener('change', (e) => {
    if (e.target.matches('#gerencia')) {
        var gerencia_uuid = e.target.value;
        // axios.get('/get_poas_gerencia/' + gerencia_uuid)
        // .then(function (response) {
        //     console.log(response.data);
        // })
        // .catch(function (error) {
        // });
        
        if(gerencia_uuid != ""){
            document.querySelector('.loading').style.display = 'block';
            document.querySelector('.table-loading').classList.remove('show');
             var t = $('#table').DataTable({
                "destroy": true, /*metodo para destruir la tabla que tenemos al inicio y remplazarla por una nueva con nuevos datos*/
                "processing": true,
                "serverSide": true,
                "order": [[0, 'asc']],
                "columnDefs": [
                    {
                        "targets": [ -2 ],
                        "searchable": false,
                        // "orderable": false
                    },
                    {
                        "targets": [ -1 ],
                        "orderable": false
                    }
                ],
                "ajax": {
                    "url": `${app_url}/get_poas_gerencia/` + gerencia_uuid,
                    "type": "GET"
                },
                columns: [
                    { data: 'nombre_unidad', name: 'unidades.nombre_unidad' },
                    {
                        data: 'suma_presupuesto_acciones',
                        render: function (data, type) {
                            if(data == null){
                                var number = $.fn.dataTable.render.number(',', '.', 2, 'Bs ').display(0);
                                return number;
                            } else {
                                var number = $.fn.dataTable.render.number(',', '.', 2, 'Bs ').display(data);
                                return number;
                            }
                        }
                    },
                    {
                        data: 'uuid', name: 'unidades.uuid',
                        render: function (data, type) {
                            return `<a class="boton blue text-center" href="${app_url}/acciones_unidad/${data}">Ver Acciones</a>`;
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
                ],
                "language": {
                    "url": URL
                },
                "initComplete": function( settings, json ) {
                    document.querySelector('.table-loading').classList.add('show');
                    document.querySelector('.loading').style.display = 'none';
                }
            });
            // t.row.add(['1']).draw();
        }

    }
});