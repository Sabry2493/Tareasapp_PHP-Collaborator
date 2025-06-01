<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Crear Subtarea</h2>

    <form method="post" action="<?= base_url('subtareas/guardar') ?>" class="bg-light p-4 rounded" id="formcm">
        
        <input type="hidden" name="id_tarea" value="<?= esc($id_tarea) ?>">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" class="form-control" name="descripcion" rows="4" required></textarea>
        </div>
    
        <!-- <label>Estado:</label><br>
        <select name="estado" required>
            <option value="en_proceso" selected>En proceso</option>
            <option value="completada">Completada</option>
        </select><br> --> 
        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select id="prioridad" class="form-select" name="prioridad" required>
                <option value="baja">Baja</option>
                <option value="normal" selected>Normal</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
            <input id="fecha_vencimiento" class="form-control" type="date" name="fecha_vencimiento">
        </div>
        <div class="mb-3">
            <label id="comentario" class="form-control">Comentario:</label>
            <textarea id="comentario" class="form-control" rows="4" name="comentario"></textarea>
        </div>
        <!-- <label>ID Responsable:</label><br>
        <input type="number" name="id_responsable" min="1"><br><br> -->
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('subtareas/listar/' . $id_tarea) ?>" class="btn btn-secondary">Volver a subtareas</a> 
            <button type="submit" class="btn btn-primary">Guardar Subtarea</button>
        </div>
    </form>
</div>

<?= view('partials/footer') ?>