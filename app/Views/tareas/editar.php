<?= view('partials/header') ?>
<h2>Editar Tarea</h2>

<form method="post" action="<?= base_url('tareas/actualizar/' . $tarea['id']) ?>">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" value="<?= esc($tarea['asunto']) ?>"><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion"><?= esc($tarea['descripcion']) ?></textarea><br>

    <label>Prioridad:</label><br>
    <select name="prioridad">
        <option value="Baja" <?= $tarea['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
        <option value="Normal" <?= $tarea['prioridad'] === 'Normal' ? 'selected' : '' ?>>Normal</option>
        <option value="Alta" <?= $tarea['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
    </select><br>

    <label>Estado:</label><br>
    <select name="estado">
        <option value="Definida" <?= $tarea['estado'] === 'Definida' ? 'selected' : '' ?>>Definida</option>
        <option value="En proceso" <?= $tarea['estado'] === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
        <option value="Completada" <?= $tarea['estado'] === 'Completada' ? 'selected' : '' ?>>Completada</option>
    </select><br>

    <label>Fecha Vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" value="<?= $tarea['fecha_vencimiento'] ?>"><br>

    <label>Fecha Recordatorio:</label><br>
    <input type="date" name="fecha_recordatorio" value="<?= $tarea['fecha_recordatorio'] ?>"><br>

    <label>Color:</label><br>
    <input type="color" name="color" value="<?= $tarea['color'] ?>"><br><br>

    <button type="submit">Actualizar</button>
</form>
<a href="<?= base_url('tareas/listar') ?>">Volver a Tareas</a>
<?= view('partials/footer') ?>