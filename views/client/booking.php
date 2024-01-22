<?php

use App\Authentification;
use App\Connection;
use App\Method;
use App\Table\BookingTable;
use App\Table\CabinTable;

if (!Authentification::check('client')) {
  header('Location: ' . $router->url('login'));
  exit();
}

$jsFile = 'booking';

$pdo = Connection::getPDO();
$bookings = (new BookingTable($pdo))->selectFutureBookingsByClient($_SESSION['auth']);
$cabins = (new CabinTable($pdo))->selectCabins();

// dump($cabins);


require_once "modal/modify.php";
require_once "modal/delete.php";

?>

<!-- Reservation -->

<div class="container-fluid account">
  <div class="row justify-content-evenly">
    <div class="col-sm-5 p-5 my-5 mx-3 rounded-3 shadow text-center booking-area">
      <h2 class="fs-2 mb-5">Réserver un chalet</h2>
      <p class="mb-3 mt-4">Sélectionner une semaine</p>
      <input type="week" class="form-floating mb-3" style="width: 100%;" id="createWeek">

      <p class="mb-3 mt-4">Sélectionner un type de chalet</p>
      <select class="form-select form-select-lg mb-4" id="createBedroom">
        <option value="0" selected>Choisissez...</option>
        <option value="1">1 chambre</option>
        <option value="2">2 chambres</option>
        <option value="3">3 chambres</option>
        <option value="4">4 chambres</option>
        <option value="5">5 chambres</option>
      </select>
      <button class="btn bt-classic" type="button" id="createButton">VALIDER</button>
    </div>


    <!-- Réservation affichée -->

    <div class="container col-sm-5 py-5 px-3 my-5 mx-3 rounded-3 shadow booking-area" id="bookingDisplay">
      <h2 class="fs-2 mb-4 text-center">Mes Réservations</h2>

      <?php foreach ($bookings as $booking) :
        foreach ($cabins as $cabin) {
          if ($booking->getCabinId() === $cabin->getId()) {
            $cabinName = $cabin->getName();
            $bedroom = $cabin->getBedroom();
          } 
        }
      ?>
        <div class="row m-4 border shadow rounded-3 res-row" id="div<?= $booking->getReference() ?>">
          <div class=" col-6">
            <img class="shadow cabin-img">
          </div>

          <div class="col res-content my-4">
            <div>
              <h5 class="cabin-name mb-3"><?= $cabinName ?></h5>
              <span>Référence : </span><span class="fw-bold text-success" id="reference"><?= $booking->getReference() ?></span><br>
              <span id="bedroom"><?= $bedroom ?> chambre(s)</span><br>
              <small class="week"  id="week" value="<?= Method::displayDateWeekPicker($booking->getWeek()) ?>"><?= Method::displayDateClient($booking->getWeek()) ?></small>
            </div>
            <div>
              <button class="btn btn-sm  mt-3 bt-classic" type="button" data-bs-toggle="modal" data-bs-target="#modifyModal">MODIFIER</button>
              <button class="btn btn-sm  mt-3 bt-other" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">SUPPRIMER</button>
            </div>
          </div>
        </div>
      <?php endforeach ?>

    </div>
  </div>
</div>