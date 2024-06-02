<?php
  session_start();
  $isIndex = 1;
  if(array_key_exists('teacher_id',$_SESSION) && isset($_SESSION['teacher_id'])) {
   header('Location: teacher.php');
  } else {
    if(!$isIndex) header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html>
 <head>
  <link rel="stylesheet" href="css/style.css"/>
  <title>Seguimiento académico online</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/login.js"></script>
   
  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo-grande.png" rel="apple-touch-icon">

  <link href="navbar-fixed-top.css" rel="stylesheet">
 </head>
 <body>
 
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Barra de navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" style="color: #EEEFF5;">Seguimiento Académico Online</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Inicio</a></li>
            <li><a href="../../index.html" target="_blank">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+525529002158" target="_blank">Contacto</a></li>
          </ul>
        </div>
      </div>
    </nav>

  <div class="container"><br><br><br>
    <h4>Presiona aqui para solicitar <a href="student.php">expediente de estudiante.</a></h4>
    <hr>
    <h2>División académica</h2>
    <div class="alert alert-warning hidden">
      <span></span>
      <button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
    </div>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Iniciar Sesión</th>
          <th>Registrarse en el sistema</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <form id="login">
              <div class="form-group">
                <label>Correo electrónico</label>
                <input class="form-control" placeholder="Dirección electrónica" type="email" name="email">
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input class="form-control" placeholder="Código de acceso" type="password" name="password">
              </div>
              <button class="btn btn-primary pull-right">Iniciar sesión</button>
            </form>
          </td>
          <td>
            <form id="signup">
              <div class="form-group">
                <label>Nombre completo:</label>
                <input class="form-control" placeholder="Ingresa tu nombre" type="text" name="name">
              </div>
              <div class="form-group">
                <label>Numero telefónico:</label>
                <input class="form-control" placeholder="5512345678" type="text" name="phone">
              </div>
              <div class="form-group">
                <label>Correo electrónico:</label>
                <input class="form-control" placeholder="Dirección electrónica" type="email" name="email">
              </div>
              <div class="form-group">
                <label>Contraseña:</label>
                <input class="form-control" placeholder="Código de acceso" type="password" name="password">
                <span class="help-block">La contraseña debe contener 6 caracteres.</span>
              </div>
              <div class="form-group">
                <label>Verificar contraseña:</label>
                <input class="form-control" placeholder="Código de acceso" type="password" name="password2">
              </div>
              <button class="btn btn-primary pull-right">Registrar</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

 </body>
</html>