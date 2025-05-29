<?= view('partials/header') ?>

<h2>Editar Subtarea</h2>

<form method="post" action="<?= base_url('subtareas/actualizar/' . $subtarea['id']) ?>">
    <input type="hidden" name="id_tarea" value="<?= esc($subtarea['id_tarea']) ?>">

    <label>Descripción:</label><br>
    <textarea name="descripcion"><?= esc($subtarea['descripcion']) ?></textarea><br>

    <label>Estado:</label><br>
    <select name="estado">
        
        <option value="En Proceso" <?= $subtarea['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
        <option value="Completada" <?= $subtarea['estado'] === 'Completada' ? 'selected' : '' ?>>Completada</option>
    </select><br>

    <label>Prioridad:</label><br>
    <select name="prioridad">
        <option value="Baja" <?= $subtarea['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
        <option value="Normal" <?= $subtarea['prioridad'] === 'Normal' ? 'selected' : '' ?>>Normal</option>
        <option value="Alta" <?= $subtarea['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
    </select><br>

    <label>Fecha Vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" value="<?= esc($subtarea['fecha_vencimiento']) ?>"><br>

    <label>Comentario:</label><br>
    <textarea name="comentario"><?= esc($subtarea['comentario']) ?></textarea><br>

    <br>

    <button type="submit">Actualizar</button>
</form>
<a href="<?= base_url('/subtareas/listar/' . $subtarea['id_tarea']) ?>">Volver a Subtareas</a>
<?= view('partials/footer') ?>