<?php

namespace App;

use App\Security\SecurityException;

class Authentification {

  public static function check(string $role)
  {
    if (session_status() === PHP_SESSION_NONE) {

      session_start();
    }
    if (!isset($_SESSION['auth']) || !isset($_SESSION['role'])) {

      throw new SecurityException();

    } else {

      if ($_SESSION['role'] === $role) {

        return true;
        
      } else {

        return false;
      }
    }
  }
}