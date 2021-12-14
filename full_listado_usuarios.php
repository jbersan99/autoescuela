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
        echo " <li><a href='full_listado_usuarios.php'>Usuarios <i class='fas fa-users'></i></a></li>";
        echo " <li><a href='full_listado_tematicas.php'>Tematicas <i class='fas fa-folder-open'></i></a></li>";
        echo " <li><a href='full_listado_preguntas.php'>Preguntas <i class='fas fa-question'></i></a></li>";
        echo " <li><a href='full_listado_examenes.php'>Examenes <i class='fas fa-book-dead'></i></a> </li>";
        echo "</ul>";
        echo "</section> ";
    }
}

if (isset($_POST['enviar'])) {
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
    <title>Listado de Usuarios</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/listado_usuario.css">

    <!-- Datatable CSS -->
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <!-- jQuery Library -->
    <script src="jquery-3.3.1.min.js"></script>

    <!-- Datatable JS -->
    <script src="DataTables/datatables.min.js"></script>
    <script src="https://kit.fontawesome.com/978435c791.js" crossorigin="anonymous"></script>

    <style>
        html {
            background-image: url(img/webb.png);
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            min-height: 100%;
            position: relative;
        }

        form {
            margin: 15px;
        }

        h1 {
            text-align: center;
        }

        header {
            font-family: 'Oswald';
            font-size: 22px;
        }

        section {
            margin: 30px;
        }

        footer {
            padding-top: 15px;
            padding-bottom: 15px;
            margin-top: 35px;
            text-align: center;
            position: relative;
            left: 0;
            color: white;
            bottom: 0;
            width: 100%;
            background: rgb(2, 0, 36);
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
        }

        li:hover {
            transform: skew(10deg);
        }

        footer a {
            color: white;
        }

        a {
            color: black;
        }

        a:hover {
            color: indianred;
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

        input[type=submit] {
            color: white;
            width: 100px;
            padding: 5px;
            opacity: 0.6;
            background-color: rgb(48, 48, 209);
        }

        input[type=submit]:hover {
            color: white;
            width: 100px;
            padding: 5px;
            opacity: 1;
            background-color: rgb(48, 48, 209);
        }
    </style>
</head>

<body>
    <header>
        <h1> Listado de Usuarios </h1>
        <a href="alta_usuario.php" class="button">Alta Usuario <i class='far fa-plus-square'></i></a>
        <a href="alta_masiva_usuarios.php" class="button">Alta masiva de Usuarios <i class='far fa-plus-square'></i></a>
        <form method="post"><input type="submit" name="enviar" value="Cerrar Sesion"> <i class='fas fa-sign-out-alt'></i></form>
    </header>
    <div>
        <!-- Table -->
        <table id='usuariosTabla' class='display dataTable'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alumnos</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Examenes Realizados</th>
                    <th>Confirmado</th>
                </tr>
            </thead>

        </table>
    </div>
    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('#usuariosTabla').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'scripts/ajax_usuarios.php'
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'rol'
                    },
                    {
                        data: 'realizados'
                    },
                    {
                        data: 'confirmado'
                    },
                ]
            });


            $(document).on('click', '#usuariosTabla tr', function() {
                var table = $('#usuariosTabla').DataTable();
                var id = table.row(this).data().id;
                let editar = confirm("¿Deseas editar el usuario con id " + id + "?");

                if (editar) {
                    window.open("http://localhost/autoescuela/editar_usuarios?id=" + id, "_self");
                }

            });
        });
    </script>
    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter <i class="fab fa-twitter"></i></a> <a href="facebook.com">Facebook <i class="fab fa-facebook-square"></i></a> <a href="instagram.com">Instagram <i class="fab fa-instagram-square"></i></a>
    </footer>
</body>

</html>