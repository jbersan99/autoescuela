<!doctype html>
<html>
    <head>
        <title>Listado de Preguntas</title>
        <!-- Datatable CSS -->
        <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>

        <!-- jQuery Library -->
        <script src="jquery-3.3.1.min.js"></script>
        
        <!-- Datatable JS -->
        <script src="DataTables/datatables.min.js"></script>
        
    </head>
    <body >
        <div >
            <!-- Table -->
            <table id='usuariosTabla' class='display dataTable'>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Enunciado</th>
                    <th>Tematica</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                
            </table>
        </div>
        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#usuariosTabla').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'scripts/ajax_preguntas.php'
                },
                'columns': [
                    { data: 'id' },
                    { data: 'enunciado_pregunta' },
                    { data: 'id_tematica' },
                ]
            });
        });
        </script>
    </body>

</html>
