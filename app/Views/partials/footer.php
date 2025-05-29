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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!--MODAL EXITO-->
<?php if (session()->getFlashdata('mensaje') && session()->getFlashdata('tipo')): 
    $mensaje = session()->getFlashdata('mensaje');
    $tipo = session()->getFlashdata('tipo');

    // Elegir color y título del modal según el tipo
    switch ($tipo) {
        case 'alta':
            $color = 'bg-success text-white';
            $titulo = '¡Éxito!';
            break;
        case 'modificacion':
            $color = 'bg-warning text-dark';
            $titulo = 'Modificación';
            break;
        case 'baja':
            $color = 'bg-danger text-white';
            $titulo = 'Baja realizada';
            break;
        default:
            $color = 'bg-secondary text-white';
            $titulo = 'Mensaje';
            break;
    }
?>
  <!--Modal Bootstrap-->
  <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content <?= $color ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMensajeLabel"><?= $titulo ?></h5>
          <button type="button" class="btn-close <?php if ($tipo !== 'modificacion') echo 'btn-close-white'; ?>" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <?= $mensaje ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    const modal = new bootstrap.Modal(document.getElementById('modalMensaje'));
    window.addEventListener('load', () => {
      modal.show();
    });
  </script>
<?php endif; ?>
<!--Fin del modal-->
</body>
</html>