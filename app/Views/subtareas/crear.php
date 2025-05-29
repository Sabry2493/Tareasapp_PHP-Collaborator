<?= view('partials/header') ?>

<h2>Crear Subtarea</h2>

<form method="post" action="<?= base_url('subtareas/guardar') ?>">
    <input type="hidden" name="id_tarea" value="<?= esc($id_tarea) ?>">

    <label>Descripción:</label><br>
    <textarea name="descripcion" required></textarea><br>
 
    <!-- <label>Estado:</label><br>
    <select name="estado" required>
        <option value="en_proceso" selected>En proceso</option>
        <option value="completada">Completada</option>
    </select><br> --> 

    <label>Prioridad:</label><br>
    <select name="prioridad" required>
        <option value="baja">Baja</option>
        <option value="normal" selected>Normal</option>
        <option value="alta">Alta</option>
    </select><br>

    <label>Fecha de vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento"><br>

    <label>Comentario:</label><br>
    <textarea name="comentario"></textarea><br>

    <!-- <label>ID Responsable:</label><br>
    <input type="number" name="id_responsable" min="1"><br><br> -->

    <button type="submit">Guardar Subtarea</button>
</form>
<a href="<?= base_url('tareas/listar') ?>">Volver a Tareas</a>

<?= view('partials/footer') ?>