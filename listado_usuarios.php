<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/list_users.css">
</head>

<body>
    <?php
    $usuarios = DB::getUsers();

    echo "<table>";
    echo "<tr>";
    echo "<th>Alumnos</th>";
    echo "<th>Rol</th>";
    echo "<th>Examenes Realizados</th>";
    echo "<th>Confirmados</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";
    
    if($usuarios[0] != "No hay usuarios"){
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario->getNombre() . "</td>";
            echo "<td>" . $usuario->getRol() . "</td>";
            echo "<td>" . 2 . "</td>";
            echo "<td>" . "Si" . "</td>";
            echo "<td>" . "Acciones" . "</td>";
            echo "</tr>";
        }
    }else{
        echo    "<tr>";
        echo    "<td colspan='5'> No existen Usuarios </td>";
        echo    "</tr>";
    }
    

    echo "</table>";
    ?>
</body>

</html>