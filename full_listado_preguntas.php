<?php
require_once "include/Sesion.php";
require_once "include/User.php";
Sesion::iniciar();
if (!Sesion::existe('usuario')) {
    header("Location: index.php");
} else {
    $usuario = Sesion::leer('usuario');
    if ($usuario->getRol() == "Usuario") {
        header("Location: full_listado_examenes.php");
    } else {
        echo " <section id='menu'>";
        echo "<ul>";
        echo " <li><a href='full_listado_usuarios.php'>Usuarios</a></li>";
        echo " <li><a href='full_listado_tematicas.php'>Tematicas</a></li>";
        echo " <li><a href='full_listado_preguntas.php'>Preguntas</a></li>";
        echo " <li><a href='full_listado_examenes.php'>Examenes</a></li>";
        echo "</ul>";
        echo "</section> ";
    }
}

if(isset($_POST['enviar'])) {
    header("Location: index.php");
    Sesion::destruir();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Preguntas</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/listado_preguntas.css">

    <!-- Datatable CSS -->
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <!-- jQuery Library -->
    <script src="jquery-3.3.1.min.js"></script>

    <!-- Datatable JS -->
    <script src="DataTables/datatables.min.js"></script>

    <style>
        html {
            background-image: url(img/webb.png);
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            min-height: 100%;
            position: relative;
        }

        form{
            margin: 15px;
        }

        h1 {
            text-align: center;
        }

        header {
            font-family: 'Oswald';
            font-size: 22px;
        }

        footer {
            text-align: center;
            background-color: rgb(172, 162, 162, 0.5);
            position: absolute;
            bottom: 0;
            padding: 5px;
            width: 98%;
        }

        a:hover {
            color: rgb(153, 125, 158);
        }

        section{
            margin: 30px;
        }

        a{
            color: brown;
        }

        a:hover{
            color: black;
        }

        a:visited{
            color: black; 
        }

        #menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        #menu ul a {
            display: block;
            color: black;
            text-decoration: none;
            font-weight: 400;
            font-size: 15px;
            padding: 10px;
            font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #menu ul li {
            position: relative;
            float: left;
            margin: 0;
            padding: 0;
        }

        #menu ul li:hover {
            background: #5b78a7;
        }

        #menu ul ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            padding: 0;
        }

        #menu ul ul li {
            float: none;
            width: 150px
        }

        #menu ul ul a {
            line-height: 120%;
            padding: 10px 15px;
        }

        #menu ul li:hover>ul {
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <h1> Listado de Preguntas </h1>
        <a href="alta_pregunta.php" class="button">Alta Pregunta</a>
        <a href="alta_masiva_preguntas.php" class="button">Alta masiva de Preguntas</a>
        <form method="post"><input type="submit" name="enviar" value="Cerrar Sesion"></form>
    </header>
    <div>
        <!-- Table -->
        <table id='preguntasTabla' class='display dataTable'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Enunciado</th>
                    <th>Tematica</th>
                </tr>
            </thead>

        </table>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('#preguntasTabla').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'scripts/ajax_preguntas.php'
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'enunciado_pregunta'
                    },
                    {
                        data: 'id_tematica'
                    },
                ]
            });

            $(document).on('click', '#preguntasTabla tr', function() {
                var table = $('#preguntasTabla').DataTable();
                var id = table.row(this).data().id;
                let editar = confirm("¿Deseas editar la pregunta con id " + id + "?");

                if(editar){
                    window.open("http://localhost/autoescuela/editar_pregunta?id="+ id, "_self");
                }
               
            });
        });
    </script>
    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter</a> <a href="facebook.com">Facebook</a> <a href="instagram.com">Instagram</a>
    </footer>
</body>

</html>