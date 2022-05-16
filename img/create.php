<?php

ini_set('display_errors', 1);

if (isset($_POST['message'])) {

  $message = $_POST['message'];

  // wamp: sans mot de passe
  $pdo = new PDO('mysql:host=localhost;dbname=site;port=3306', 'root', 'maram');
  $stmt = $pdo->prepare('INSERT INTO message (msg) VALUES (?)');
  $success = $stmt->execute([$message]);

} else {
  http_response_code(400);
}

?>
