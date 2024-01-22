<?php

namespace App\Table;

use App\Model\Client;
use PDO;

final class ClientTable extends Table {

  protected $table = 'clients';
  protected $class = Client::class;
  protected $fetchMode = PDO::FETCH_CLASS;
  protected $fetchFn = 'fetchAll';

  // Returns all clients
  public function selectClients(): array
  {
    $this->sql = 
    "SELECT first_name, last_name, user_id
      FROM {$this->table}";

    return $this->getDatas();
  }

  // Return client's datas based on their id
  public function selectClientDataById(string $id): object
  {
    $this->sql = 
      "SELECT first_name, last_name, phone, email
      FROM {$this->table}
      JOIN users AS u ON u.id = user_id
      WHERE user_id = :user_id";

    $this->param = ['user_id' => $id];
    $this->fetchFn = 'fetch';

    return $this->getDatas();
  }

  // Create new client
  public function createClient(Client $client): void
  {
    $this->sql = 
      "INSERT INTO {$this->table} 
      SET first_name = :first_name, last_name = :last_name, phone = :phone, user_id = :user_id";

    $this->param = [
      'first_name' => $client->getFirstName(),
      'last_name' => $client->getLastName(),
      'phone' => $client->getPhone(),
      'user_id' => $client->getUserId()
    ];
    $this->manageDatas();
  }

}