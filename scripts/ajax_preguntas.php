<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "autoescuela";

//Crear Conexion
try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", "$username", "$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Unable to connect with the database');
}

## Leer los valores
$draw = $_POST['draw']; //Columnas
$row = $_POST['start']; //Filas
$rowperpage = $_POST['length']; // Filas disponibles por pagina
$columnIndex = $_POST['order'][0]['column']; // Indice de la Columna
$columnName = $_POST['columns'][$columnIndex]['data']; // Nombre de la Columna
$columnSortOrder = $_POST['order'][0]['dir']; // Ascendente o Descendente
$searchValue = $_POST['search']['value']; // Valor de la busqueda

$searchArray = array();

## Busqueda 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " AND (id LIKE :id or enunciado_pregunta LIKE :enunciado_pregunta or id_tematica LIKE :id_tematica ) ";
    $searchArray = array(
        'id' => "%$searchValue%",
        'enunciado_pregunta' => "%$searchValue%",
        'id_tematica' => "%$searchValue%",
    );
}

## Numero total de capturas filtradas
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM preguntas ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Numero total de capturas sin filtrar
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM preguntas WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Filas recuperadas
$stmt = $conn->prepare("SELECT * FROM preguntas WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Añadir los valores
foreach ($searchArray as $key => $search) {
    $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {
    $consulta = $conn->query("select * from tematica where id = $row[id_tematica]");
    $tema = $consulta->fetch();

    $data[] = array(
        "id" => $row['id'],
        "enunciado_pregunta" => $row['enunciado_pregunta'],
        "id_tematica" => $tema['tema'],
    );
}

## Repuesta
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
