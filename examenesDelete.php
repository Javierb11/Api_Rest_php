<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

 //verificar si existe el usuario
 $sql = $dbConn->prepare("SELECT * FROM examenes where ID= ?");
 $sql->execute([$_POST['id']]);
 $result = $sql->rowCount();

 if ($result<=0) {
    $res = array("ID ". $_POST['id'] => "no exite registro");

   echo json_encode($res);

 } else {
   
    $dato =$sql->fetch(PDO::FETCH_OBJ);

    //busca el los datos del fk 
    $sql1 = $dbConn->prepare("SELECT * FROM alumnos where id= ?");
    $sql1->execute(
      [
        $dato->FK_ALUMNO
      ]
    );

    $fk =$sql1->fetch(PDO::FETCH_OBJ);

    
$id = $_POST['id'];
$statement = $dbConn->prepare("DELETE FROM examenes where id= ? ");

$statement->execute([
  $_POST['id']
]);
header("HTTP/1.1 200 OK");

$res = array(
  'mensaje'=> 'Registro eliminado satisfactoriamente',
  'id' =>  $dato->ID ,
  'materia' =>  $dato->MATERIA,
  'profesor' =>  $dato->PROFESOR,
  'email' =>  $dato->EMAIL,
  'nota' =>  $dato->NOTA, 
  'preguntas' =>  $dato->PREGUNTAS,
  'fecha' =>  $dato->FECHA,
  'fecha_final' =>  $dato->FECHA_FINAL, 
  "data_fk"=> array(
    'id' =>  $fk->ID ,
    'nombre' =>  $fk->NOMBRE,
    'documento' =>  $fk->DOCUMENTO,
    'descripcion' =>  $fk->DESCRIPCION 
        )
);
   echo json_encode($res);
   exit();
 }