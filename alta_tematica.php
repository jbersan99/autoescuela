<?php

include "include/DB.php";
require_once "include/Sesion.php";
require_once "entities/Tematica.php";
require_once "include/Validator.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $tematica = $_POST['tematica'];
        if (empty($tematica)) {
            $v->Requerido($tematica);
            $errores = $v->__construct();
        }else{
            $misma_tematica = DB::existsThematic($tematica);
            if(!$misma_tematica){
                $verificar = DB::insertThematic($tematica);
                if($verificar){
                    header("Location: inicio.php");
                }else{
                    echo "Hubo un problema introduciendo la nueva tematica";
                }
            }else{
                echo "Esta tematica ya esta registrada en la base de datos";
            }
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de una Tematica</title>
</head>

<body>
    <header>
        <h1> Alta Tematica </h1>
    </header>
    <div class="alta">
        <form action="#" method="post">
            <label for="tematica"> Tematica <br>
                <input type="text" name="tematica"><br>
            </label>
            <input type="submit" value="Introducir" name="enviar">
        </form>
    </div>
</body>

</html>