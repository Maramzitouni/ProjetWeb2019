<?php

if (isset($_GET['id'])) {

  $id = $_GET['id'];
  $pdo = new PDO('mysql:host=217.182.207.53:3306;dbname=site', 'root', 'maram');
  $stmt = $pdo->prepare('DELETE FROM message WHERE id = ?');
  $stmt->execute([
    $id
  ]);

} else {
  http_response_code(400);
}


 ?>
