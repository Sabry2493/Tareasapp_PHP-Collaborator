<?= view('partials/header') ?>

<?php if (session()->get('mostrar_modal_vencimiento')): ?>
    <!-- Modal simple con HTML y JS -->
    <div id="modalVencimiento" style="position: fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.5); display:flex; justify-content:center; align-items:center;">
        <div style="background-color: white; padding: 20px; border-radius: 10px; width: 300px; text-align: center;">
            <h3>¡Atención!</h3>
            <p>Tenés tareas que vencen en los próximos 2 días. Verificalas en la lista.</p>
            <button onclick="cerrarModal()">Aceptar</button>
        </div>
    </div>

    <script>
        function cerrarModal() {
            document.getElementById('modalVencimiento').style.display = 'none';

            // Llamada para eliminar la variable de sesión (opcional pero recomendado)
            fetch("<?= base_url('usuarios/ocultar-modal') ?>");
        }
    </script>
<?php endif; ?>

<div class="container my-4">
    <h2 class="text-center mb-4">Lista de Tareas</h2>
    <div class="d-flex justify-content-between mb-3">
        <a href="<?= base_url('tareas/crear') ?>" class="btn btn-primary">Crear nueva tarea</a> 
        <a href="<?= base_url('tareas/archivadas')?>" class="btn btn-secondary">🗂️ Ver tareas archivadas</a>
    </div>


    <form method="get" action="<?= base_url('tareas/listar') ?>" class="row g-3 mb-4">
        <div class="col-md-2">
            <label for="estado" class="form-label">Estado:</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">Todos</option>
                <option value="Definida" <?= ($estado ?? '') === 'Definida' ? 'selected' : '' ?>>Definida</option>
                <option value="En proceso" <?= ($estado ?? '') === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                <option value="Completada" <?= ($estado ?? '') === 'Completada' ? 'selected' : '' ?>>Completada</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="prioridad" class="form-label">Prioridad:</label>
            <select name="prioridad" id="prioridad" class="form-select">
                <option value="">Todas</option>
                <option value="Baja" <?= ($prioridad ?? '') === 'Baja' ? 'selected' : '' ?>>Baja</option>
                <option value="Normal" <?= ($prioridad ?? '') === 'Normal' ? 'selected' : '' ?>>Normal</option>
                <option value="Alta" <?= ($prioridad ?? '') === 'Alta' ? 'selected' : '' ?>>Alta</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="filtro_colaboracion" class="form-label">Mostrar:</label>
            <select name="filtro_colaboracion" id="filtro_colaboracion" class="form-select">
                <option value="">Todas</option>
                <option value="compartidas" <?= $filtro == 'compartidas' ? 'selected' : '' ?>>Solo compartidas</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="orden_fecha" class="form-label">Ordenar por fecha:</label>
            <select name="orden_fecha" id="orden_fecha" class="form-select">
                <option value="">Sin orden</option>
                <option value="asc" <?= $orden == 'asc' ? 'selected' : '' ?>>Más próxima primero</option>
                <option value="desc" <?= $orden == 'desc' ? 'selected' : '' ?>>Más lejana primero</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="asunto" class="form-label">Filtrar por asunto:</label>
            <select name="asunto" id="asunto" class="form-control" class="form-select">
                <option value="">Todos</option>
                <?php foreach ($asuntosDisponibles as $asuntoItem): ?>
                    <option value="<?= esc($asuntoItem) ?>" <?= $asuntoItem == $asunto ? 'selected' : '' ?>>
                        <?= esc($asuntoItem) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success me-2">Filtrar</button>
            <a href="<?= base_url('tareas/listar') ?>" class="btn btn-outline-secondary">Quitar filtros</a>
        </div>
    </form>
     <?php if (empty($tareas)): ?>
        <div class="alert alert-warning text-center">⚠️ No se encontraron tareas con los filtros aplicados.</div>
     <?php else: ?>
            <table class="table table-bordered table-striped align-middle">
                <thead  class="table-dark text-center">
                    <tr>
                        <th>Asunto</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha Vencimiento</th>
                        <th>Colaboradores</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tareas as $t): ?>
                    <tr style="background-color: <?= esc($t['color']) ?>;">
                        <td><?= esc($t['asunto']) ?></td>
                        <td><?= esc($t['prioridad']) ?></td>
                        <td><?= esc($t['estado']) ?></td>
                        <td><?= esc($t['fecha_vencimiento']) ?></td>
                        <td>
                            <?= !empty($t['colaboradores']) ? implode(', ', $t['colaboradores']) : '-' ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('tareas/editar/' . $t['id']) ?>" class="btn btn-sm btn-primary">Editar</a> |
                            <a href="<?= base_url('tareas/eliminar/' . $t['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar</a>|
                            <!-- Ver subtareas -->
                            <a href="<?= base_url('subtareas/listar/' . $t['id']) ?>" class="btn btn-sm btn-info">Subtareas</a> |
                            <a href="<?= base_url('tareas/mostrarCompartir/' . $t['id']) ?>" class="btn btn-sm btn-warning">Compartir con colaboradores</a>
                            
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
    <?php endif; ?>
</div>
<?= view('partials/footer') ?>