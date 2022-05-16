<?php

$pdo = new PDO('mysql:host=217.182.207.53:3306;dbname=site', 'root', 'maram');
$stmt = $pdo->query('SELECT msg, id FROM message');
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";
echo "<tr> <th>Message</th> <th>ID</th> </tr>";
foreach ($messages as $msgs) {
  echo "<tr>";
  echo "<td>" . $msgs ['msg'] . "</td>";
    echo "<td>" . $msgs ['id'] . "</td>";
  echo '<td> <button onclick="removeMessage(' . $msgs['id'] . ')">X</button> </td>';
  echo "</tr>";
}
echo "</table";

 ?>
