<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP Collaborator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="<?= base_url('css/estilos.css') ?>"> -->

    <!-- Estilos personalizados -->
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Goldman&family=Genos:ital,wght@0,100..900;1,100..900&display=swap');

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            background-color:rgb(243, 241, 238); /* marrón claro */
            font-family: 'Segoe UI', sans-serif;
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
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
            <img src="<?= base_url('/img/logo3.png') ?>" alt="Logo" width="58" height="53" class="me-2">
            <p id="titulonav" class="mb-0 fs-4">PHP Collaborator</p>
        </a>
        <div class="ms-auto">
            <?php if (session()->get('id')): ?> 
                <a href="<?= base_url('/usuarios/logout') ?>" class="btn btn-sm btn-logout">Cerrar sesión</a>
            <?php elseif (session()->get('id_colaborador')): ?>
                <a href="<?= base_url('/colaboradores/logout') ?>" class="btn btn-sm btn-logout">Cerrar sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<!-- Probando Git desde Visual Studio Code -->