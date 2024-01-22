<?php

namespace App;

use PDO;

class Connection {

  private static $dsn = 'mysql:host=localhost;dbname=cabin_renting';
  private static $username = 'root';
  private static $password = '12PoisHaie74?';

  // Returns a PDO object to connect to the database
  public static function getPDO(): PDO
  {
    # Setting the error handling mode and throwing a PDOException exception
    return new PDO(self::$dsn, self::$username, self::$password,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  }
}