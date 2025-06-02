<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Crear Tarea</h2>

    <?php if (!empty($validation)) : ?>
        <div style="color:red;">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('tareas/guardar') ?>" class="bg-light p-4 rounded" id="formcm">
        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto:</label>
            <input id="asunto" type="text" name="asunto" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" class="form-control" name="descripcion" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select id="prioridad" class="form-select" name="prioridad" >
                <option value="" selected>Seleccione prioridad</option>
                <option value="Baja">Baja</option>
                <option value="Normal" selected>Normal</option>
                <option value="Alta">Alta</option>
            </select><br>
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento:</label>
            <input id="fecha_vencimiento" class="form-control" type="date" name="fecha_vencimiento"  value="<?= date('Y-m-d') ?>" >
        </div>
        <div class="mb-3">
            <label for="fecha_recordatorio" class="form-label">Fecha Recordatorio:</label>
            <input id="fecha_recordatorio" class="form-control" type="date" name="fecha_recordatorio"  value="<?= date('Y-m-d') ?>">
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input id="color" class="form-control" type="color" name="color">
        </div>
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('tareas/listar') ?>" class="btn btn-secondary">Volver a tareas</a>    
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    
    
</div>
<?= view('partials/footer') ?>