<?php
 require_once '../config/config.php';
 $mysqli = new mysqli(HOST, USER, PASS, DBNAME);
 $novedad = $_POST['id'];
 $sql = 'SELECT ruta FROM galeria WHERE id_galeria = ' . $novedad;
 echo $sql;
 $result = $mysqli->query($sql);
 $ruta = $result->fetch_object();
 $sql = 'DELETE FROM galeria WHERE id_galeria = ' . $novedad;
 if($mysqli->query($sql)) {
   unlink('../upload/galeria/'. $ruta->ruta);
 }
 echo '{datos: ok}';
 ?>
