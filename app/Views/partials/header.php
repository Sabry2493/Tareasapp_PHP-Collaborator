
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP Collaborator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url('css/estilos.css') ?>"> -->
    <!--para iconos, como candado-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Goldman&family=Genos:ital,wght@0,100..900;1,100..900&display=swap');

        html,body {
            height: auto;
            margin: 0;
            padding: 0;
            background-color:rgb(248, 237, 215); /* marrón claro */
            background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(216, 197, 102));
            
        }
        body { 
            /* background: linear-gradient(to bottom, rgb(236, 235, 225), rgba(194, 175, 67, 0.88));
            background: linear-gradient(to bottom, rgb(255, 255, 255), rgb(216, 199, 114), rgb(151, 149, 149)); */
            font-family: "Genos", sans-serif;
        }
        .navbar {
            background-color: #5e4632; /* marrón oscuro */
            background: linear-gradient(to top, rgba(233, 230, 230, 0.34), rgba(194, 175, 67, 0.88));
            box-shadow: 0 4px 20px rgba(116, 92, 41, 0.2);
            
        }
        #titulonav{
            font-family: "Goldman", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size:1.5rem;
            color:black;
        }
        .navbar-brand, .nav-link, .navbar-text {
            color: #fff !important;
        }
        .btn-logout {
            background-color: #a9744f;
            color: white;
        }
        .btn-logout:hover {
            background-color: #895b3a;
        }
        #enlace{
            text-decoration:none;
            font-size:1.1rem;
        }
        #terminos{
            font-size:1.2rem;
        }
        table{
            box-shadow: -1px 1px 4px 6px rgba(116, 92, 41, 0.2);
        }
        #formcm{
            box-shadow: -1px 1px 4px 6px rgba(116, 92, 41, 0.2);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center"  href="<?php 
       if (session()->get('id')) {
           echo base_url('/tareas/listar');
       } elseif (session()->get('id_colaborador')) {
           echo base_url('/colaboradores/dashboard');
       } else {
           echo base_url('/');
       }
   ?>" >
            <img src="<?= base_url('/img/logo3.png') ?>" alt="Logo" width="58" height="53" class="me-2">
            <p id="titulonav" class="mb-0 fs-4">PHP Collaborator</p>
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <?php if (session()->get('id')): ?> 
                <span class="fw-bold text-dark">Bienvenido, creador <?= esc(session()->get('nombre_usuario')) ?></span>
                <!--nuevo bloque-->
                <?php if (session()->get('tiene_recordatorios')): ?>
                <!-- Ícono de campana con badge --> 
                 <button type="button" class="btn position-relative" style="font-size: 1.5rem;" data-bs-toggle="modal" data-bs-target="#modalRecordatorio" aria-label="Notificaciones">
                        <!-- <i class="bi bi-bell-fill fs-4"></i> -->
                        <i class="fas fa-bell fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                            !
                        </span>      
                </button>
                <?php endif; ?>
                <!-- fin nuevo bloque-->
                <a href="<?= base_url('/usuarios/logout') ?>" class="btn btn-sm btn-logout">Cerrar sesión</a>
            <?php elseif (session()->get('id_colaborador')): ?>
                <span class="fw-bold text-dark">Bienvenido, colaborador <?= esc(session()->get('nombre_colaborador')) ?></span>
                <a href="<?= base_url('/colaboradores/logout') ?>" class="btn btn-sm btn-logout">Cerrar sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<!-- Probando Git desde Visual Studio Code -->