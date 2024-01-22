<?php

namespace App\Model;

class Cabin {

  private $id;
  private $name;
  private $bedroom;
  private $availability;


  public function getId(): int
  {
  return $this->id;
  }

  public function getName(): string
  {
  return htmlspecialchars($this->name);
  }

  public function getBedroom(): string
  {
  return $this->bedroom;
  }

  public function getAvailability(): int
  {
  return $this->availability;
  }


}