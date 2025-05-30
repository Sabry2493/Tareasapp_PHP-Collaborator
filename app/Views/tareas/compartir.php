<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Compartir Tarea</h2>
    <p class="lead">Estás compartiendo la tarea #<?= esc($id_tarea) ?></p>
    <h3 class="mt-4">Asignar subtarea a colaborador</h3>


    <form method="post" action="<?= base_url('tareas/asignar_subtarea/' . $id_tarea) ?>" class="row g-3">
        <div class="col-md-6">
            <label for="email_colaborador" class="form-label">Colaborador:</label>
            <select name="email_colaborador" id="email_colaborador" class="form-select" required>
                <option value="">-- Seleccionar colaborador--</option>
                <?php foreach ($usuarios as $col): ?>
                    <option value="<?= esc($col['email_colaborador']) ?>"><?= esc($col['email_colaborador']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="id_subtarea" class="form-label">Subtarea:</label>
            <select name="id_subtarea" id="id_subtarea" class="form-select" required>
                <option value="">-- Subtareas disponibles --</option>
                <?php foreach ($subtareas_disponibles as $sub): ?>
                    <option value="<?= $sub['id'] ?>"><?= esc($sub['descripcion']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Asignar</button>
        </div>
    </form>

    <!--Tabla colaboradores actuales-->

    <?php if (!empty($subtareas_asignadas)): ?>
        <h3 class="mt-5">Colaboradores actuales:</h3>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success mt-3"><?= session()->getFlashdata('mensaje') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
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
                                <form action="<?= base_url('subtareas/cambiarEstado') ?>" method="post" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="id_subtarea" value="<?= $sub['id_subtarea'] ?>">
                                    <select name="estado" class="form-select form-select-sm w-auto">
                                        <option <?= $sub['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                                        <option <?= $sub['estado'] == 'Completada' ? 'selected' : '' ?>>Completada</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary" >Cambiar</button>
                                </form>
                            <?php else: ?>
                                <em class="text-muted">No autorizado</em>
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
    </div>
    <?php else: ?>
        <p class="mt-4 text-muted">No hay colaboradores para esta tarea.</p>
    <?php endif; ?>
    
    <a href="<?= base_url('tareas/listar') ?>" class="btn btn-secondary mt-4">Volver a Tareas</a>
</div>
<?= view('partials/footer') ?>