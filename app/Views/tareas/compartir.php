<?= view('partials/header') ?>

<h2>Compartir Tarea</h2>

<p>Estás compartiendo la tarea #<?= esc($id_tarea) ?></p>

<h3>Asignar subtarea a colaborador</h3>


<form method="post" action="<?= base_url('tareas/asignar_subtarea/' . $id_tarea) ?>">
    <label>Colaborador:</label>
    <select name="email_colaborador" required>
        <option value="">-- Seleccionar colaborador--</option>
        <?php foreach ($usuarios as $col): ?>
            <option value="<?= esc($col['email_colaborador']) ?>"><?= esc($col['email_colaborador']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Subtarea:</label>
    <select name="id_subtarea" required>
        <option value="">-- Subtareas disponibles --</option>
        <?php foreach ($subtareas_disponibles as $sub): ?>
            <option value="<?= $sub['id'] ?>"><?= esc($sub['descripcion']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Asignar</button>
</form>

        <!--Tabla colaboradores actuales-->

<?php if (!empty($subtareas_asignadas)): ?>
    <h3>Colaboradores actuales:</h3>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table >
        <thead>
            <tr>
                <th>Email</th>
                <th>Subtarea</th>
                <th>Estado</th>
                <th>Modificar Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subtareas_asignadas as $sub): ?>
                <tr>
                    <td><?= esc($sub['email_colaborador']) ?></td>
                    <td><?= esc($sub['descripcion']) ?></td>
                    <td><?= esc($sub['estado']) ?></td>
                    <td>
                        <?php if (session()->get('id') == $sub['id_responsable']): ?>
                            <form action="<?= base_url('subtareas/cambiarEstado') ?>" method="post">
                                <input type="hidden" name="id_subtarea" value="<?= $sub['id_subtarea'] ?>">
                                <select name="estado" class="form-select d-inline w-auto">
                                    <option <?= $sub['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                                    <option <?= $sub['estado'] == 'Completada' ? 'selected' : '' ?>>Completada</option>
                                </select>
                                <button type="submit" >Cambiar</button>
                            </form>
                        <?php else: ?>
                            <em>No autorizado</em>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (session()->get('id') == $id_usuario_creador_tarea): ?>
                            <a href="<?= base_url('subtareas/quitarColaborador/' . $sub['id_subtarea']) ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Estás seguro de quitar al colaborador de esta subtarea?')">
                            Quitar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay colaboradores para esta tarea.</p>
<?php endif; ?>

<?php if (session()->getFlashdata('mensaje_tarea_asignada')): 
    $msg = session()->getFlashdata('mensaje_tarea_asignada');
?> 

<div id="modalAsignacion" style="
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.3);
    display: flex; justify-content: center; align-items: center;
">
    <div style="background: white; padding: 1rem; border-radius: 5px; max-width: 400px;">
        <p>Se asignó la subtarea <strong><?= esc($msg['descripcion']) ?></strong> y se envió un mensaje al correo <strong><?= esc($msg['email']) ?></strong> del colaborador.</p>
        <button onclick="document.getElementById('modalAsignacion').style.display='none';">
            Cerrar
        </button>
    </div>
</div>

<?php endif; ?> 

<a href="<?= base_url('tareas/listar') ?>">Volver a Tareas</a>

<?= view('partials/footer') ?>