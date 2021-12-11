<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Tematica.php";
require_once "include/Validator.php";
require_once "include/User.php";

$tematicas = DB::getThematics();
$numero_respuestas = DB::getAllAnswers();
$numero_preguntas = DB::getAllQuestions();

Sesion::iniciar();
if (!Sesion::existe('usuario')) {
    header("Location: index.php");
}else {
    $usuario = Sesion::leer('usuario');
    if ($usuario->getRol() == "Usuario") {
        header("Location: full_listado_examenes.php");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de una Pregunta</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_pregunta.css">
    <script src="https://kit.fontawesome.com/978435c791.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1> Alta Pregunta </h1>
    </header>
    <main>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="tematica"> Tematica <br>
                <select name="tematica">
                    <?php

                    foreach ($tematicas as $tematica) {
                        echo '<option value="' . $tematica->getId() . '">' . $tematica->getTema() . '</option>';
                    }
                    ?>
                </select>
                <br>
            </label>
            <label for="enunciado"> Enunciado <br>
                <textarea name="enunciado" cols="30" rows="10" value="<?php echo isset($_POST['enunciado']) ? htmlspecialchars($_POST['enunciado']) : ''; ?>"></textarea> <br>
            </label>
            <label for="opcion1"> Opcion 1 <br>
                <input type="text" name="respuesta_1" value="<?php echo isset($_POST['respuesta_1']) ? htmlspecialchars($_POST['respuesta_1']) : ''; ?>">
                <input type="radio" name="correcta" value="1"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 2 <br>
                <input type="text" name="respuesta_2" value="<?php echo isset($_POST['respuesta_2']) ? htmlspecialchars($_POST['respuesta_2']) : ''; ?>">
                <input type="radio" name="correcta" value="2"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 3 <br>
                <input type="text" name="respuesta_3" value="<?php echo isset($_POST['respuesta_3']) ? htmlspecialchars($_POST['respuesta_3']) : ''; ?>">
                <input type="radio" name="correcta" value="3"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 4 <br>
                <input type="text" name="respuesta_4" value="<?php echo isset($_POST['respuesta_4']) ? htmlspecialchars($_POST['respuesta_4']) : ''; ?>">
                <input type="radio" name="correcta" value="4"> Correcta<br>
            </label>
            <label for="foto"> Selecciona la imagen de la pregunta <br>
                <input type="file" class="form-control" id="image" name="image">
                <img id="imagenPrevisualizacion" width="150"> <br>
                <script src="scripts/script.js"></script>
            </label><br>
            <input type="submit" value="Enviar" name="enviar">

        </form>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['enviar'])) {
                $v = new Validator();
                $v->Requerido('enunciado');
                $v->Requerido('respuesta_1');
                $v->Requerido('respuesta_2');
                $v->Requerido('respuesta_3');
                $v->Requerido('respuesta_4');
                if (count($v->errores) > 0) {
                    echo '<br><span class="error">' . $v->errores['enunciado'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_1'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_2'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_3'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_4'] . '</span> ';
                } else if ($_FILES["image"] != true) {
                    echo '<span class="error">Introduce una fotografía para continuar</span> ';
                } else if (!$v->FraseValida($_POST['enunciado'])) {
                    echo '<span class="error">Introduce un enunciado valido</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_1'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_2'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_3'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_4'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else {
                    $image = $_FILES['image']['tmp_name'];
                    $imgContenido = file_get_contents($image);
                    $imgContenido = base64_encode($imgContenido);
                    if (isset($_POST['correcta'])) {
                    switch ($_POST['correcta']) {
                        case 1:
                            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 1, $imgContenido, $_POST["tematica"]);
                            header("Location: full_listado_preguntas.php");
                            break;
                        case 2:
                            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 2, $imgContenido, $_POST["tematica"]);
                            header("Location: full_listado_preguntas.php");
                            break;
                        case 3:
                            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 3, $imgContenido, $_POST["tematica"]);
                            header("Location: full_listado_preguntas.php");
                            break;
                        case 4:
                            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 4, $imgContenido, $_POST["tematica"]);
                            header("Location: full_listado_preguntas.php");
                            break;
                    }
                }else{
                    echo '<span class="error">Elige una opcion correcta</span> ';
                }
                }
            }
        }
        ?>
    </main>
    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter <i class="fab fa-twitter"></i></a> <a href="facebook.com">Facebook <i class="fab fa-facebook-square"></i></a> <a href="instagram.com">Instagram <i class="fab fa-instagram-square"></i></a>
    </footer>

</body>

</html>