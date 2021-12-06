<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tematicas</title>
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
    </style>
</head>

<body>
    <header>
        <h1> Listado de Tematicas </h1>
    </header>
    <div>
        <!-- Table -->
        <table id='tematicasTabla' class='display dataTable'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tematica</th>
                    <th>Acciones</th>
                </tr>
            </thead>

        </table>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('#tematicasTabla').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'scripts/ajax_tematicas.php'
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'tema'
                    },
                ]
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