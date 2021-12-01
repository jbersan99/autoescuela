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
    $tematicas = DB::getThematics();

    echo "<table>";
    echo "<tr>";
    echo "<th>Tematica</th>";
    echo "<th>Activada</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";

    if($tematicas[0] != "No hay tematicas"){
        foreach ($tematicas as $tematica) {
            echo "<tr>";
            echo "<td>" . $tematica->getTema() . "</td>";
            echo "<td>" . "Activada" . "</td>";
            echo "<td>" . "Acciones" . "</td>";
            echo "</tr>";
        }
    }else{
        echo    "<tr>";
        echo    "<td colspan='4'> No existen Tematicas </td>";
        echo    "</tr>";
    }

    


    echo "</table>";
    ?>
</body>

</html>