<?= view('partials/header') ?>

<div class="container-fluid d-flex flex-column" style="min-height: 100vh; padding: 0;height: 100%;">
    <div class="row flex-grow-1 m-0">
        <!-- Columna del formulario -->
         <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-5" style="background: url('<?= base_url('/img/fondo.png') ?>') no-repeat center ;">
            <fieldset class="mb-4 p-5 rounded" style="background: linear-gradient(to bottom, rgba(194, 190, 182, 0.47), rgba(184, 170, 88, 0.78));box-shadow: 0 10px 10px rgba(32, 32, 32, 0.74);">
             <!-- <legend class="float-none w-auto px-2 rounded">Login de creadores</legend> -->
            <h2 class="mb-3">Login de creadores</h2>
            
            <!--Mensaje de credenciales invalidas-->
                <?php if (session()->getFlashdata('error')): ?>
                    <div style="color:red"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
            
            <form method="post" action="<?= base_url('usuarios/ingresar') ?>">
                <div class="form-floating mb-3">
                
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="btn btn-primary" type="submit">Ingresar</button>
            </form>
            
            <div class=" mt-3">
              <p> ¿No tienes cuenta? <a href="<?= base_url('usuarios/registro') ?>" id="enlace">Crear nueva cuenta</a></p>
            </div>
        </div>
        </fieldset>
        <!-- Columna de la imagen -->
        <div class="col-md-6 d-flex justify-content-center align-items-center p-0" 
            style="background: linear-gradient(to top, rgb(33, 37, 41),rgb(0, 0, 0));
                    height: 100%; min-height: 70vh;">
            <img src="<?= base_url('img/creando.jpg') ?>" alt="Imagen login" class="img-fluid" style="max-height: 100vh;opacity:0.9;">
        </div>
    </div>
</div>

<?= view('partials/footer') ?>
