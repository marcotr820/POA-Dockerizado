@extends('layouts.plantillabase')
@section('contenido')
    <style>
        .modal-dialog .overlay {
            display: -ms-flexbox;
            display: flex;
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
            margin: -1px;
            z-index: 1052;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.7);
            color: #ddd;
            border-radius: 0.3rem;
        }

        .x-dropdown {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }
        .x-dropdown .x-dropdown-button {
            display: inline-block;
            vertical-align: middle;
            overflow: hidden;
        }
        .x-dropdown .x-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            /* display: none; */
            /* float: left; */
            min-width: 7.8rem;
            max-width: 7.8rem;
            margin: 0;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid;
            border-radius: 5px;
            /* el overflow hiden no permite que los border de los hijos sobresalgan de esta caja y los oculta */
            overflow: hidden;
        }
        .x-dropdown .x-dropdown-menu.show{
          display: block;
        }
        .x-dropdown .x-dropdown-menu li{
          padding: 3px;
          border-bottom: 1px solid #808080;
          font-size: 0.8rem;
        }
        .x-dropdown .x-dropdown-menu li:hover{
          background-color: #004d99;
          color: #fff;
          cursor: pointer;
        }
        .x-dropdown .menu-right {
            right: 0;
            left: auto;
        }

    </style>
    <h4>hack principal</h4>
    <!--mostramos los datos del usuario autenticado-->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-overlay">
        Launch Modal with Overlay
    </button>

    <div class="modal fade" id="modal-overlay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay show">
                    <i class="fas fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <hr>

    <div class="card border-dark">
        <div class="card-header border-dark">
            Featured
            <a href="" class="boton blue">Enlace</a>
            <button class="boton blue">Button</button>
        </div>
        <div class="card-body">
            <a href="" class="boton red">Enlace</a>

            <div class="x-dropdown">
                <button class="boton red x-dropdown-button">Button</button>
                <ul class="x-dropdown-menu menu-right">
                    <li>Operaciones Tareas</li>
                    <li>Requerimientos</li>
                </ul>
            </div>

        </div>
    </div>

    <hr>

    <a href="" class="btn btn-primary">Enlace</a>
    <button class="btn btn-primary">Button</button>
    <span class="btn btn-primary">Span</span>
    <div class="btn btn-primary">Div</div>

    <hr>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
          Dropdown button
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="dasd4545">Action</a>
          <a class="dropdown-item" href="dasd4545">Another action</a>
          <a class="dropdown-item" href="dasd4545">Something else here</a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        console.log("se cargo el contenido de la pagina principal");
        $('#example').DataTable();

        // toastr["success"]("My name is Inigo Montoya. You killed my father. Prepare to die!");
        // toastr["error"]("Are you the six fingered man?");
        // toastr["warning"]("Inconceivable!");
    </script>
@endsection
