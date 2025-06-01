<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Editar Tarea</h2>

    <form method="post" action="<?= base_url('tareas/actualizar/' . $tarea['id']) ?>" id="formcm" class="bg-light p-4 rounded">
        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto:</label>
            <input id="asunto" class="form-control" type="text" name="asunto" value="<?= esc($tarea['asunto']) ?>" >
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?= esc($tarea['descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select id="prioridad" name="prioridad" class="form-select">
                <option value="Baja" <?= $tarea['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
                <option value="Normal" <?= $tarea['prioridad'] === 'Normal' ? 'selected' : '' ?>>Normal</option>
                <option value="Alta" <?= $tarea['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select id="estado" name="estado" class="form-select">
                <option value="Definida" <?= $tarea['estado'] === 'Definida' ? 'selected' : '' ?>>Definida</option>
                <option value="En proceso" <?= $tarea['estado'] === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                <option value="Completada" <?= $tarea['estado'] === 'Completada' ? 'selected' : '' ?>>Completada</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento:</label>
            <input id="fecha_vencimiento" class="form-control" type="date" name="fecha_vencimiento" value="<?= $tarea['fecha_vencimiento'] ?>">
        </div>

        <div class="mb-3">
            <label for="fecha_recordatorio" class="form-label">Fecha Recordatorio:</label>
            <input id="fecha_recordatorio" class="form-control" type="date" name="fecha_recordatorio" value="<?= $tarea['fecha_recordatorio'] ?>">
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input id="color" class="form-control" type="color" name="color" value="<?= $tarea['color'] ?>">
        </div>
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('tareas/listar') ?>" class="btn btn-secondary">Volver a tareas</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
<?= view('partials/footer') ?>