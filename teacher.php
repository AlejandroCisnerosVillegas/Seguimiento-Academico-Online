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
  <script src="js/teacher.js"></script>
  
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
            <li class="active"><a href="teacher.php">Página principal</a></li>
            <li><a href="profile.php">Perfil</a></li>
            <li><a href="class.php">Gestor de asignaturas</a></li>
            <li><a href="statistics.php">Estadísticas</a></li>
            <li><a href="../../index.html" target="_blank">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+52552900215" target="_blank">Contacto</a></li>
			      <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br></br>
 
  <div class="container">
    <?php
      $name = $_SESSION['name'];
      $classes = $_SESSION['classes'];
      $teacher_id = $_SESSION['teacher_id'];
      echo '<h2>Saludos, '.$name.'.</h2>';
      echo '<div class="wrapper">';

      $n = new Node;
       
      if(!$classes) {
        echo '<h3 class="no-classes">¡Aún no has registrado ninguna asignatura!</h3>';
      } else { 
        echo '<h3 class="no-classes">Has clic en una asignatura para tomar asistencia</h3>';
        foreach($classes as $class_id) {
          $node = $n->retrieveObjecti($class_id,$teacher_id) or die("No existe registro ingresado");
          $code = $node->getCode();
          $section = $node->getSection();
          $year = $node->getYear();
          $numClasses = $node->getDays();
          $link = 'take.php?cN='.$class_id;
          echo '<div class="class"> 
            <button class="btn btn-danger delete-class-warning" data-toggle="modal" data-target=".delete-warning">&times;</button>
            <a class="no-decoration" href="'.$link.'">
            <div><strong>Clave</strong>: <span class="code">'.$code.'</span></div> 
            <div><strong>Modulo</strong>: <span class="section">'.$section.'</span></div> 
            <div><strong>Año</strong>: <span class="year">'.$year.'</span></div> 
            <div><strong>Núm. Clase</strong>: '.$numClasses.'</div> 
          </div></a>';
        }
      }
      echo '<div class="class" data-toggle="modal" data-target=".bs-example-modal-lg" id="addClass">
          <span class="glyphicon glyphicon-plus"></span>
        </div>
      </div>';   
    ?>
    
  </div>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addClass" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <h2 class="text-center">Registrar asignatura</h2>
          <hr>
            <div id="add_class_form">
              <select class="form-control" name="year">
              <?php foreach(range(date('Y',time()),2003) as $r) echo '<option>'.$r.'</option>'; ?>
              </select>
              <input class="form-control" name="code" placeholder="Clave (Ej. COE-322)">
              <select class="form-control" name="section">
              <option value="-1">Núm.de Modulo</option>
              <?php foreach(range(1,3) as $r) echo '<option>'.$r.'</option>'; ?>
              </select>
              <select class="form-control" name="semester">
              <option value="-1">Núm.de Semestre</option>
              <?php foreach(range(1,8) as $r) echo '<option>'.$r.'</option>'; ?>
              </select>
              <input class="form-control" name="start" placeholder="Matricula académica inicial (Ej. 201/ES/21)">
              <input class="form-control" name="end" placeholder="Matricula académica final (Ej. 220/ES/21)">
              <button class="btn btn-primary" id="add">Registrar</button>
              <button class="btn" id="cancel">Cancelar</button>
            </div>
        </div>
    </div>
  </div>
  <div class="modal fade delete-warning" tabindex="-1" role="dialog" aria-labelledby="delete-warning" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <h2 class="text-center">La asignatura con clave: <br> <span class="warning-class"></span> será eliminada</h2>
        <hr>
        <div class="text-center">
          <p>
          ¿Estás seguro de eliminar este registro?<br>
          El sistema le recuerda que no podrás deshacer esta acción.
          </p>
          <button class="btn btn-danger delete-class-code">Eliminar</button> <button class="btn btn-primary" onclick="$('.delete-warning').modal('hide');">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
 </body>
</html>