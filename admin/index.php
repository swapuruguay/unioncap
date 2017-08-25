<?php
  session_start();
  if(!isset($_SESSION['usuario'])) {
  header('Location:login.php');
}
?>

 <!DOCTYPE html>
<html>

<head>

<title>Union Capacitacion</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="apple-touch-fullscreen" content="no" />
        <meta name="author" content="MADANC">
   		<meta name="application-name" content="Union Capacitacion" />
		<meta name="keywords" content="" />

        <meta name="description" content="">
		<meta property="og:title" content="Union Capacitacion">
		<meta property="og:description" content="">
		<meta property="og:image" content="">
		<meta property="og:url" content="">
		<link rel="canonical" href="" />
		<link rel="alternate" hreflang="en" href="">
		<link rel="alternate" hreflang="pt" href="">




        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Rouge+Script" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Gentium+Basic:700i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<link rel="icon" type="image/png" sizes="35x35" href="img/logo.png">
        <link rel="stylesheet" type="text/css" href="css/estile.css"/>
       	<link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/style.css">
           <link media="all" rel="stylesheet" href="css/hover-min.css">
             <link media="all" rel="stylesheet" href="css/hover.css">
             <link media="all" rel="stylesheet" href="css/font-awesome.min.css">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <link rel='stylesheet' href="js/jquery.cleditor.css">
        <script src='js/jquery.cleditor.min.js'></script>



		 <style>

  .affix {
      top: 0;
      width: 100%;
	  z-index: 9999 !important;
	   background:rgba(0, 0, 0, 0.7);
      -webkit-transition: all .5s ease-in-out;
      transition: all .5s ease-in-out;

  }
  .affix-top {
      position: static;
      top: -35px;

  }
  .affix + .container-fluid {
      padding-top: 70px;
  }

  .logo{font-weight:bold}
  .slide{margin-top:-1.3%}
  .cuerpo {
    min-height: 70vh;

  }
  </style>


</head>

<body>
<!--<marquee>Inscribite hasta con un <strong>35%</strong> de descuento! Próximo comienzo 20 y 21 de agosto!</marquee>-->

<!-- Inicio menu -->
  <?php include 'menu.php'; ?>
<!-- fin menu -->
<div class="container cuerpo">


  <?php

  if(isset($_GET['mod'])) {
    $mod = $_GET['mod'];

    switch($mod) {
      case 'n':
        include 'novedades.php';
        break;
      case 'g':
        include 'galeria.php';
        break;
      case 'nn':
        include 'nueva-novedad.php';
        break;
      case 'ng':
        include 'nueva-foto.php';    
    }
  }


  ?>
</div>
  <footer>
    <div class="container" id="contact">
      <div class="row">
        <div class="container">
          <div class="col-lg-4 col-xs-12">
            <img src="img/LOGO.png" width="60%" class="img-responsive">
          </div>

        </div>
      </div>
    </div>
  </footer>

</body>
</html>
