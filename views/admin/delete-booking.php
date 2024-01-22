<?php

use App\Authentification;
use App\Connection;
use App\Table\BookingTable;

if (!Authentification::check('admin')) {
    header('Location: ' . $router->url('login'));
    exit();
}

if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $bookingTable = new BookingTable($pdo);
    $_SESSION['selectedWeek'] = ($bookingTable->selectBookingWeekByReference($_POST['reference']))->getWeek(); 
    $bookingTable->deleteBooking($_POST['reference']);
}
header('Location: ' . $router->url('rental-map'));

