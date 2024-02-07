<?php

include_once 'conexion.php';

$objeto = new Conexion();

$conexion = $objeto->Conectar();

//necesario para recibir parametros con Axios
$_POST = json_decode(file_get_contents("php://input"), true);


$opcion = $_POST['opcion'] ?? '';

$id = $_POST['id'] ?? '';
$marca = $_POST['marca'] ?? '';
$modelo = $_POST['modelo'] ?? '';
$stock = $_POST['stock'] ?? '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO moviles (marca, modelo, stock) VALUES ('$marca', '$modelo', '$stock')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 2: //modificacion
        $consulta = "UPDATE moviles SET marca='$marca', modelo='$modelo', stock='$stock' WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 3: //borrar
        $consulta = "DELETE FROM moviles WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4: //listar
        $consulta = "SELECT id, marca, modelo, stock FROM moviles";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//Enviar el array final en formato json a JS
$conexion = null;
?>