<?php

namespace App\Table;

use App\Model\Booking;
use PDO;

final class BookingTable extends Table {

  protected $table = 'bookings';
  protected $class = Booking::class;
  protected $fetchMode = PDO::FETCH_CLASS;
  protected $fetchFn = 'fetchAll';

  // Returns bookings ordered by week
  public function selectBookingsWeek(): array
  {
    $this->sql = 
    "SELECT reference, week, client_id, cabin_id
      FROM {$this->table}
      ORDER BY week";

    return $this->getDatas();
  }

  // Return One booking by reference
  public function selectBookingByReference(string $reference)
  {
    $this->sql =
      "SELECT reference, week, cabin_id
      FROM {$this->table}
      WHERE reference = :reference";

    $this->param = ['reference' => $reference];
    $this->fetchFn = 'fetch';

    return $this->getDatas();
  }

  // Return booking week by reference
  public function selectBookingWeekByReference(string $reference)
  {
    $this->sql = "SELECT week FROM {$this->table} WHERE reference = :reference";

    $this->param = ['reference' => $reference];
    $this->fetchFn = 'fetch';

    return $this->getDatas();
  }

  // Return bookings by client 
  public function selectFutureBookingsByClient(string $clientId): array
  {
    $this->sql =
      "SELECT reference, cabin_id, week 
      FROM {$this->table} 
      WHERE client_id = :client_id AND week >= CONCAT(YEAR(CURRENT_DATE()), LPAD(WEEK(CURRENT_DATE(), 3), 2, '0'))
      ORDER BY week";

    $this->param = ['client_id' => $clientId];

    return $this->getDatas();
  }

 // Update booking week and cabin id
  public function updateBooking(Booking $booking): void
  {
    $this->sql =
      "UPDATE {$this->table} SET week = :week, cabin_id = :cabin_id
      WHERE reference = :reference";

      $this->param = [
        'week' => $booking->getWeek(),
        'cabin_id' => $booking->getCabinId(),
        'reference' => $booking->getReference()
      ];

      $this->manageDatas();
  }
  
  // Delete a booking by reference
  public function deleteBooking(string $reference): void
  {
    $this->sql = "DELETE FROM {$this->table} WHERE reference = :reference";

    $this->param = ['reference' => $reference];

    $this->manageDatas();
  }

  // Create booking
  public function createBooking(Booking $booking): void
  {
    $this->sql = 
      "INSERT INTO {$this->table} 
      SET reference = :reference, week = :week, client_id = :client_id, cabin_id = :cabin_id";

      $this->param = [
        'reference' => bin2hex(random_bytes(6)),
        'week' => $booking->getWeek(),
        'client_id' => $booking->getClientId(),
        'cabin_id' => $booking->getCabinId()
      ];
      $this->manageDatas();
  }

}