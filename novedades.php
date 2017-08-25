<?php

require_once 'config/config.php';

$mysqli = new mysqli(HOST, USER, PASS, DBNAME);
$sql = "SELECT * FROM novedades WHERE estado = 1 ORDER BY id_novedad DESC";
$result = $mysqli->query($sql);


?>
<!DOCTYPE html>
<html lang="en-uy">

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

            <link rel="stylesheet" type="text/css" href="css/prettyPhoto.css"/>
          <script src="http://code.jquery.com/jquery-latest.js"></script>


           <script src="js/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" charset ="utf-8">
		 $(document).ready(function(){
			 $("a[rel^='PrettyPhoto']").prettyPhoto ();
			  });
		 </script>




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

  </style>


</head>

<body>
<!--<marquee>Inscribite hasta con un <strong>35%</strong> de descuento! Próximo comienzo 20 y 21 de agosto!</marquee>-->
 <nav class="navbar navbar-default" data-spy="affix" data-offset-top="197">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

     <a class="navbar-brand logo animated fadeInLeft retraso-2" href="#"><img src="img/LOGO.png" class="img-responsive"></a>
     <!-- <a class="navbar-brand logo" href="#"><img src="img/favicon.png" class="img-responsive"></a>-->
    </div>

       <div class=" collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav navbar-right ">

  <li><a class="active hvr-overline-from-left" href="index.html" >Inicio</a></li>
				  <li><a class="hvr-overline-from-left" href="index.html#nosotros">Nosotros</a></li>
				<li>
					<a class="hvr-overline-from-left" href="cursos.html">Cursos</a>

				</li>


			<li><a class="hvr-overline-from-left" href="novedades.php">Novedades</a></li>
            <li><a class="hvr-overline-from-left" href="galery.php">Galería</a></li>
            <li><a class="hvr-overline-from-left" href="index.html#contact">Contacto</a></li>
        </ul>


                  </div>  </div>
			</nav>


 </div>

<div class="container">
    <div class="row paddingtop">
      <h1 class="border-bottom " >NOVEDADES</h1>
      <?php while($row = $result->fetch_object()): ?>
      <div class=" paddingtop col-lg-12">
  			<div class="col-lg-4 col-xs-12">
       		<a href="upload/noticias/<?php echo $row->ruta ?>" rel="prettyPhoto[pp_gal]"><img src="upload/noticias/<?php echo $row->ruta ?>" class="rota" width="100%" height="auto" alt="" /></a>
       	</div>
       	<div class="col-lg-8 col-xs-12">
				  <h2><?php echo $row->titulo ?></h2>
           <p>
             <?php echo $row->cuerpo ?>
				  </p>
			  </div>
     </div>
   <?php endwhile ?>
  </div>





                     <footer>
    	<div class="container-fluid bg-gris paddingtop">
        	<div class="row">
            	<div class="container">
            	<div class="col-lg-4 col-xs-12">
                	<img src="img/LOGO.png" width="60%" class="img-responsive">
                 </div>
                <div class="col-lg-4 col-xs-12">

           		 </div>
             <div class="col-lg-4 col-xs-12">
               <div class="contentFoot">
 <div class="networks">
		<ul>
			<li class="facebook">
				<a href="https://www.facebook.com/">Facebook</a>
			</li>
			<li class="twitter">
				<a href="https://twitter.com/">Twitter</a>
			</li>
			<li class="instagram">
				<a href="https://www.instagram.com/">Instagram</a>
			</li>
			<li class="linkedin">
				<a href="https://www.linkedin.com/">Linkedin</a>
			</li>
			<li class="youtube">
				<a href="https://www.youtube.com/">Youtube</a>
			</li>
		</ul>
	</div>
    </div>
    <div class="text-right gris">
     <p ><span class="glyphicon glyphicon-map-marker"></span> Montevideo, Uruguay.</p>
	        <p ><span class="glyphicon glyphicon-phone"></span> 0000 0000/ 090 000 000</p>
	        <p><span class="glyphicon glyphicon-envelope"></span><a href="mailto:info@unioncapacitacion.com.uy">info@unioncapacitacion.com.uy </a> </p>
              </div>
              </div>
            </div>
         	</div>
          </div>
          </footer>

</body>
</html>
