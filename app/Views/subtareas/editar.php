<?= view('partials/header') ?>
<div class="container my-4">
    <h2 class="mb-4">Editar Subtarea</h2>

    <form method="post" action="<?= base_url('subtareas/actualizar/' . $subtarea['id']) ?>" id="formcm" class="bg-light p-4 rounded">
        <input type="hidden" name="id_tarea" value="<?= esc($subtarea['id_tarea']) ?>">
        
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea  id="descripcion" class="form-control" rows="4" name="descripcion"><?= esc($subtarea['descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <!-- <select id="estado" class="form-select" name="estado" readonly>
            
                <option value="En Proceso" <?= $subtarea['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                <option value="Completada" <?= $subtarea['estado'] === 'Completada' ? 'selected' : '' ?>>Completada</option>
            </select> -->
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i> <!-- ícono de candado -->
                </span>
                <input type="text" class="form-control" id="estado" name="estado" value="<?= $subtarea['estado'] ?>" readonly>
            </div>
        </div>

        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select id="prioridad" class="form-select" name="prioridad">
                <option value="Baja" <?= $subtarea['prioridad'] === 'Baja' ? 'selected' : '' ?>>Baja</option>
                <option value="Normal" <?= $subtarea['prioridad'] === 'Normal' ? 'selected' : '' ?>>Normal</option>
                <option value="Alta" <?= $subtarea['prioridad'] === 'Alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento:</label>
            <input id="fecha_vencimiento" class="form-control" type="date" name="fecha_vencimiento" value="<?= esc($subtarea['fecha_vencimiento']) ?>">
        </div>

        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario:</label>
            <textarea id="comentario" class="form-control" name="comentario"><?= esc($subtarea['comentario']) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('/subtareas/listar/' . $subtarea['id_tarea']) ?>" class="btn btn-secondary">Volver a Subtareas</a>   
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
<?= view('partials/footer') ?>