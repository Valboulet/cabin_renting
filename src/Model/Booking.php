<?php

namespace App\Model;

class Booking {

  private $reference;
  private $week;
  private $client_id;
  private $cabin_id;

  public function getReference(): string
  {
    return $this->reference;
  }

  public function getWeek(): string
  {
    return $this->week;
  }

  public function setWeek(string $week): self
  {
    $this->week = $week;
    return $this;
  }

  public function getCabinId(): int
  {
    return $this->cabin_id;
  }

  public function setCabinId(int $cabin_id): self
  {
    $this->cabin_id = $cabin_id;
    return $this;
  }

  public function getClientId(): string
  {
    return $this->client_id;
  }

  public function setClientId(string $client_id): self
  {
    $this->client_id = $client_id;
    return $this;
  }


}