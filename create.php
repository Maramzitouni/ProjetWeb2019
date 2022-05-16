<?php

ini_set('display_errors', 1);

if (isset($_POST['message'])) {

  $message = $_POST['message'];

  // wamp: sans mot de passe
  $pdo = new PDO('mysql:host=217.182.207.53:3306;dbname=site', 'root', 'maram');
  $stmt = $pdo->prepare('INSERT INTO message (msg) VALUES (?)');
  $success = $stmt->execute([$message]);

} else {
  http_response_code(400);
}

?>
