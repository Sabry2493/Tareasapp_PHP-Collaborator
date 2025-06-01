<?= view('partials/header') ?>
<div class="container my-4" >
    <h2 class="text-center mb-4">Subtareas de la Tarea #<?= esc($id_tarea) ?></h2>
    <div class="d-flex justify-content-between mb-3">
        <a href="<?= base_url('subtareas/crear/'.$id_tarea) ?>" class="btn btn-primary">Crear Nueva Subtarea</a>
    </div>
        <form method="get" action="<?= base_url('subtareas/listar/' . $id_tarea) ?>" class="row g-3 mb-4">
            <div class="col-md-2">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="En proceso" <?= $estado == 'En proceso' ? 'selected' : '' ?>>En Proceso</option>
                    <option value="Completada" <?= $estado == 'Completada' ? 'selected' : '' ?>>Completada</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="prioridad" class="form-label">Prioridad:</label>
                <select name="prioridad" id="prioridad" class="form-select">
                    <option value="">Todas</option>
                    <option value="baja" <?= $prioridad == 'baja' ? 'selected' : '' ?>>Baja</option>
                    <option value="normal" <?= $prioridad == 'normal' ? 'selected' : '' ?>>Normal</option>
                    <option value="alta" <?= $prioridad == 'alta' ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success me-2">Filtrar</button>
                <a href="<?= base_url('subtareas/listar/' . $id_tarea) ?>" class="btn btn-outline-secondary">Quitar filtros</a>
            </div>
        </form>
        <?php if (empty($subtareas)): ?>
            <div class="alert alert-warning text-center">⚠️ No se encontraron subtareas con los filtros aplicados.</div>
        <?php else: ?>
            <table class="table table-bordered table-striped align-middle" >
                <thead class="table-dark text-center">
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
                    <?php foreach ($subtareas as $subtarea): ?>
                    <tr>
                        <td><?= esc($subtarea['id']) ?></td>
                        <td><?= esc($subtarea['descripcion']) ?></td>
                        <td><?= esc($subtarea['estado']) ?></td>
                        <td><?= esc($subtarea['prioridad']) ?></td>
                        <td><?= esc($subtarea['fecha_vencimiento']) ?></td>
                        <td><?= esc($subtarea['comentario']) ?></td>
                        <td><?= esc($subtarea['id_responsable']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('subtareas/editar/' . $subtarea['id']) ?>" class="btn btn-sm btn-primary">Editar</a> |
                            <a href="<?= base_url('subtareas/eliminar/' . $subtarea['id']) ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Estás seguro de eliminar esta subtarea?');">
                            Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        
        <?php endif; ?>

        <a href="<?= base_url('tareas/listar') ?>" class="btn btn-secondary mt-3">Volver a Tareas</a> 
</div>
<?= view('partials/footer') ?>