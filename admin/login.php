<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <title>Document</title>
  <style lang="css">
    
    .contenedor {
      border: solid 1px red;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      width: 100%;
    }

    .contenedor input {
      min-width: 300px;
    }


  </style>
</head>
<body>
  <div class="contenedor">
    <div>
      <form action="loguear.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
          <input type="text" class="form-control"  name="nombre"> 
        </div>
         
       <div class="form-group">
         <label for="clave">Clave</label>
          <input type="password" class="form-control" name="clave">
       </div>
           
    <input class="btn btn-primary" type="submit" value="Ingresar">
  </form>
    </div>
    
  </div>
  
</body>
</html>