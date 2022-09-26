<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//Mostrar lista de post
$sql = $dbConn->prepare("SELECT * FROM examenes");
$sql->execute();

$res =array();

foreach ($sql->fetchAll(PDO::FETCH_OBJ) as $key => $dato) {
  
//busca el los datos del fk 
$sql1 = $dbConn->prepare("SELECT * FROM alumnos where id= ?");
$sql1->execute(
  [
    $dato->FK_ALUMNO
  ]);
$fk =$sql1->fetch(PDO::FETCH_OBJ);

array_push($res,array(
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
  ))
);

}

header("HTTP/1.1 200 OK");
echo json_encode( $res  );
exit();
