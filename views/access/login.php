<?php

use App\Authentification;
use App\Connection;
use App\HTML\Form;
use App\Table\UserTable;

if (session_status() === PHP_SESSION_NONE) {
  session_start();
  if (!empty($_SESSION)) {
    if (Authentification::check('client')) {
      header('Location: ' . $router->url('booking'));
      exit();
    } elseif (Authentification::check('admin')) {
      header('Location: ' . $router->url('rental-map'));
      exit();
    }  
  }
}

$jsFile = 'login';
$form =new Form();

if (!empty($_POST)) {

  $pdo = Connection::getPDO();
  $userTable = new UserTable($pdo);
  $userCalled = $userTable->selectUserByEmail($_POST['email']);

  if ($userCalled === false) {
    $error = 'Identifiants incorrects';

  } else {

    $result = password_verify($_POST['password'], $userCalled->getPassword());
    if ($result === false) {
      $error = 'Identifiants incorrects';

    } else {

      if ($userCalled->getRole() === 'client') {
        $_SESSION = [
          'auth' => $userCalled->getId(),
          'role' => $userCalled->getRole()
        ];
        header('Location: ' . $router->url('booking'));
        exit();

      } elseif ($userCalled->getRole() === 'admin') {

        $_SESSION = [
          'auth' => $userCalled->getId(),
          'role' => $userCalled->getRole()
        ];
        header('Location: ' . $router->url('rental-map'));
        exit();
      }
    }
  }
}

require_once "modal/modal-account.php";

?>

<div class="container text-center lgn">

  <div class="container mb-3 pt-5">
    <a href="<?= $router->url('home') ?>">
      <img class="mx-auto d-block lgn-logo" src="/images/logo.png" width="130" alt="Logo du site">
    </a>
  </div>

  <form class="container lgn-form" action="<?= $router->url('login') ?>" method="post" id="loginForm">

    <?= $form->createInput('email', 'email', 'user', 'Email', 'mb-3') ?>

    <?= $form->createInput('password', 'password', 'user', 'Mot de passe', 'mb-3') ?>

    <div class="mt-1">
      <button class="btn bt-classic fw-bold" id="user-submit" type="button">SE CONNECTER</button>
    </div>
    
  </form>

  <?php if (isset($error)): ?>
    <small class="text-danger"><?= $error ?></small>
  <?php endif ?>

  <?php if (isset($_GET['security'])): ?>
    <small class="text-danger">Vous ne pouvez pas accéder à cette page !</small>
  <?php endif ?>

  <div class="mt-5">
    <p>Vous n'avez pas encore de compte ?</p>
    <a class="btn bt-other fw-bold" href="#accountModal" type="button" data-bs-toggle="modal">CRÉER VOTRE COMPTE</a>
  </div>

</div>