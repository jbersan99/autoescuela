<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

$usuarios = DB::getUsers();
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
    <table>
        <tr>
            <th>Alumnos</th>
            <th>Rol</th>
            <th>Examenes Realizados</th>
            <th>Confirmados</th>
            <th>Acciones</th>
        </tr>
        <?php
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario->getNombre() . "</td>";
            echo "<td>" . $usuario->getRol() . "</td>";
            echo "<td>" . 2 . "</td>";
            echo "<td>" . "Si". "</td>";
            echo "<td>" . "Acciones" . "</td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>

</html>