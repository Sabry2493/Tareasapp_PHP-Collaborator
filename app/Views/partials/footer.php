 <footer class="bg-dark text-center py-1" style="box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
    <div class="container pt-3 " style="text-align: center;">
        <img src="<?= base_url('img/logofooter.png') ?>" alt="Logo" style="width: 70px;" >
        <p style="font-family: Genos, sans-serif;color:white"> &copy; <?= date('Y') ?> Mi TareasApp. Todos los derechos reservados.</p>
    </div>
    <div class="container mt-1 pb-3" style="text-align: center;">
        <img src="<?= base_url('img/facebook.png') ?>" alt="facebook" style="width: 40px;margin-right:50px;">
        <img src="<?= base_url('img/instagram.png') ?>" alt="instagram" style="width: 40px;margin-right:50px;">
        <img src="<?= base_url('img/linkedin.png') ?>" alt="mapa" style="width: 40px;">
    </div>
</footer>

<!-- Bootstrap JS (para funcionalidades como modales) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal Bootstrap para creacion/modificacion -->
<?php if (session()->getFlashdata('modal_msg')): 
    $msg = session()->getFlashdata('modal_msg');
?> 
<div class="modal fade" id="modalGeneral" tabindex="-1" aria-labelledby="modalGeneralLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalGeneralLabel"><?= esc($msg['titulo'] ?? 'Mensaje') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <p><?= $msg['mensaje'] ?></p> <!-- NO usamos esc() porque el mensaje ya contiene etiquetas HTML -->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalGeneral'));
        modal.show();
    });
</script>
<?php endif; ?>
<!--Fin del modal creacion/modificacion-->

<!-- Modal para recordatorios (campana) -->
<?php if (session()->get('modal_msg_persistente')): 
    $msg = session()->get('modal_msg_persistente');
?>
<div class="modal fade" id="modalRecordatorio" tabindex="-1" aria-labelledby="modalRecordatorioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRecordatorioLabel"><?= esc($msg['titulo'] ?? 'Recordatorio') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><?= $msg['mensaje'] ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!--Fin del modal recordatorio-->
</body>
</html>