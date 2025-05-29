<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP Collaborator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Goldman&family=Genos:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            background: url('<?= base_url('/img/fondo.jpg') ?>') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            font-family: "Genos", sans-serif;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6); /* oscuro translúcido */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card-custom {
            background-color: #f5f0eb; /* marrón claro */
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            color: #333;
            text-align: center;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
        }

        .btn-dark-custom {
            background-color: #2c2c2c;
            color: #fff;
            border: none;
        }

        .btn-dark-custom:hover {
            background-color: #1a1a1a;
        }

        h1 {
            font-family: "Goldman", sans-serif;
            font-weight: bold;
            margin-bottom: 2rem;
            color: #fff;
            text-shadow: 1px 1px 4px #000;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <h1>Bienvenidos a PHP Collaborator</h1>

        <div class="card card-custom">
            <h4 class="mb-4">¿Qué rol deseas asumir?</h4>
            <div class="d-grid gap-3">
                <a href="<?= base_url('usuarios/login') ?>" class="btn btn-dark-custom btn-lg">Soy / Quiero ser Creador</a>
                <a href="<?= base_url('colaboradores/login') ?>" class="btn btn-dark-custom btn-lg">Soy / Quiero ser Colaborador</a>
            </div>
        </div>
    </div>
</body>
</html>