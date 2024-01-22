<?php

namespace App\Table;

use App\Model\Cabin;
use PDO;

final class CabinTable extends Table {

  protected $table = 'cabins';
  protected $class = Cabin::class;
  protected $fetchMode = PDO::FETCH_CLASS;
  protected $fetchFn = 'fetchAll';

  // Returns all cabins
  public function selectCabins(): array
  {
    $this->sql = 
    "SELECT id, name, bedroom, availability
    FROM {$this->table}
    ORDER BY name";

    return $this->getDatas();
  }

  // Return available cabins
  public function selectAvailableCabins(): array
  {
    $this->sql = 
      "SELECT id, name, bedroom
      FROM {$this->table}
      WHERE availability = :availability
      ORDER BY name";

    $this->param = ['availability' => 1];
    return $this->getDatas();
  }

  // Return cabin by name and bedrooms
  public function selectCabinById(int $id)
  {
    $this->sql = 
    "SELECT name, bedroom
    FROM {$this->table}
    WHERE availability = :availability AND id = :id";

    $this->param = [
     'availability' => 1,
     'id' => $id 
    ];

    $this->fetchFn = 'fetch';

    return $this->getDatas();
  }

  // Return bedrooms (for select inputs)
  public function showBedrooms(): array
  {
    $this->sql = "SHOW COLUMNS from {$this->table} LIKE 'bedroom'";

    $this->fetchMode = PDO::FETCH_ASSOC;
    $this->fetchFn = 'fetch';

    return $this->getDatas();
  }
}