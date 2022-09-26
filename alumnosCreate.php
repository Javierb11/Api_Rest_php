<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

$sql = "INSERT INTO alumnos
      (NOMBRE,DOCUMENTO,DESCRIPCION) VALUES (?,?,?)";
$statement = $dbConn->prepare($sql);

$statement->execute([
      $_POST['nombre'],
      $_POST['documento'],
      $_POST['descripcion'],
]);

$postId = $dbConn->lastInsertId();

if($postId)
{
  $input = array(
      'id' => $postId,
      'nombre' => $_POST['nombre'],
      'documento' => $_POST['documento'],
      'descripcion' => $_POST['descripcion'],
  );

  header("HTTP/1.1 200 OK");
  echo json_encode($input);
  exit();
 }

