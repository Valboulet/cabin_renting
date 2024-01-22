<?php

namespace App\Model;

class Client extends User {

  private $user_id;
  private $first_name;
  private $last_name;
  private $phone;

  
  public function getUserId(): string
  {
    return $this->user_id;
  }

  public function setUserId(string $user_id): self
  {
    $this->user_id = $user_id;
    return $this;
  }
  
  public function getFirstName(): string
  {
    return htmlspecialchars($this->first_name, ENT_NOQUOTES);
  }

  public function setFirstName(string $first_name): self
  {
    $this->first_name = htmlspecialchars($first_name, ENT_NOQUOTES);
    return $this;
  }

  public function getLastName(): string
  {
    return htmlspecialchars($this->last_name, ENT_NOQUOTES);
  }

  public function setLastName(string $last_name): self
  {
    $this->last_name = htmlspecialchars($last_name, ENT_NOQUOTES);
    return $this;
  }

  public function getPhone(): string
  {
    return $this->phone;
  }

  public function setPhone(string $phone): self
  {
    $this->phone = $phone;
    return $this;
  }


}