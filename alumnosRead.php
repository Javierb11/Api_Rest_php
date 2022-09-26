<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

if (isset($_GET['id']))
{

//verificar si existe el usuario
 $sql = $dbConn->prepare("SELECT * FROM alumnos where id= ?");

 $sql->execute(
  [$_GET['id']
]);

 $result = $sql->rowCount();

 if ($result<=0) {
    $res = array("ID ". $_GET['id'] => "no exite");

   echo json_encode($res);

 }else{
    
  //Mostrar un post
  $sql = $dbConn->prepare("SELECT * FROM alumnos where id= ?");

  $sql->execute([
    $_GET['id']
  ]);
  
  header("HTTP/1.1 200 OK");
  echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
  exit();
 }
  
}
