<?= view('partials/header') ?>
<h2>Crear Tarea</h2>

<form method="post" action="<?= base_url('tareas/guardar') ?>">
    <label>Asunto:</label><br>
    <input type="text" name="asunto" required><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion"></textarea><br>

    <label>Prioridad:</label><br>
    <select name="prioridad" required>
        <option value="Baja">Baja</option>
        <option value="Normal" selected>Normal</option>
        <option value="Alta">Alta</option>
    </select><br>

    <label>Fecha Vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" required><br>

    <label>Fecha Recordatorio:</label><br>
    <input type="date" name="fecha_recordatorio"><br>

    <label>Color:</label><br>
    <input type="color" name="color"><br><br>

    <button type="submit">Guardar</button>
</form>
<?php if (!empty($validation)) : ?>
    <div style="color:red;">
        <?= $validation->listErrors(); ?>
    </div>
<?php endif; ?>
<a href="<?= base_url('tareas/listar') ?>">Volver a Tareas</a>

<?= view('partials/footer') ?>