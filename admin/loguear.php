<?php

  session_start();
  require_once '../config/config.php';
  $mysqli = new mysqli(HOST, USER, PASS, DBNAME);
  $nombre = $_POST['nombre'];
  $password = md5($_POST['clave']);
  $sql = "SELECT * FROM usuarios WHERE nombre = '". $nombre ."' AND clave = '". $password ."'";
  //echo $sql;
  $result = $mysqli->query($sql);
  if($result->num_rows > 0) {
    $_SESSION['usuario'] = $result->fetch_object();
    header('Location: index.php');
  } else {
    header('Location: login.php');
    // echo $password;
  }
?>
