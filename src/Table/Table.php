<?php

namespace App\Table;

use Exception;
use PDO;

abstract class Table {

  protected $pdo;
  protected $table = null;
  protected $sql = null;
  protected $class = null;
  protected $param = null;
  protected $fetchMode = null;
  protected $fetchFn = null;
  protected $exception = null;

  public function __construct(PDO $pdo)
  {
    if ($this->table === null){
      throw new Exception('La classe ' . get_class($this) . ' n\'a pas de propriété \$table');
    }
    if ($this->class === null){
      throw new Exception('La classe ' . get_class($this) . ' n\'a pas de propriété \$class');
    }
    if ($this->fetchMode === null){
      throw new Exception('La classe ' . get_class($this) . ' n\'a pas de propriété \$fetchMode');
    }
    if ($this->fetchFn === null){
      throw new Exception('La classe ' . get_class($this) . ' n\'a pas de propriété \$fetchFn');
    }
    $this->pdo = $pdo;
  }

  // Returns the result after executing a prepared query
  private function prepExec()
  {
    # Preparing the SQL query sent as parameter
    $query = $this->pdo->prepare($this->sql);
    
    # Executing the query
    $query->execute($this->param);
    
    return $query;
  }

  // Returns an array of objects
  public function getDatas()
  {    
    $query = $this->prepExec();

    # Defining the data recovery mode
    if ($this->fetchMode === PDO::FETCH_CLASS) {
      $query->setFetchMode($this->fetchMode, $this->class);
    } else {
      $query->setFetchMode($this->fetchMode);
    }

    # Retrieve data
    $datas = $query->{$this->fetchFn}();

    return $datas;
  }

  # Update, delete, create datas
  public function manageDatas(): void
  {
    $query = $this->prepExec();
    if ($query === false) {
      throw new Exception($this->exception);
    }
  }
}