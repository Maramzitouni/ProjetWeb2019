<?php

if (isset($_GET['id'])) {

  $id = $_GET['id'];
  $pdo = new PDO('mysql:host=localhost;dbname=site;port=3306', 'root', 'maram');
  $stmt = $pdo->prepare('DELETE FROM message WHERE id = ?');
  $stmt->execute([
    $id
  ]);

} else {
  http_response_code(400);
}


 ?>
