<?php

use App\Authentification;
use App\Connection;
use App\Table\BookingTable;

if (!Authentification::check('admin')) {
    header('Location: ' . $router->url('login'));
    exit();
  }
  

if (!empty($_POST)) {
    if (!empty($_POST['bookingReference'])) {
        $_SESSION['bookingReference'] = $_POST['bookingReference'];
        $_SESSION['selectedWeek'] = $_POST['selectedWeek'];
    }
    if (!empty($_POST['cabinId'])) {
        $pdo = Connection::getPDO();
        $bookingTable = new BookingTable($pdo);
        $booking = $bookingTable->selectBookingByReference($_SESSION['bookingReference']);

        $booking
            ->setCabinId($_POST['cabinId'])
            ->setWeek($_POST['selectedWeek']);
        
        $bookingTable->updateBooking($booking);
        unset($_SESSION['bookingReference']);
        $_SESSION['selectedWeek'] = $_POST['selectedWeek'];
    }
}

header('Location: ' . $router->url('rental-map'));

