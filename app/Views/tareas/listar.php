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


<h2>Lista de Tareas</h2>

<a href="<?= base_url('tareas/crear') ?>">Crear nueva tarea</a> 
<a href="<?= base_url('tareas/archivadas')?>">🗂️ Ver tareas archivadas</a>
<a href="<?= base_url('usuarios/logout') ?>"> Salir  </a>



<form method="get" action="<?= base_url('tareas/listar') ?>" style="margin-top: 15px;">
    <label for="estado">Estado:</label>
    <select name="estado" id="estado">
        <option value="">Todos</option>
        <option value="Definida" <?= ($estado ?? '') === 'Definida' ? 'selected' : '' ?>>Definida</option>
        <option value="En proceso" <?= ($estado ?? '') === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
        <option value="Completada" <?= ($estado ?? '') === 'Completada' ? 'selected' : '' ?>>Completada</option>
    </select>

    <label for="prioridad">Prioridad:</label>
    <select name="prioridad" id="prioridad">
        <option value="">Todas</option>
        <option value="Baja" <?= ($prioridad ?? '') === 'Baja' ? 'selected' : '' ?>>Baja</option>
        <option value="Normal" <?= ($prioridad ?? '') === 'Normal' ? 'selected' : '' ?>>Normal</option>
        <option value="Alta" <?= ($prioridad ?? '') === 'Alta' ? 'selected' : '' ?>>Alta</option>
    </select>

    <label for="filtro_colaboracion">Mostrar:</label>
    <select name="filtro_colaboracion" id="filtro_colaboracion">
        <option value="">Todas</option>
        <option value="compartidas" <?= $filtro == 'compartidas' ? 'selected' : '' ?>>Solo compartidas</option>
    </select>

    <label for="orden_fecha">Ordenar por fecha:</label>
    <select name="orden_fecha" id="orden_fecha">
        <option value="">Sin orden</option>
        <option value="asc" <?= $orden == 'asc' ? 'selected' : '' ?>>Más próxima primero</option>
        <option value="desc" <?= $orden == 'desc' ? 'selected' : '' ?>>Más lejana primero</option>
    </select>


    <label for="asunto">Filtrar por asunto:</label>
    <select name="asunto" id="asunto" class="form-control">
        <option value="">Todos</option>
        <?php foreach ($asuntosDisponibles as $asuntoItem): ?>
            <option value="<?= esc($asuntoItem) ?>" <?= $asuntoItem == $asunto ? 'selected' : '' ?>>
                <?= esc($asuntoItem) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>
    <a href="<?= base_url('tareas/listar') ?>">Quitar filtros</a>
</form>
<?php if (empty($tareas)): ?>  
    <table border="1" cellpadding="10" style="margin-top: 15px;">
        <thead>
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
            <tr>
                <td colspan="8" style="text-align: center;">Sin resultados</td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <table border="1" cellpadding="10" style="margin-top: 15px;">
        <tr>
            <th>Asunto</th>
            <th>Prioridad</th>
            <th>Estado</th>
            <th>Fecha Vencimiento</th>
            <th>Colaboradores</th>
            <th>Acciones</th>
            
        </tr>
        
        <?php foreach ($tareas as $t): ?>
        <tr style="background-color: <?= esc($t['color']) ?>;">
            <td><?= esc($t['asunto']) ?></td>
            <td><?= esc($t['prioridad']) ?></td>
            <td><?= esc($t['estado']) ?></td>
            <td><?= esc($t['fecha_vencimiento']) ?></td>
            <td>
                <?= !empty($t['colaboradores']) ? implode(', ', $t['colaboradores']) : '-' ?>
            </td>
            <td>
                <a href="<?= base_url('tareas/editar/' . $t['id']) ?>">Editar</a> |
                <a href="<?= base_url('tareas/eliminar/' . $t['id']) ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">Eliminar</a>|
                <!-- Ver subtareas -->
                <a href="<?= base_url('subtareas/listar/' . $t['id']) ?>">Subtareas</a> |
                <!-- Crear subtarea -->
                <!-- <a href="<?= base_url('subtareas/crear/' . $t['id']) ?>">Agregar subtarea</a> | -->
                <!-- Colaboradores -->
                <a href="<?= base_url('tareas/mostrarCompartir/' . $t['id']) ?>">Compartir con colaboradores</a>
                
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?= view('partials/footer') ?>