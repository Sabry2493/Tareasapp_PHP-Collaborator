<?= view('partials/header') ?>

<h2>Tareas Archivadas</h2>

<?php if (empty($archivadas)) : ?>
    <p>No hay tareas archivadas.</p>
<?php else : ?>
    <table border="1" cellpadding="8">
        <thead>
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
                    <td>
                        <!-- Restaurar -->
                        <form action="<?= base_url('tareas/restaurar/'. $tarea->id) ?>" method="post" style="display:inline;">
                            <button type="submit">Restaurar</button>
                        </form>

                        <!-- Eliminar -->
                        <form action="<?= base_url('tareas/eliminarArchivada'. $tarea->id) ?>" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta tarea archivada?');">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="<?= base_url('tareas/listar')?>">← Volver a tareas</a>

<?= view('partials/footer') ?>