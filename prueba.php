<!DOCTYPE html>
<html lang="es">

<head>
    <title>Test Examen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

    <?php
    include "include/DB.php";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "autoescuela";

    $limit = 50;

    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $s = $db->prepare("SELECT * FROM preguntas");
    $s->execute();
    $allResp = $s->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // var_dump($allResp);
    $total_results = $s->rowCount();
    $total_pages = ceil($total_results / $limit);

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }


    $start = ($page - 1) * $limit;

    $id = $_GET['id_examen'];

    $id_questions = DB::getQuestionfromExam($id);
    $partes = explode(",", $id_questions);

    for ($i = 0; $i < count($partes); $i++) {
        $id_final = $partes[$i];
        $respuesta = DB::getAllAnswerbyId($id_final);
        $respuestas[] = $respuesta;
    }
    $conn = null;

    $total_pages = count($partes);
    // var_dump($results);

    $no = $page > 1 ? $start + 1 : 1;


    ?>

    <div class="container">
        <h2 class="">Examen Por Hacer <span class="badge">Total Preguntas: <?= $total_results; ?></span></h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>enunciado_pregunta</th>
                    <th>Recurso</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['page'])){
                    $id_question = $_GET['page'];
                }
               
                for ($i = 0; $i < count($respuestas); $i++) {
                    var_dump($respuestas[$i]);
                    
                }
                ?>


            </tbody>
        </table>
        <ul class="pagination">
            <li><a href="?page=1">Primera Pregunta</a></li>

            <?php for ($p = 1; $p <= $total_pages; $p++) { ?>
                <li class="<?= $page == $p ? 'active' : ''; ?>"><a href="<?= '?id_examen=' .$id. '&page='. $p; ?>"><?= $p; ?></a></li>
            <?php } ?>
            <li><a href="?page=<?= $total_pages; ?>">Ultima Pregunta</a></li>
        </ul>
    </div>

</body>

</html>