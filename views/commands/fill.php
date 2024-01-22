<?php

$pdo = new PDO('mysql:dbname=cabin_renting;host=localhost', 'root', '12PoisHaie74?',
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Users creation
$users = [
  [
    'email' => 'ulysse@ithaque.od',
    'password' => password_hash('I0n1€nn€s', PASSWORD_BCRYPT),
    'role' => 'admin'
  ],
  [
    'email' => 'george.prat@example.eu',
    'password' => password_hash('T39@!!0n', PASSWORD_BCRYPT),
    'role' => 'client'
  ],
  [
    'email' => 'sylvie.sedan@example.fr',
    'password' => password_hash('A5tur1€5', PASSWORD_BCRYPT),
    'role' => 'client'
  ],
  [
    'email' => 'peter.vanhuis@example.nl',
    'password' => password_hash('Héph@ï5t05', PASSWORD_BCRYPT),
    'role' => 'client'
  ],
  [
    'email' => 'eleanore.monnier@example.be',
    'password' => password_hash('P€rséph0n3', PASSWORD_BCRYPT),
    'role' => 'client'
  ],
  [
    'email' => 'francois.dumas@example.lu',
    'password' => password_hash('F0m01r€5', PASSWORD_BCRYPT),
    'role' => 'client'
  ]
];
foreach ($users as $user) {
  $pdo->exec(
    "INSERT INTO users (id, email, password, role) VALUES (UUID(), '{$user['email']}', '{$user['password']}', '{$user['role']}')
  ");
}

// Retrieving customers id
$query = $pdo->prepare("SELECT id FROM users WHERE role = :role");
$query->execute(['role' => 'client']);
$usersId = $query->fetchAll(PDO::FETCH_COLUMN);

// Clients creation
$clients = [
  [
    'first_name' => 'George',
    'last_name' => 'Prat',
    'phone' => '0033825364896',
    'user_id' => $usersId[0]
  ],
  [
    'first_name' => 'Sylvie',
    'last_name' => 'Sedan',
    'phone' => '0033847858698',
    'user_id' => $usersId[1]
  ],
  [
    'first_name' => 'Peter',
    'last_name' => 'Vanhuis',
    'phone' => '0031915869475',
    'user_id' => $usersId[2]
  ],
  [
    'first_name' => 'Éléanore',
    'last_name' => 'Monnier',
    'phone' => '0032478965321',
    'user_id' => $usersId[3]
  ],
  [
    'first_name' => 'François',
    'last_name' => 'Dumas',
    'phone' => '0035248791153',
    'user_id' => $usersId[4]
  ]
];
foreach ($clients as $client) {
  $pdo->exec(
    "INSERT INTO clients (first_name, last_name, phone, user_id) VALUES (
      '{$client['first_name']}', '{$client['last_name']}', '{$client['phone']}', '{$client['user_id']}'
    )
  ");
}

// Cabins creation
$cabins = [
  ['name' => 'Chalet 11', 'bedroom' => '1', 'availability' => 1], ['name' => 'Chalet 12', 'bedroom' => '1', 'availability' => 1],
  ['name' => 'Chalet 13', 'bedroom' => '1', 'availability' => 1], ['name' => 'Chalet 14', 'bedroom' => '1', 'availability' => 1],
  ['name' => 'Chalet 21', 'bedroom' => '2', 'availability' => 1], ['name' => 'Chalet 22', 'bedroom' => '2', 'availability' => 1],
  ['name' => 'Chalet 23', 'bedroom' => '2', 'availability' => 1], ['name' => 'Chalet 24', 'bedroom' => '2', 'availability' => 1],
  ['name' => 'Chalet 31', 'bedroom' => '3', 'availability' => 1], ['name' => 'Chalet 32', 'bedroom' => '3', 'availability' => 1],
  ['name' => 'Chalet 33', 'bedroom' => '3', 'availability' => 1], ['name' => 'Chalet 34', 'bedroom' => '3', 'availability' => 1],
  ['name' => 'Chalet 41', 'bedroom' => '4', 'availability' => 1], ['name' => 'Chalet 42', 'bedroom' => '4', 'availability' => 1],
  ['name' => 'Chalet 51', 'bedroom' => '5', 'availability' => 1], ['name' => 'Chalet 52', 'bedroom' => '5', 'availability' => 1]
];
foreach ($cabins as $cabin) {
  $pdo->exec("INSERT INTO cabins (name, bedroom, availability) VALUES ('{$cabin['name']}', '{$cabin['bedroom']}', {$cabin['availability']})");
}

// Bookings creation
$bookings = [
 
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202405',
    'client_id' => $usersId[1],
    'cabin_id' => 8
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202406',
    'client_id' => $usersId[3],
    'cabin_id' => 12
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202407',
    'client_id' => $usersId[0],
    'cabin_id' => 5
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202407',
    'client_id' => $usersId[1],
    'cabin_id' => 1
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202408',
    'client_id' => $usersId[2],
    'cabin_id' => 15
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202409',
    'client_id' => $usersId[3],
    'cabin_id' => 2
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202410',
    'client_id' => $usersId[4],
    'cabin_id' => 5
  ],
  [
    'reference' => bin2hex(random_bytes(6)),
    'week' => '202411',
    'client_id' => $usersId[1],
    'cabin_id' => 1
  ]


];
foreach ($bookings as $booking) {
  $pdo->exec("INSERT INTO bookings (reference, week, client_id, cabin_id) VALUES (
      '{$booking['reference']}', '{$booking['week']}', '{$booking['client_id']}', {$booking['cabin_id']}
    )
  ");
}