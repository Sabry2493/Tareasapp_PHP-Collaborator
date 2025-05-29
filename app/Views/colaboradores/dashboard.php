<?= view('partials/header') ?>

<h2>Mis Tareas Compartidas</h2>

<?php if (empty($tareas)): ?>
    <p>No tenés tareas asignadas.</p>
<?php else: ?>
    <?php $id_colaborador = session()->get('id_colaborador'); ?>
    <?php foreach ($tareas as $t): ?>
        <div style="border: 1px solid #ccc; background-color: <?= esc($t['color']) ?>; padding: 10px; margin-bottom: 10px;">
            <h3><?= esc($t['asunto']) ?></h3>
            <p>
                <strong>Estado:</strong> <?= esc($t['estado']) ?> |
                <strong>Prioridad:</strong> <?= esc($t['prioridad']) ?> |
                <strong>Vencimiento:</strong> <?= esc($t['fecha_vencimiento']) ?>
            </p>
            <button onclick="toggleSubtareas(<?= $t['id'] ?>)">Subtareas</button>

            <div id="subtareas-<?= $t['id'] ?>" style="display: none; margin-top: 10px;">
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Colaborador</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($t['subtareas'] as $sub): ?>
                            <tr>
                                <td><?= esc($sub['descripcion']) ?></td>
                                <td><?= esc($sub['estado']) ?></td>
                                <td><?= esc($sub['email_colaborador']) ?></td>
                                <td>
                                    <?php if ($sub['id_responsable'] == $id_colaborador): ?>
                                        <form method="post" action="<?= base_url('colaboradores/cambiarEstado') ?>">
                                            <input type="hidden" name="id_subtarea" value="<?= $sub['id_subtarea'] ?>">
                                            <select name="estado">
                                                <option <?= $sub['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                                                <option <?= $sub['estado'] == 'Completada' ? 'selected' : '' ?>>Completada</option>
                                            </select>
                                            <button type="submit">Actualizar</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: red;">Acceso denegado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="<?= base_url('colaboradores/logout') ?>">Cerrar sesión</a>

<script>
function toggleSubtareas(id) {
    const div = document.getElementById('subtareas-' + id);
    div.style.display = (div.style.display === 'none') ? 'block' : 'none';
}
</script>

<?= view('partials/footer') ?>