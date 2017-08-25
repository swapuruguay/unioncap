<?php
require_once '../config/config.php';

$mysqli = new mysqli(HOST, USER, PASS, DBNAME);

$sql = 'SELECT id_novedad, titulo FROM novedades';
$result = $mysqli->query($sql);
$data = [];

    while($row = $result->fetch_object()) {
      $data[] = $row;
    }


    $json = json_encode($data);
    echo $json;

?>
