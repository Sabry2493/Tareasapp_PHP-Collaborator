<?= view('partials/header') ?>
<div class="container mt-5">
    <h2 class="text-center">Solicitar ser colaborador</h2>

    <p class="text-justify mx-auto w-70 " id="terminos">⚠️ Importante: Al registrarte como colaborador, aceptás que otros usuarios puedan asignarte subtareas.
    Esta colaboración se orienta a proyectos desarrollados en PHP puro utilizando el framework CodeIgniter. Al inscribirte, declarás estar capacitado para trabajar en tareas relacionadas con ese entorno y te comprometés a cumplir con las subtareas que se te asignen.
    Si estás de acuerdo con estas condiciones, completá el formulario con tu email y una contraseña para comenzar a colaborar.</p>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <fieldset class="mb-4 p-3 rounded" style="background: linear-gradient(to bottom, rgba(194, 190, 182, 0.47), rgba(184, 170, 88, 0.78));box-shadow: 0 10px 10px rgba(32, 32, 32, 0.74);">
                <form method="post" action="<?= base_url('colaboradores/registrar') ?>">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="nombre usuario" name="nombre_colaborador">
                        <label for="floatingInput">Nombre de Usuario:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email_colaborador" >
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
                    <button class="btn btn-primary" type="submit">Solicitar ser colaborador</button>
                </form>
                <!--Muestra los errores que definimos en el UsuarioController con el array rules, mediante el metodo listErrors-->
                 <?php if (isset($validation)): ?>
                    <div style="color:red;">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>
                <div class="mt-3 text-center">
                    <p>¿Ya sos colaborador? <a href="<?= base_url('colaboradores/login') ?>" id="enlace">Iniciá sesión aquí</a></p>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<?= view('partials/footer') ?>