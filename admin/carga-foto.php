<?php

require_once 'Imagen.php';
require_once '../config/config.php';
$mysqli = new mysqli(HOST, USER, PASS, DBNAME);

//$conexion	= new Sistema();
//$conexion	->conectar();
if(isset($_FILES['file-0'])) {
  $archivo		= $_FILES['file-0']['tmp_name'];
  $nmbr_lcl		= $_FILES['file-0']['name'];


  $extension	= strtolower(substr($nmbr_lcl,strripos($nmbr_lcl,".")+1));
  $nombreImagen = date('Ymd_His').'_'.rand (1000,9000).".".$extension;
  $ruta = '../upload/galeria/';
  $sql = "INSERT INTO galeria (ruta) VALUES('". $nombreImagen ."')";

  $obj_img	= new Imagen();
  $obj_img	->set("imagenOrigen"	, str_replace("\\","/",$archivo));		// Usamos el str_replace para mayor compatibilidad con distintos servidores
  $obj_img	->set("imagenDestino"	, $ruta . $nombreImagen);
  $obj_img	->set("anchoDestino"	, 960);
  $obj_img	->set("calidadImagen"	, 720);
  $obj_img	->set("generarArchivo"	, true);
  //$obj_img	->set("recorte",array('filas'	=> 3, 'columnas'	=> 2, 'centrado'	=>	3)); 	// true genera un archivo en el servidor False la envia para descargar en este caso no se puede enviar nada al servidor).
  $obj_img	->set("modo"			, 0);
  $obj_img	->set('archivoTmp'		, true);	// Si vamos a editarlo directamente de los temporales debemos indicarle que es temporal
  $obj_img	->set('borrarOrigen'	, true); 	// Se utiliza para borrar la imagen original del servidor. Si lo hacemos desde el temporal se puede dejar sin establecer.
  $obj_img	->procesarImagen();

  //Veo si todo salio bien o no
  if(!$obj_img->get("resultado"))
  {
    echo "Archivo 1:".$obj_img->get("mensaje")."<br />";
  } else {
    $mysqli->query($sql) or die();
    echo 'Ingreso correcto';
  }

}

      //header("Location: fotos_productos.php?id=" . $_POST['idproducto']);
 ?>
