<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    {{-- google font fuente --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!--asset nos posiciona en la carpeta public-->
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/plantilla_style.css')}}">

    {{-- configuraciones css --}}
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/config.css')}}">

    <!--style bootstrap4-->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!--css datatables-->
    <link rel="stylesheet" href="{{asset('libs/datatables/dataTables.bootstrap4.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('libs/datatables/fixedHeader.dataTables.min.css')}}"> --}}

    <!--fontawezome-->
    <link rel="stylesheet" href="{{asset('libs/fontawesome/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/fontawesome/fontawesome.min.css')}}">

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{asset('libs/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    {{-- x-select --}}
    <link rel="stylesheet" href="{{asset('libs/plugins/x-select/x-select.css')}}">

    {{-- x-table --}}
    <link rel="stylesheet" href="{{asset('libs/plugins/x-table/x-table.css')}}">

    {{-- toastr --}}
    <link rel="stylesheet" href="{{asset('libs/plugins/toastr/toastr.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('libs/plugins/toastr/toastr.css')}}"> --}}

    @yield('css')

</head>
<body class="body-fondo">
    <div class="main-wrapper">
        
            <!-- Loader -->
			<div id="loader-wrapper">
				<div id="loader">
					<div class="loader-ellips">
                        {{-- <i class="fas fa-2x fa-circle-notch fa-spin text-light"></i> --}}
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
					  {{-- <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span> --}}
					</div>
				</div>
			</div>
			<!-- /Loader -->

        <div class="sidebar">
            {{-- sidebar logo --}}
            <div class="logo-details d-flex justify-content-center">
                <div class="image">
                    <img src="{{asset('libs/img/logo_gota_agua.png')}}" alt="">
                </div>
                <span class="logo_name font-weight-bold">Elapas | <small>POA</small></span>
            </div>

            {{-- sidebar-list --}}
            <div class="sidebar-list">
                <ul>
                    @can('SUPER-ADMIN')
                        <li class="bloque">
                            <a class="titulo">
                                <i class="fas fa-user-cog"></i>
                                <span class="pl-2">Administración</span>
                                <i class="fas fa-chevron-down Arrow"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{route('trabajadores.index')}}" class="pl-4"><span class="pl-2">Trabajadores</span></a></li>
                                <li><a href="{{route('usuarios.index')}}" class="pl-4"><span class="pl-2">Usuarios</span></a></li>
                                <li><a href="{{route('roles.index')}}" class="pl-4"><span class="pl-2">Roles</span></a></li>
                                <li><a href="{{route('permissions.index')}}" class="pl-4"><span class="pl-2">Permisos</span></a></li>
                                <li><a href="{{route('gerencias.index')}}" class="pl-4"><span class="pl-2">Gerencias</span></a></li>
                                <li><a href="{{route('unidades.index')}}" class="pl-4"><span class="pl-2">Unidades</span></a></li>
                            </ul>
                        </li>
                    @endcan
                    
                    @can('VER-POA')
                        @if (Auth::guard('usuario')->Check())
                            {{-- @if (Auth::guard('usuario')->user()->trabajador->poa_status === '1') --}}
                                <li class="bloque">
                                    <a href="{{route('poa.index')}}" class="titulo">
                                        <i class="far fa-chart-bar"></i>
                                        <span class="pl-2">Formular POA</span>
                                    </a>
                                </li>
                            {{-- @endif --}}
                        @endif
                    @endcan

                    @can('VER-DIRECTRIZ')
                        <li class="bloque">
                            <a class="titulo">
                                <i class="fas fa-sitemap"></i>
                                <span class="pl-2">Directriz</span>
                                <i class="fas fa-chevron-down Arrow"></i>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{route('pilares.index')}}" class="pl-4"></i><span class="pl-2">Pilares</span></a></li>
                                <li><a href="{{route('directriz.index')}}" class="pl-4"></i><span class="pl-2">Reporte Directriz</span></a></li>
                                <li><a href="{{route('partidas.index')}}" class="pl-4"></i><span class="pl-2">Partidas</span></a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('VER-ESTADOS-TRABAJADORES')
                    <li class="bloque">
                        <a href="{{route('estados_trabajadores.index')}}" class="titulo">
                            <i class="fas fa-users"></i>
                            <span class="pl-2">Estados Trabajadores</span>
                        </a>
                    </li>
                    @endcan
                    
                    @can('VER-ESTADOS-POA')
                    <li class="bloque">
                        <a href="{{route('admin_poa.index')}}" class="titulo">
                            <i class="fas fa-stream"></i>
                            <span class="pl-2">Administrar Estados POA</span>
                            <span class="badge badge-primary badge-pill" id="notificacion"></span>
                            {{-- <span class="badge" id="notificacion"></span> --}}
                        </a>
                    </li>
                    @endcan

                    <li class="bloque">
                        <a href="{{route('poa.ver_poas')}}" class="titulo">
                            <i class="far fa-folder-open"></i>
                            <span class="pl-2">Ver Poas Detalle Unidad</span>
                        </a>
                    </li>

                    @can('VER-PRESUPUESTOS-REQUERIDOS')
                    <li class="bloque">
                        <a href="{{route('index.presupuestos')}}" class="titulo">
                            <i class="far fa-calendar-check"></i>
                            <span class="pl-2">Presupuestos Requeridos</span>
                        </a>
                    </li>
                    @endcan

                    @can('VER-PLANIFICACION-EVALUACION-POA')
                    <li class="bloque">
                        <a href="{{route('planificacion_evaluacion')}}" class="titulo">
                            <i class="fas fa-boxes"></i>
                            <span class="pl-2">Planificacion y Evaluacion POA</span>
                        </a>
                    </li>
                    @endcan

                    @can('VER-PLANIFICACION')
                    <li class="bloque">
                        <a href="{{route('acciones_corto_plazo.planificacion')}}" class="titulo">
                            <i class="fas fa-boxes"></i>
                            <span class="pl-2">Planificación POA</span>
                        </a>
                    </li>
                    @endcan

                    @can('VER-EVALUACION')
                    <li class="bloque">
                        <a href="{{route('acciones_corto_plazo.evaluacion')}}" class="titulo">
                            <i class="fas fa-award"></i>
                            <span class="pl-2">Evaluación POA</span>
                        </a>
                    </li>
                    @endcan

                    

                    @can('VER-POA-UNIDADES-GERENCIA')
                    <li class="bloque">
                        <a href="{{route('poas.gerencia')}}" class="titulo">
                            <i class="fas fa-address-card"></i>
                            <span class="pl-2">POA Gerencia</span>
                        </a>
                    </li>
                    @endcan

                    @can('CONSOLIDAR-POA')
                    <li class="bloque">
                        <a href="{{route('consolidar.poa.index')}}" class="titulo">
                            <i class="far fa-star"></i>
                            <span class="pl-2">Consolidar POA</span>
                        </a>
                    </li>
                    @endcan

                </ul>
            </div>
        </div>

        <div class="main">
            <!--*****************CABEZA MENU**********************-->
            <div class="topbar">
                <div class="toggle d-inline-flex" id="toggle">
                    <i class="fas fa-bars"></i>
                </div>

                {{-- @role('ADMIN')
                    <p class="btn btn-danger btn-sm">ADMIN</p>
                @endrole
                @role('PLANIFICADOR')
                    <p class="btn btn-danger btn-sm">PLANIFICADOR</p>
                @endrole
                @role('TRABAJADOR')
                    <p class="btn btn-danger btn-sm">TRABAJADOR</p>
                @endrole --}}

                {{-- <span class="badge badge-secondary">{{ auth('usuario')->user()->roles }}</span> --}}
    
                {{-- DROP DOWN PERFIL CERRAR SESION --}}
                <div class="perfil">
                    <img src="{{asset('libs/img/icon-user.png')}}" alt="">
                    <ul class="link-perfil">
                        <li>
                            <div class="data-session">
                                <p class="m-0">Iniciado sesión como:</p class="m-0">
                                {{-- <p class="m-0"><strong>{{Auth::guard('usuario')->user()->trabajador->nombre}}</strong></p> --}}
                                <p class="m-0"><strong>{{ strtolower(auth('usuario')->user()->trabajador->nombre) }}</strong></p>
                                <hr class="bg-dark my-1">
                                <p class="m-0">Roles:</p>
                                @foreach (auth('usuario')->user()->roles as $rol)
                                    <p class="m-0"><strong>* {{ ucfirst(strtolower($rol->name)) }}</strong></p>
                                @endforeach
                            </div>
                        </li>
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <!--usamos JS para que al momento de dar click en el enlace se envie el formulario
                                y asi no tendremos que usar un boton ripo submit-->
                                <a onclick="this.closest('form').submit()"><i class="fas fa-sign-out-alt"></i> Cerrar sesión </a>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
            
            <!--*********** inicio del contenido_menu del CUERPO ***********-->
            <div class="contenido_pagina">
                
                @yield('contenido')
                
            </div><!--************ div QUE TERMINA EL CONTENIDO DEL CUERPO DE LA PAGINA ***************-->

            <footer class="footer class="align-middle">
               <span class="text-muted">Sistema POA {{ date('Y') }}</span>
            </footer>

            {{-- ****** scroll topboton para subir hacia arriba *****--}}
            <div class="scroll-top ocultar-btn">
               <i class="fas fa-angle-up"></i>
            </div>

        </div><!--DIV QUE TERMINA EL MAIN-->

    </div>

    <script>

        const app_url = "{{ config('app.url') }}";

    </script>

    <!--incluimos el archivo jquery-->
    <script src="{{asset('libs/datatables/jquery-3.6.0.min.js')}}"></script>

    <!--js de la plantilla-->
    <script src="{{asset('libs/js/plantilla.js')}}"></script>

    <!--script bootstrap-->
    <script src="{{asset('js/app.js')}}"></script>

    <!--js datatables-->
    <script src="{{asset('libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('libs/datatables/dataTables.bootstrap4.min.js')}}"></script>

    {{-- js para mostrar las notificaciones al cargar la pagina --}}
    <script src="{{asset('libs/js/notificacion.js')}}"></script>

    {{-- Select2 --}}
    <script src="{{asset('libs/plugins/select2/js/select2.full.min.js')}}"></script>

    {{-- x-select --}}
    <script src="{{asset('libs/plugins/x-select/x-select.js')}}"></script>

    {{-- toastr --}}
    <script src="{{asset('libs/plugins/toastr/toastr.min.js')}}"></script>

   @yield('js')

</body>
</html>