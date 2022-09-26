<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//verificar si existe el usuario
$sql = $dbConn->prepare("SELECT * FROM alumnos where ID= ?");
$sql->execute([
    $_POST['id']
]);

$result = $sql->rowCount();

if ($result<=0) {
   $res = array("ID ". $_POST['id'] => "no exite registro");

  echo json_encode($res);

} else {
  
   $dato =$sql->fetch(PDO::FETCH_OBJ);

    $sql = "UPDATE alumnos SET NOMBRE= ? , DOCUMENTO = ? , DESCRIPCION = ?  WHERE id= ? ";

    $statement = $dbConn->prepare($sql);
    $statement->execute([
    $_POST['nombre'],
    $_POST['documento'],
    $_POST['descripcion'],
    $_POST['id'],
    ]);

    header("HTTP/1.1 200 OK");

    $res = array(
        'mensaje'=> 'Registro actualizado satisfactoriamente',
        'data' => array(
            'id' =>  $_POST['id'] ,
            'nombre' =>  $_POST['nombre'],
            'documento' =>  $_POST['documento'],
            'descripcion' =>  $_POST['descripcion'] 
        )
    );

echo json_encode($res);
exit();
}
