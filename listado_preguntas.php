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

    $preguntas = DB::getQuestions();

    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Enunciado</th>";
    echo "<th>Tematica</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";

    if ($preguntas[0] != "No hay preguntas") {

        foreach ($preguntas as $pregunta) {
            echo "<tr>";
            echo "<td>" . $pregunta->getId() . "</td>";
            echo "<td>" . $pregunta->getEnunciado_pregunta() . "</td>";
            echo "<td>" . DB::getThematic($pregunta->getId_tematica())->getTema() . "</td>";
            echo "<td>" . "Editar" . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr>";
        echo "<td colspan='4'> No existen Preguntas </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

</body>

</html>