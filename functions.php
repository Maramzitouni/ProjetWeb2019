<?php
require_once("connexionDB.php");

	function connectDB(){

		try{
		$connect = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME,DBUSER,DBPWD); //new connection
			}catch(Exception $e){
				die("Erreur SQL ".$e->getMessage());
			}
		return $connect; 
	}

	function emailExist($connect, $email){

		$queryPrepared = $connect->prepare( "SELECT id FROM users WHERE email = :email ");

		$queryPrepared->execute(["email"=>$email]);

		//$result = $queryPrepared->fetchAll();
		$result = $queryPrepared->fetch();

		return (empty($result))?false:true;
	}

	
	function createToken($email, $id){

		return md5($email.SALT.$email.$id);
	}

	function isConnected(){
		if( !empty($_SESSION["id"]) &&  !empty($_SESSION["email"]) && !empty($_SESSION["token"])  ){

			$connect = connectDB();

			if(emailExist($connect, $_SESSION["email"])){

				$newToken = createToken($_SESSION["email"], $_SESSION["id"]);

				if($newToken == $_SESSION["token"]){
					return true;
				}else{
					return false;
				}

			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	function getEvent($connect ,$nb=null,$id=null){


    if($nb AND !$id) {
      $req= $connect->query('SELECT * FROM events LIMIT'.$nb);
      $event=$req->fetchALL();
    }elseif($id){
      $req=$connect->query('SELECT * FROM events WHERE id ='.$id);
      $event=$req->fetchObject();
    }else{
      $req=$connect->query('SELECT * FROM events');
        $event = $req->fetchALL();
    }
    return $event;
  }




function getUser($connect ,$nb=null,$id=null){


    if($nb AND !$id) {
      $req= $connect->query('SELECT * FROM users LIMIT'.$nb);
      $users=$req->fetchALL();
    }elseif($id){
      $req=$connect->query('SELECT * FROM users WHERE id ='.$id);
      $users=$req->fetchObject();
    }else{
      $req=$connect->query('SELECT * FROM users');
        $users = $req->fetchALL();
    }
    return $users;
  }


function productSoldQtyByProductId( $connect , $pid){
	$sql= $connect->query( "SELECT (sum(inscription_event.order_number))  from inscription_event where inscription_event.id_event= $pid ");
	$e=$sql->fetch();
	
	return e;
}





