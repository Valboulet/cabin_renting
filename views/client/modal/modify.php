<?php

use App\Table\CabinTable;

$showBedrooms = (new CabinTable($pdo))->showBedrooms();
$showBedroomType = str_replace("'", "", explode(',', substr($showBedrooms['Type'], 5, -1)));

?>


<!-- Modal Modify Booking Client Side -->

<div class="modal fade" id="modifyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <div>
          <h5 class="modal-title fw-bold">
            Référence : 
            <span  id="bookingReference">
              <!-- Booking reference -->
            </span>
          </h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center p-4">
        <h5 class="mb-3 mt-4">Sélectionner une semaine</h5>
        <input type="week" class="form-floating mb-3" style="width: 100%;" id="weekPicker" value="">

        <h5 class="mb-3 mt-4">Sélectionner un nombre de chambres</h5>
        <div>

          <select class="form-select mb-4" id="bedroom">
          <?php foreach($showBedroomType as $bedroom): ?>
            <option value="<?= $bedroom ?>"><?= $bedroom ?> chambre(s)</option>
          <?php endforeach ?>
          </select>

        </div>
        <button class="btn bt-classic" type="button" id="updateButton" data-bs-dismiss="modal">VALIDER</button>
      </div>
    </div>
  </div>
</div>