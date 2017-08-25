<?php
 require_once '../config/config.php';
 $mysqli = new mysqli(HOST, USER, PASS, DBNAME);
 $novedad = $_POST['id'];
 $sql = 'SELECT ruta FROM novedades WHERE id_novedad = ' . $novedad;
 $result = $mysqli->query($sql);
 $ruta = $result->fetch_object();
 $sql = 'DELETE FROM novedades WHERE id_novedad = ' . $novedad;
 if($mysqli->query($sql)) {
   unlink('../upload/noticias/'. $ruta->ruta);
 }
 echo '{datos: ok}';
 ?>
