<?php

use App\Router;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new Router(dirname(__DIR__) . '/views');

$router
  //->get('/fill', 'commands/fill', 'fill')
  ->get('/', 'access/index', 'home')
  ->getPost('/login', 'access/login', 'login')
  ->post('/logout', 'access/logout', 'logout')
  ->get('/booking', 'client/booking', 'booking')
  ->getPost('/rental-map', 'admin/rental-map', 'rental-map')
  ->getPost('/create-booking', 'admin/create-booking', 'create-booking')
  ->post('/update-booking', 'admin/update-booking', 'update-booking')
  ->post('/delete-booking', 'admin/delete-booking', 'delete-booking')
  ->get('/cabins', 'admin/cabins', 'cabins')
  ->run();
