<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

$input = $_POST;

$sql = "INSERT INTO examenes
      (MATERIA,PROFESOR,PREGUNTAS,NOTA,FECHA,FECHA_FINAL,EMAIL,FK_ALUMNO) VALUES (?,?,?,?,?,?,?,?)";
$statement = $dbConn->prepare($sql);

$statement->execute([
      $_POST['materia'],
      $_POST['profesor'],
      $_POST['preguntas'],
      $_POST['nota'],
      $_POST['fecha'],
      $_POST['fecha_final'],
      $_POST['email'],
      $_POST['fk_alumno']
]);

$postId = $dbConn->lastInsertId();

//buscamos los campos del registro insertado
$sql = $dbConn->prepare("SELECT * FROM examenes where id= ?");
$sql->execute(
      [
            $postId
      ]);

$dato = $sql->fetch(PDO::FETCH_OBJ);

 //busca el los datos del fk 
 $sql1 = $dbConn->prepare("SELECT * FROM alumnos where id= ?");
 $sql1->execute([$dato->FK_ALUMNO]);

 $fk =$sql1->fetch(PDO::FETCH_OBJ);

 $res =  array(
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

header("HTTP/1.1 200 OK");
echo json_encode($res);


