<!-- Modal Delete Booking -->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <div>
          <h5 class="modal-title fw-bold" id="client-name">
            <!--Client name -->
          </h5>
          <span class="fst-italic fs-5" id="cabin-name">
            <!--Cabin name -->
          </span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
        <p id="week">
          <!--Booking week -->
        </p>
        <p class="text-danger fs-5">Voulez-vous vraiment supprimer cette réservation ?</p>
      </div>

      <div class="modal-footer">
        <form action="<?= $router->url('delete-booking') ?>" method="post">
          <input type="hidden" id="reference" name="reference">
          <button type="submit" class="btn bt-classic">OUI</button>
        </form>
        <button type="button" class="btn bt-other" data-bs-dismiss="modal">NON</button>
      </div>
    </div>
  </div>
</div>