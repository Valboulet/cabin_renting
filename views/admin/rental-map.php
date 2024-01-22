<?php

use App\Authentification;
use App\Connection;
use App\Method;
use App\Table\BookingTable;
use App\Table\CabinTable;
use App\Table\ClientTable;

if (!Authentification::check('admin')) {
  header('Location: ' . $router->url('login'));
  exit();
}

$jsFile = 'map';

require_once "modal/delete.php";
require_once "modal/changeAvail.php";


$pdo = Connection::getPDO();

$cabins = (new CabinTable($pdo))->selectCabins();
$bookings = (new BookingTable($pdo))->selectBookingsWeek();
$clients = (new ClientTable($pdo))->selectClients();

unset($_SESSION['cabinId']);

if (!empty($_SESSION['selectedWeek'])) {
  $selectedWeek = $_SESSION['selectedWeek'];
  unset($_SESSION['selectedWeek']);
  $dateBooking = substr_replace($selectedWeek, '-W', 4, 0);
} elseif (!empty($_POST['selectWeek'])) {
  $dateBooking =  $_POST['selectWeek'];
  $selectedWeek = str_replace('-W', '', $dateBooking);
} else {
  $dateBooking = date("Y-\WW");
  $selectedWeek = date('YW');
}

if (!empty($_SESSION['bookingReference'])) {
  $disabled = 'disabled';
  $status = '';
} else {
  $disabled = '';
  $status = 'disabled';
}

?>

<main>
  <div class="row justify-content-center my-3">
    <div class="col-3">
      <form action="<?php $router->url('rental-map') ?>" method="post">
        <div class="form-floating">
            <input class="form-control" type="week" name="selectWeek" id="selectWeek" value="<?= $dateBooking ?>">
            <label for="selectWeek">Semaine Réservée</label>
        </div>
        <div class="text-center">
          <button type="submit" class="btn mt-2 bt-classic">VALIDER</button>
        </div>
      </form>
    </div>
  </div>
  <div class="container rental-map">
    <div class="row border">

    <?php 
    foreach($cabins as $cabin):
      $clientName = '';
      $cabinName = $cabin->getName();
      $availability = $cabin->getAvailability();
      foreach($bookings as $booking) {
        if ($booking->getWeek() === $selectedWeek) {
          if ($cabin->getId() === $booking->getCabinId()) {
            $bookingReference = $booking->getReference();
            foreach ($clients as $client) {
              if ($client->getUserId() === $booking->getClientId()) {
                $clientName = $client->getFirstName() .' '. strtoupper($client->getLastName());
              }
            }
          }
        }
      }    
    ?> 
      <div class="col-3 py-5 <?= $availability ? (empty($clientName) ? 'bg-success' : 'bg-danger') : 'bg-secondary' ?> border text-center">
        <h5><?= $cabinName ?></h5>

        <div class="flex justify-content between">
          <p><?= $availability ? (empty($clientName) ? 'Libre' : 'Réservé') : 'Indisponible' ?></p> <!-- If available, then : If client name doesn't exists, then show 'libre' -->
          <div class="d-flex justify-content-evenly my-2">
            <?php if ($availability && empty($clientName)): ?>
              <form action="<?= $router->url('create-booking') ?>" method="post">
                <button type="submit" class="btn bt-classic" <?= $disabled ?>>
                    <i class="bi bi-person-gear fs-5"></i>
                </button>
                <input type="hidden" name="selectedWeek" value="<?= $selectedWeek ?>">
                <input type="hidden" name="cabinId" value="<?= $cabin->getId() ?>">
              </form>
            <?php elseif (!$availability): ?>
              <button class="btn bt-classic" data-bs-target="#updateAvailModal" data-bs-toggle="modal" <?= $disabled ?>>
                <i class="bi bi-pencil-fill fs-5"></i>
              </button>
            <?php endif ?>

            <!-- Showing cabins with bookings-->

            <?php if (!empty($clientName)): ?>
              <!-- If there is a booking (with client name), show the calendar icon -->
              <form action="<?= $router->url('update-booking') ?>" method="post">
                <button type="submit" class="btn bt-classic" <?= $disabled ?>>
                  <i class="bi bi-calendar3 fs-5"></i>
                </button>
                <input type="hidden" name="bookingReference" value="<?= $bookingReference ?>">
                <input type="hidden" name="selectedWeek" value="<?= $selectedWeek ?>">
              </form>

              <!-- If there is a booking (with client name), show the trash icon -->
              <button data-bs-target="#deleteModal" class="btn bt-classic" data-bs-toggle="modal" 
                data-client="<?= $clientName ?>" 
                data-week="<?= Method::displayDate($selectedWeek) ?>" 
                data-cabin="<?= $cabinName ?>" 
                data-reference="<?= $bookingReference ?>" 
                <?= $disabled ?>>
                <i class="bi bi-trash3-fill fs-5"></i>
              </button>

            <?php elseif ($availability): ?>

              <form action="<?= $router->url('update-booking') ?>" method="post">
                <button type="submit" class="btn bt-classic" <?= $status ?>>
                  <i class="bi bi-plus-circle-fill fs-5"></i>
                </button>
                <input type="hidden" name="cabinId" value="<?= $cabin->getId() ?>">
                <input type="hidden" name="selectedWeek" value="<?= $selectedWeek ?>">
              </form>

            <?php endif ?>

          </div>
        </div>
        <span class="client-name"><?= $clientName ?></span>

      </div>
    <?php endforeach ?>

    </div>
  </div>


</main>
