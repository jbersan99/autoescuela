<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "entities/Preguntas.php";
require_once "include/Validator.php";

$preguntas = DB::getQuestions();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta Examenes</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style>
        #sortable1,
        #sortable2 {
            list-style-type: none;
            margin: 0;
            float: left;
            margin-right: 10px;
            background: #eee;
            padding: 5px;
            width: 500px;
            height: 400px;
            overflow: scroll;
            overflow-x: hidden;
        }

        #sortable1 li,
        #sortable2 li {
            margin: 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 290px;
            height: 50px;
            text-align: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
        $(function() {
            $("ul.droptrue").sortable({
                connectWith: "ul"
            });

            $("ul.dropfalse").sortable({
                connectWith: "ul",
                dropOnEmpty: false
            });

            $("#sortable1, #sortable2").disableSelection();

        });
    </script>
</head>

<body>
    <form action="#" method="post">
        <div ondrop="drop(event)" ondragover="allowDrop(event)">
            <ul id="sortable1" class="droptrue">
                <?php

                foreach ($preguntas as $pregunta) {
                    echo '<li class="" id=' . $pregunta->getId() . '>' . $pregunta->getEnunciado_pregunta() . '</li>';
                }

                ?>
            </ul>
        </div>

        <div ondrop="drop(event)" ondragover="allowDrop(event)">
            <ul id="sortable2" class="dropfalse">

            </ul>
        </div>
        <br style="clear:both">

        <input type="submit" value="Enviar" name="enviar">
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
    }
}

?>