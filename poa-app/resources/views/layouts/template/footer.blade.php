             
             </div><!--div QUE TERMINA EL CONTENIDO DEL CUERPO DE LA PAGINA-->

             <footer class="pie">
                <p>SISTEMA POA 2021</p>
           </footer>

           <div class="scroll-to-top">
                <i class="fas fa-angle-up"></i>
           </div>

        </div><!--DIV QUE TERMINA EL MAIN-->

    </div>

    <!--incluimos el archivo jquery-->
    <script src="{{asset('libs/datatables/jquery-3.6.0.min.js')}}"></script>

    <!--js de la plantilla-->
    <script src="{{asset('libs/js/plantilla.js')}}"></script>

    <!--script bootstrap-->
    <script src="{{asset('js/app.js')}}" defer></script>

    <!--js datatables-->
    <script src="{{asset('libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('libs/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>

    <script>
        $('#example').DataTable({
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "Ningun registro encontrado",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
        });
//================================== Header de la tabla fijo =================================
// var table = $('#example').DataTable( {
//         responsive: true,
//         paging: true,
//         "language": {
//             "lengthMenu": "Mostrar _MENU_ registros por pagina",
//             "zeroRecords": "Ningun registro encontrado",
//             "info": "Mostrando pagina _PAGE_ de _PAGES_",
//             "infoEmpty": "No hay registros disponibles",
//             "infoFiltered": "(filtrado de _MAX_ registros totales)",
//             "search": "Buscar:",
//             "paginate": {
//                 "next": "Siguiente",
//                 "previous": "Anterior"
//             }
//         }
//     } );
 
//     new $.fn.dataTable.FixedHeader( table );


    </script>
</body>
</html>