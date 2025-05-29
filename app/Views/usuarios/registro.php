<?= view('partials/header') ?>
<div class="container mt-5">

    <h2 class="text-center">Registro de Usuario Creador</h2>
    <p class="text-justify mx-auto w-70" id="terminos">⚠️ Importante: Al registrarte como creador vas a poder crear tareas de proyectos que tengas en mente, 
        te comprometes a tener cargo a colaboradores, si es necesario para la ayuda del mismo. Si estas seguro 
        a continuacion procede al registro de usuario creador de contenido </p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <fieldset class="mb-4 p-3 rounded" style="background: linear-gradient(to bottom, rgba(194, 190, 182, 0.47), rgba(184, 170, 88, 0.78));box-shadow: 0 10px 10px rgba(32, 32, 32, 0.74);">
                <form method="post" action="<?= base_url('usuarios/registrar') ?>">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="nombre usuario" name="nombre_usuario">
                        <label for="floatingInput">Nombre de Usuario:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                        <label for="floatingInput">Email:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" >
                        <label for="floatingPassword">Contraseña:</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="aceptaCompromiso" name="acepta_compromiso" value="1">
                        <label class="form-check-label" for="aceptaCompromiso">
                            Acepto el compromiso mencionado arriba.
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>

                <!--Muestra los errores que definimos en el UsuarioController con el array rules, mediante el metodo listErrors-->
                <?php if (isset($validation)): ?>
                    <div style="color:red;">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <div class="mt-3 text-center">
                    <p > ¿Ya tienes una cuenta? <a href="<?= base_url('usuarios/login') ?>" id="enlace"> Inicia sesion aqui</a></p>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<?= view('partials/footer') ?>