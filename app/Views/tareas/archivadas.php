<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Tareas Archivadas</h2>

    <!--bloque para mostrar el mensaje que guardo con el with(se usa principalmente para enviar datos simples al redireccionar,como texto plano para mostrar en vistas)-->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($archivadas)) : ?>
        <div class="alert alert-info">No hay tareas archivadas.</div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Asunto</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archivadas as $tarea) : ?>
                        <tr>
                            <td><?= esc($tarea->asunto) ?></td>
                            <td><?= esc($tarea->descripcion) ?></td>
                            <td><?= esc($tarea->prioridad) ?></td>
                            <td><?= esc($tarea->estado) ?></td>
                            <td><?= esc($tarea->fecha_vencimiento) ?></td>
                            <td class="text-center">
                                <!-- Restaurar -->
                                <form action="<?= base_url('tareas/restaurar/'. $tarea->id) ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                                </form>

                                <!-- Eliminar -->
                                <form action="<?= base_url('tareas/eliminarArchivada'. $tarea->id) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta tarea archivada?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('tareas/listar')?>"  class="btn btn-secondary mt-3"> Volver a tareas</a>
</div>
<?= view('partials/footer') ?>