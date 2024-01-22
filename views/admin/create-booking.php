<?php

use App\Authentification;
use App\Connection;
use App\Method;
use App\Model\Booking;
use App\Model\Client;
use App\Model\User;
use App\Table\BookingTable;
use App\Table\CabinTable;
use App\Table\ClientTable;
use App\Table\UserTable;

if (!Authentification::check('admin')) {
  header('Location: ' . $router->url('login'));
  exit();
}

$jsFile = 'create';

$pdo = Connection::getPDO();

if (empty($_SESSION['cabinId']) && empty($_SESSION['selectedWeek'])) {
  if (!empty($_POST)) {
    $_SESSION['selectedWeek'] = $_POST['selectedWeek'];
    $_SESSION['cabinId'] = $_POST['cabinId'];
  }
}

$cabin = (new CabinTable($pdo))->selectCabinById($_SESSION['cabinId']);

if (!empty($_POST['email'])) {
  $user = new User();
  $userTable = new UserTable($pdo);

  $client = new Client();
  $clientTable = new ClientTable($pdo);

  $booking = new Booking();
  $bookingTable = new BookingTable($pdo);

  $user->setEmail($_POST['email']);
  $userTable->createUser($user);
  $userId = ($userTable->selectUserIdByEmail($_POST['email']))->getId();

  $client
    ->setFirstName($_POST['firstname'])
    ->setLastName($_POST['lastname'])
    ->setUserId($userId)
    ->setPhone($_POST['phone']);

  $clientTable->createClient($client);

  $booking
    ->setclientId($userId)
    ->setCabinId($_SESSION['cabinId'])
    ->setWeek($_SESSION['selectedWeek']);

  $bookingTable->createBooking($booking);

  header('Location: ' . $router->url('rental-map'));
  exit();
} 

?>

<!-- Reservation -->

<!-- Account Creation -->

<div class="container-fluid account">
  <form action="" method="post" class="row justify-content-evenly">

    <div action="" class="container col-sm-5 p-5 my-5 mx-3 rounded-3 shadow text-center booking-area">
      <h2 class="fs-2 mb-5">Client</h2>
      <div class="form-floating mb-3">
        <input type="text" name="lastname" class="form-control" id="lastname" required>
        <label for="floatingName">Nom</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" name="firstname" class="form-control" id="firstname" required>
        <label for="floatingFirstname">Prénom</label>
      </div>
      <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control" id="email" required>
        <label for="floatingEmail">E-mail</label>
      </div>
      <div class="form-floating mb-3">
        <input type="tel" name="phone" class="form-control" id="phone" required>
        <label for="floatingPhone">Téléphone</label>
      </div>
    </div>

    <div class="col-sm-5 p-5 my-5 mx-3 rounded-3 shadow text-center booking-area">
      <h2 class="fs-2 mb-5">Réserver un chalet</h2>

      <h5 class="mb-3 mt-4">Semaine : </h5>
      <h5 class="fw-bold text-success fst-italic mb-4">
        <!-- Week -->
        <?= Method::displayDate($_SESSION['selectedWeek']) ?>
      </h5>
      <hr>
      <h5 class="mb-3 mt-4">Nombre de chambres : </h5>
      <h5 class="fw-bold text-success fst-italic mb-4">
        <!-- Bedrooms -->
        <?= $cabin->getBedroom() ?>
      </h5>
      <hr>
      <h5 class="mb-3 mt-4">Chalet :</h5>
      <h5 class="fw-bold text-success fst-italic">
        <!-- Cabin name -->
        <?= $cabin->getName() ?>
      </h5>
    </div>
    <button class="btn mb-5 bt-classic" type="submit" style="max-width: 300px;">VALIDER LA RÉSERVATION</button>
  </form> 
</div>

