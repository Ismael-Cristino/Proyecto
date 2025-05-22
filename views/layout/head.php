<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>APP MVC Y PDO </title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/404.css" rel="stylesheet">

    <link href="assets/css/general.css" rel="stylesheet">
    <link href="assets/css/head.css" rel="stylesheet">
    <link href="assets/css/inicio.css" rel="stylesheet">
    <link href="assets/css/mudanza.css" rel="stylesheet">

    <script src="assets/js/fq.js" defer></script>
    <script src="assets/js/elegirnos.js" defer></script>

    <script src="assets/js/calendario.js" defer></script>
    <script src="assets/js/fulldalendar-6.1.17/dist/index.global.js" defer></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.min.css" rel="stylesheet" />
</head>

<body>
    <header class="navbar sticky-top flex-md-nowrap shadow">
        <a class="navbar-brand col-md-3 col-lg-1 me-0 px-3" href="index.php">Logo</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
            </div>
        </div>

        <nav class="navbarMenu">
            <ul class="nav-listMenu">
                <li class="nav-itemMenu"><a href="index.php">Inicio</a></li>
                <li class="nav-itemMenu">
                    <a href="#">Servicios <i class="fa fa-caret-down"></i></a>
                    <ul class="submenu">
                        <li><a href="index.php?tabla=servicios&accion=mudanza">Mudanzas y otros servicios</a></li>
                        <li><a href="index.php?tabla=servicios&accion=trastero">Trasteros y Guardamuebles</a></li>
                    </ul>
                </li>
                <li class="nav-itemMenu"><a href="index.php?tabla=contacto&accion=ir">Contacto</a></li>
            </ul>
        </nav>

    </header>