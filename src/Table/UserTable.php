<?php

namespace App\Table;

use App\Method;
use App\Model\User;
use PDO;
use Ramsey\Uuid\Uuid;

final class UserTable extends Table {

  protected $table = 'users';
  protected $class = User::class;
  protected $fetchMode = PDO::FETCH_CLASS;
  protected $fetchFn = 'fetch';

  // Returns a user's data based on their email
  public function selectUserByEmail(string $email)
  {
    $this->sql = "
      SELECT id, email, password, role
      FROM {$this->table}
      WHERE email = :email
    ";
    $this->param = ['email' => $email];
    return $this->getDatas();
  }

  // Select User Id by email
  public function selectUserIdByEmail(string $email)
  {
    $this->sql = "SELECT id FROM {$this->table} WHERE email = :email";

    $this->param = ['email' => $email];
    return $this->getDatas();
  }

  // Create User to create booking
  public function createUser(User $user): void
  {
    $this->sql =
    "INSERT INTO {$this->table} SET id = :id, email = :email, password = :password, role = :role";

    $this->param = [
      'id' => (Uuid::uuid4())->toString(),
      'email' => $user->getEmail(),
      'password' => password_hash(Method::generatePassword(), PASSWORD_BCRYPT),
      'role' => 'client'
    ];

    $this->manageDatas();
  }

}