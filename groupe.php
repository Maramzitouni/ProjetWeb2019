
<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
?>


<form method="post">
  <input type="submit" name="demander" value="Ajouter en ami"/>
</form>

<?php
if(isset($_POST['demander'])){
  if(!isset($relation['id'])){
    $connect->insert("INSERT INTO groupe (id_demandeur, id_receveur, statut) VALUES (?, ?, ?)",
      array($_SESSION['id'], $id, 1));    
  }            
  header('Location: profil.php' . $id);
  exit;
} 




$relation = $connect->query("SELECT *
	FROM groupe 
	WHERE (id_demandeur, id_receveur) = (:id1, :id2) OR (id_demandeur, id_receveur) = (:id2, :id1)",
	array('id1' => $_SESSION['id'], 'id2' => $id));
 
$relation = $relation->fetch();
?>

<form method="post">
<?php
  if(!isset($relation['id'])){
?>
  <input type="submit" name="demander" value="Ajouter en ami"/>
<?php
  }elseif($relation['statut'] == 1){
?>
  <span>En attente</span>
<?php     
  }
?>
</form>


<?php
$mes_demandes = $connect->query("SELECT r.*, u.nom, u.prenom
  FROM relation r 
  LEFT JOIN utilisateur u ON u.id = r.id_demandeur 
  WHERE r.id_receveur = ? AND r.statut = ?",
  array($_SESSION['id'], 1));
 
$mes_demandes = $mes_demandes->fetchAll();


?>





<table>
  <tr>
    <th>Nom prénom</th>
    <th></th>
    <th></th>
  </tr>
  <?php
    foreach($mes_demandes as $md){ 
  ?>  
  <tr>
    <form method="post">
      <td>
        <?= $md['nom'] . ' ' . $md['prenom']?> 
        <input type="hidden" name="id_demande" value="<?= $md['id']?>"/>
      </td>
      <td>
        <input type="submit" name="accepter" value="Accepter"/>
      </td>
      <td>
        <input type="submit" name="refuser" value="Refuser"/>
      </td>
    </form>
  </tr>   
  <?php
    }
  ?>
</table>



<?php

if(isset($_POST['accepter'])){
  $id_demande = (int) $id_demande;
 
  $verifier_demande = $connect->query("SELECT *
    FROM groupe  
    WHERE id = ?",
    array($id_demande));
 
  $verifier_demande = $verifier_demande->fetch();
 
  if(isset($verifier_demande['id'])){
    $connect->insert('UPDATE groupe  SET statut = ? WHERE id = ?',
      array(2, $verifier_demande['id']));
 
    header('Location: /demandes-amis'); 
    exit;
  }
}





if(isset($_POST['refuser'])){
 
  $id_demande = (int) $id_demande;
 
  $connect->insert('DELETE FROM groupe  WHERE id = ?',
    array($id_demande));
 
  header('Location: /demandes-amis'); 
  exit;
}
?>