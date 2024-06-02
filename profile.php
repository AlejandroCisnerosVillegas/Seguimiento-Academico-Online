<?php
  session_start();
  $isIndex = 0;
  if(!(array_key_exists('teacher_id',$_SESSION) && isset($_SESSION['teacher_id']))) {
    session_destroy();
    if(!$isIndex) header('Location: index.php');
  }
?>
<?php include 'php/node_class.php'; ?>
<html>
 <head>
  <link rel="stylesheet" href="css/style.css"/>
  <title>Seguimiento académico online</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/profile.js"></script>
  
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
            <li><a href="teacher.php">Página principal</a></li>
            <li  class="active"><a href="profile.php">Perfil</a></li>
            <li><a href="class.php">Gestor de asignaturas</a></li>
            <li><a href="statistics.php">Estadísticas</a></li>
            <li><a href="../../index.html" target="_blank">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+525529002158" target="_blank">Contacto</a></li>
			      <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br></br>
  
  <div class="container">
    <?php
      $name = $_SESSION['name'];
      $phone = $_SESSION['phone'];
      $email = $_SESSION['email'];
      $classes = $_SESSION['classes'];
      $teacher_id = $_SESSION['teacher_id'];
      echo '<h2>Perfil de: '.$name.':</h2><br>';
    ?>
    <div class="wrapper">
      <dl class="dl-horizontal">
        <dt>Nombre Completo: </dt>
        <dd>
          <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
          <input class="form-control" name="name" placeholder="Ingresa nombre completo" value="<?php echo $name; ?>">
          </div>
        </dd>
        <dt>Numero de teléfono: </dt>
        <dd>
          <div class="input-group">
          <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
          <input class="form-control" name="phone" placeholder="Ingresa numero de teléfono" value="<?php echo $phone; ?>">
          </div>
        </dd>
        <dt>Correo electrónico: </dt>
        <dd>
          <div class="input-group">
          <span class="input-group-addon">@</span>
          <input class="form-control" name="email" placeholder="Ingresa correo electrónico"  value="<?php echo $email; ?>">
          </div>
        </dd>
        <dt>Clases impartidas:</dt>
        <dd><?php echo $classes == 0? 0 : count($classes); ?></dd>
     </dl>
     <button class="btn btn-success update-profile">Registrar cambios</button>
    </div>
  </div>
 </body>
</html>
