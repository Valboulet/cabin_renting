<?php

use App\Authentification;
use App\Connection;
use App\Table\ClientTable;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
  if (empty($_SESSION)) {
    $connection = ['url' => 'login', 'button' => 'SE CONNECTER'];
  } else {
    $connection = ['url' => 'logout', 'button' => 'DÉCONNEXION'];
  }
}

?>

<nav class="navbar sticky-top navbar-expand-md px-4">
  <div class="container-fluid">
    <a class="navbar-brand ms-2"  href="<?= $router->url('home') ?>">
      <img src="/images/logo.png" alt="logo" width="70">
    </a>
    <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-md-0 mt-4 ms-2" id="navbarToggler">
      <ul class="nav ms-auto me-2 list-group list-group-horizontal-md">

        <?php
          if (!empty($_SESSION)):
            if(Authentification::check('admin')):
        ?>

          <li class="nav-item my-md-auto me-2 mb-2">
            <a class="nav-link lnk-nav" href="<?= $router->url('rental-map') ?>" role="button">
              CARTE DES LOCATIONS
            </a>
          </li>

        <?php elseif (Authentification::check('client')): 
          $pdo = Connection::getPDO();
          $client = (new ClientTable($pdo))->selectClientDataById($_SESSION['auth']);
        ?>

          <li class="nav-item my-md-auto me-2 mb-2">
            <a class="nav-link  lnk-nav" href="<?= $router->url('booking') ?>" role="button">
              RÉSERVATION
            </a>
          </li>
          <li class="nav-item my-lg-auto me-4 mb-4 ms-2">
            <button type="button" class="btn dropdown-toggle lnk-nav drp-account" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              MON COMPTE
            </button>
            <form class="dropdown-menu p-4">

              <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" value="<?= $client->getFirstName() ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" value="<?= $client->getLastName() ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" value="<?= $client->getEmail() ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" value="<?= $client->getPhone() ?>" disabled>
              </div>

              <button type="button" class="btn bt-classic">MODIFIER MES INFOS</button>
            </form>
          </li>

        <?php endif; endif ?>

          <li class="nav-item my-md-auto mx-md-0 mx-auto mb-2">
            <form action="<?= $router->url($connection['url']) ?>" method="post">
              <button class="btn btn-outline-light" type="submit">
                <?= $connection['button'] ?>
              </button>
            </form>
          </li>

      </ul>
    </div>
  </div>
</nav>