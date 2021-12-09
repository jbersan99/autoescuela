<?php

include "../include/DB.php";

$respuesta = new stdClass;
if (isset($_POST['descripcion']) && $_POST['duracion']) {
    var_dump($_POST['ids']);
    $done = DB::insertExam($_POST["descripcion"], $_POST['duracion'], $_POST['ids']);
    if($done){
        $respuesta->success = 1;
    }else{
        $respuesta->success = 0;
    }
} else {
    $respuesta->success = 0;
}

echo json_encode($respuesta);
