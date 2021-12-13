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
        $page = 0;
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
        $pregunta = DB::getAllQuestionsbyId($id_final);
        $preguntas[] = $pregunta;
    }
    $conn = null;

    $total_pages = count($partes) - 1;
    // var_dump($results);

    $no = $page > 1 ? $start + 1 : 1;

    $foto = $preguntas[$page][0]->getRecurso();
    ?>

    <div class="container">
        <h2 class="">Examen Por Hacer <span class="badge">Total Preguntas: <?= $total_results; ?></span></h2>

        <table class="table table-bordered">
            <form>
                <h3><?php echo ($preguntas[$page][0]->getEnunciado_pregunta()); ?> </h3>
                <section>Selecciona la respuesta correcta: <br>

                    <input type="radio" name="1">
                    <label for="respuesta_01"><?php echo ($respuestas[$page][0]->getEnunciado_respuesta()); ?> </label> <br>

                    <input type="radio" name="2">
                    <label for="respuesta_02"><?php echo ($respuestas[$page][1]->getEnunciado_respuesta()); ?> </label> <br>

                    <input type="radio" name="3">
                    <label for="respuesta_03"><?php echo ($respuestas[$page][2]->getEnunciado_respuesta()); ?> </label> <br>

                    <input type="radio" name="4">
                    <label for="respuesta_04"><?php echo ($respuestas[$page][3]->getEnunciado_respuesta()); ?> </label> <br>

                    <?php echo "<img src='data:image/png;base64,$foto' title='No dispone de imagen' width='400px'/>" ?>
                </section>
            </form>
        </table>
        <ul class="pagination">
            <li><a href="?id_examen=1">Primera Pregunta</a></li>

            <?php for ($p = 0; $p <= $total_pages; $p++) { ?>
                <li class="<?= $page == $p ? 'active' : ''; ?>"><a href="<?= '?id_examen=' . $id . '&page=' . $p; ?>"><?= $p; ?></a></li>
            <?php } ?>
            <li><a href="<?= '?id_examen=' . $id . '&page=' . $total_pages; ?>"> Ultima Pregunta</a></li>
        </ul>
    </div>

</body>

</html>