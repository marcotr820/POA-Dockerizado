<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--asset nos posiciona en la carpeta public-->
    <link rel="stylesheet" type="text/css" href="{{asset('libs/css/style.css')}}">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!--style bootstrap4-->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!--css datatables-->
    <link rel="stylesheet" href="{{asset('libs/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap4.min.css">

    <!--fontawezome-->
    <link rel="stylesheet" href="{{asset('libs/fontawesome/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/fontawesome/fontawesome.min.css')}}">
</head>
<body>
    <div class="contenedor">
        <div class="navigation">
            <div class="logo-details">
                <i class="bx bxl-c-plus-plus"></i>
                <span class="logo_name">logo name</span>
            </div>

            <div class="acordeon">
                <div class="bloque">
                    <a class="titulo">
                        <i class="icono izq fas fa-address-card"></i>
                        hack
                        <i class="icono der fas fa-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href=""><i class="fas fa-book"></i>soy contenido</a></li>
                        <li><a href=""><i class="fas fa-book"></i>soy contenido</a></li>
                        <li><a href=""><i class="fas fa-book"></i>soy contenido</a></li>
                        <li><a href=""><i class="fas fa-book"></i>soy contenido</a></li>
                    </ul>
                </div>
                <div class="bloque">
                    <a class="titulo">
                        <i class="icono izq fas fa-address-card"></i>
                        youtube
                        <i class="icono der fas fa-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href=""><i class="fas fa-book"></i>soy contenido</a></li>
                    </ul>
                </div>
                <div class="bloque">
                    <a class="titulo">
                        <i class="icono izq fas fa-address-card"></i>
                        facebook
                    </a>
                </div>
            </div>

        </div>

        <div class="main">
            <!--*****************CABEZA MENU**********************-->
            <div class="topbar">
                <div class="toggle" onclick="toggleMenu();">
                    <i class="fas fa-bars"></i>
                </div>

                <nav class="navbar navbar-expand-lg">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <span class="">Administrador</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>

                        <form action="/logout" method="POST">
                            @csrf
                            <!--usamos JS para que al momento de dar click en el enlace se envie el formulario
                            y asi no tendremos que usar un boton ripo submit-->
                            <a class="dropdown-item" href="#" onclick="this.closest('form').submit()">Cerrar Sesion</a>
                        </form>
                    </div>
                </nav>

            </div>
            
            <!--*****************inicio del contenido_menu del CUERPO**********************-->
            <div class="contenido_pagina">