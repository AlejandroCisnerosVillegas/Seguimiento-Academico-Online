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
  <script src="js/class.js"></script>

  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo-grande.png" rel="apple-touch-icon">

  <style>.form-control{display:inline-block !important; width: 185px !important; margin:5px !important;}.details{padding:5px 10px;margin-bottom:30px;border: 1px solid lightgrey;border-top: none;}}</style>
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
            <li><a href="profile.php">Perfil</a></li>
            <li class="active"><a href="class.php">Gestor de asignaturas</a></li>
            <li><a href="statistics.php">Estadísticas</a></li>
            <li><a href="../../index.html" target="_blank">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+52552900215" target="_blank">Contacto</a></li>
			      <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br>
  <div class="container">
    <h2>Gestor de asignaturas</h2>
    <?php
      $classes = $_SESSION['classes'];
      $teacher_id = $_SESSION['teacher_id'];
      if(!$classes) echo '<h4>¡Aún no has registrado ninguna asignatura!</h4>';
      else {
        foreach($classes as $class_id) {
          $n = new Node;
          $node = $n->retrieveObjecti($class_id,$teacher_id) or die("No existe registro ingresado");
          $code = $node->getCode();
          $section = $node->getSection();
          $year = $node->getYear();
          $semester = $node->getSemester();
          
          echo '<ul class="nav nav-tabs">
                  <li class="active"><a href="#"><strong>'.$code . ' ( '.$section.' ) , '.$year.'</strong></a></li>
                </ul>';
          echo '<div class="details" id="_'.$class_id.'_">';
          echo 'Clave: <input class="form-control" name="code" value="'.$code.'" placeholder="Clave (Ej. COE-322)">';
          echo 'Año: <input class="form-control" name="year" value="'.$year.'" placeholder="Ingresa el año">';
          echo 'Modulo: <input class="form-control" name="section" value="'.$section.'" placeholder="Núm.de Modulo">';
          echo 'Semestre: <input class="form-control" name="semester" value="'.$semester.'" placeholder="Núm.de Semestre">';
          echo '<button class="btn btn-success update">Registrar cambios</button>';
          echo '</div>';
        }
      }
    ?>
  </div>
 </body>
</html>
