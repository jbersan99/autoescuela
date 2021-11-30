<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

$preguntas = DB::getQuestions();
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
            <th>ID</th>
            <th>Enunciado</th>
            <th>Tematica</th>
            <th>Acciones</th>
        </tr>
        <?php
        foreach ($preguntas as $pregunta) {
            echo "<tr>";
            echo "<td>" . $pregunta->getId() . "</td>";
            echo "<td>" . $pregunta->getEnunciado_pregunta() . "</td>";
            echo "<td>" . DB::getThematic($pregunta->getId_tematica())->getTema(). "</td>";
            echo "<td>" . "Editar" . "</td>";
            echo "</tr>";
        }
        ?>

    </table>
</body>

</html>