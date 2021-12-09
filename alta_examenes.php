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
            background-color: grey;
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
    <form action="#" method="post" name="form" id="exam_form">
        <label for="descripcion"> Descripción <br>
            <input type="text" name="descripcion" value="<?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : ''; ?>"></input> <br>
        </label>
        <label for="duracion"> Duracion <br>
            <input type="number" name="duracion" value="<?php echo isset($_POST['duracion']) ? htmlspecialchars($_POST['duracion']) : ''; ?>"></input> <br>
        </label>
        <ul id="sortable1" class="droptrue">
            <?php

            foreach ($preguntas as $pregunta) {
                echo '<li class="" id=pregunta_' . $pregunta->getId() . '>' . $pregunta->getEnunciado_pregunta() . '</li>';
            }

            ?>
        </ul>

        <ul id="sortable2" class="dropfalse">

        </ul>
        <br style="clear:both">

        <input type="submit" value="Enviar" name="enviar" id="send">
    </form>
</body>

</html>

<script>
    $(document).on('click', '#send', function() {
        var li = document.querySelectorAll("ul#sortable2>li");
        let descripcion = document.forms["form"]["descripcion"].value;
        let duracion = document.forms["form"]["duracion"].value;
        let formu = new FormData();
        formu.append("descripcion", descripcion);
        formu.append("duracion", duracion);
        let ids = [];
        for (let i = 0; i < li.length; i++) {
            ids.push(li[i].id.split("_")[1]);
        }
        formu.append("ids", ids);
        if (descripcion != "") {
            if (duracion >= 20) {
                if (li.length >= 3) {
                    $('#exam_form').submit(function(e) {
                        e.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: 'scripts/ajax_alta_examen.php',
                            data: formu,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log(response);
                                if (response.success == "1") {
                                    alert("Funciona");
                                } else {
                                    alert('Invalid Credentials!');
                                }
                            }
                        });
                    });
                } else {
                    alert("Introduce más preguntas en el examen para crearlo");
                }
            } else {
                alert("Introduce una duración correcta para el examen");
            }
        } else {
            alert("Introduce una descripción correcta");
        }
    });
</script>