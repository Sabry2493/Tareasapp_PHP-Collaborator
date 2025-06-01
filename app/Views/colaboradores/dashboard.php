<?= view('partials/header') ?>
<div class="container mt-4" style="min-height: 80vh;">
    <h2  class="mb-4" >Mis Tareas Compartidas</h2>

    <?php if (empty($tareas)): ?>
        <div class="alert alert-info">No tenés tareas asignadas.</div>
    <?php else: ?>
        <?php $id_colaborador = session()->get('id_colaborador'); ?>
        <div class="row">
            <?php foreach ($tareas as $t): ?>
                <div class="col-md-12 mb-4">
                    <div class="card" style="background-color: <?= esc($t['color']) ?>;">
                        <div class="card-body">
                            <h4 class="card-title"><?= esc($t['asunto']) ?></h4>
                            <p class="card-text">
                                <strong>Estado:</strong> <?= esc($t['estado']) ?> |
                                <strong>Prioridad:</strong> <?= esc($t['prioridad']) ?> |
                                <strong>Vencimiento:</strong> <?= esc($t['fecha_vencimiento']) ?>
                            </p>
                            <!-- <button class="btn btn-dark btn-sm" onclick="toggleSubtareas(<?= $t['id'] ?>)">Ver/ocultar subtareas</button> -->
                            <button class="btn btn-dark btn-sm" data-bs-toggle="collapse" data-bs-target="#subtareas-<?= $t['id'] ?>">
                                Ver/ocultar subtareas
                            </button>
                            <!-- <div id="subtareas-<?= $t['id'] ?>" class="mt-3" style="display: none; margin-top: 10px;"> -->
                            <div id="subtareas-<?= $t['id'] ?>" class="collapse mt-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Colaborador</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($t['subtareas'] as $sub): ?>
                                                <tr class="<?= $sub['estado'] === 'Completada' ? 'table-success' : '' ?>">
                                                    <td><?= esc($sub['descripcion']) ?></td>
                                                    <td><?= esc($sub['estado']) ?></td>
                                                    <td><?= esc($sub['email_colaborador']) ?></td>
                                                    <td>
                                                        <?php if ($sub['id_responsable'] == $id_colaborador): ?>
                                                            <form method="post" action="<?= base_url('colaboradores/cambiarEstado') ?>" class="d-flex gap-2 align-items-center">
                                                                <input type="hidden" name="id_subtarea" value="<?= $sub['id_subtarea'] ?>">
                                                                <select name="estado" class="form-select form-select-sm w-auto">
                                                                    <option <?= $sub['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                                                                    <option <?= $sub['estado'] == 'Completada' ? 'selected' : '' ?>>Completada</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                                                            </form>
                                                        <?php else: ?>
                                                            <span class="text-danger">Acceso denegado</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>       
    <?php endif; ?>

</div>


<script>
/* function toggleSubtareas(id) {
    const div = document.getElementById('subtareas-' + id);
    div.style.display = (div.style.display === 'none') ? 'block' : 'none';
}*/
</script> 

<?= view('partials/footer') ?>