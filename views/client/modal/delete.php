
<!-- Modal Delete Booking Client Side -->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <div>
          <h5 class="modal-title fw-bold" id="cabin-name">
            <!--Cabin name -->
          </h5>
          <span>Référence : </span>
          <span id="bookingReference">
            <!-- Reference -->
          </span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
        <span class="fst-italic" id="bedroom">
          <!--Cabin bedrooms -->
        </span>
        <p class="fs-5" id="week">
          <!--Booking week -->
        </p>
        <p class="text-danger fs-5">Voulez-vous vraiment supprimer cette réservation ?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn bt-classic" data-bs-dismiss="modal" id="deleteButton">OUI</button>
        <button type="button" class="btn bt-other" data-bs-dismiss="modal">NON</button>
      </div>
    </div>
  </div>
</div>