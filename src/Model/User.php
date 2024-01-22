<?php

namespace App\Model;

class User {

  protected $id;
  protected $email;
  protected $password;
  protected $role;

  public function getId(): string
  {
    return $this->id;
  }

  public function getEmail(): string
  {
    return htmlspecialchars($this->email);
  }

  public function setEmail(string $email): self
  {
    $this->email = htmlspecialchars($email);
    return $this;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getRole(): string
  {
    return $this->role;
  }
}