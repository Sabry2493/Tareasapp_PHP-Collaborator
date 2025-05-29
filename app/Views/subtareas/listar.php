<?= view('partials/header') ?>

<h2>Subtareas de la Tarea #<?= esc($id_tarea) ?></h2>

<a href="<?= base_url('subtareas/crear/'.$id_tarea) ?>">Crear Nueva Subtarea</a>
    <form method="get" action="<?= base_url('subtareas/listar/' . $id_tarea) ?>" style="margin-top: 15px;">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                <option value="">Todos</option>
                <option value="En proceso" <?= $estado == 'En proceso' ? 'selected' : '' ?>>En Proceso</option>
                <option value="Completada" <?= $estado == 'Completada' ? 'selected' : '' ?>>Completada</option>
            </select>

            <label for="prioridad">Prioridad:</label>
            <select name="prioridad" id="prioridad">
                <option value="">Todas</option>
                <option value="baja" <?= $prioridad == 'baja' ? 'selected' : '' ?>>Baja</option>
                <option value="normal" <?= $prioridad == 'normal' ? 'selected' : '' ?>>Normal</option>
                <option value="alta" <?= $prioridad == 'alta' ? 'selected' : '' ?>>Alta</option>
            </select>

            <button type="submit">Filtrar</button>
            <a href="<?= base_url('subtareas/listar/' . $id_tarea) ?>">Quitar filtros</a>
        </form>
<?php if (empty($subtareas)): ?>   
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha Vencimiento</th>
                <th>Comentario</th>
                <th>ID Responsable</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8" style="text-align: center;">Sin resultados</td>
            </tr>
        </tbody>
    </table>
<?php else: ?>   
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha Vencimiento</th>
                <th>Comentario</th>
                <th>ID Responsable</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subtareas as $subtarea): ?>
            <tr>
                <td><?= esc($subtarea['id']) ?></td>
                <td><?= esc($subtarea['descripcion']) ?></td>
                <td><?= esc($subtarea['estado']) ?></td>
                <td><?= esc($subtarea['prioridad']) ?></td>
                <td><?= esc($subtarea['fecha_vencimiento']) ?></td>
                <td><?= esc($subtarea['comentario']) ?></td>
                <td><?= esc($subtarea['id_responsable']) ?></td>
                <td>
                    <a href="<?= base_url('subtareas/editar/' . $subtarea['id']) ?>">Editar</a> |
                    <a href="<?= base_url('subtareas/eliminar/' . $subtarea['id']) ?>" 
                       onclick="return confirm('¿Estás seguro de eliminar esta subtarea?');">
                       Eliminar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<br>
<a href="<?= base_url('tareas/listar') ?>">Volver a Tareas</a>
<?= view('partials/footer') ?>