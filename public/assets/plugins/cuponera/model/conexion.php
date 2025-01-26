<?php

$contraseña = "abc*2021";
$usuario = "paolo";
$nombreBaseDeDatos = "BdRentas_Historico";
$rutaServidor = "172.16.201.25";
$cnn=null;

try {
    $cnn = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
    $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
    exit;
}


?>