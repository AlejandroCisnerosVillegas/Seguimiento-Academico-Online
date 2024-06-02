<?php
  $isIndex = 0;
  session_start();
  if(!(array_key_exists('teacher_id',$_SESSION) && isset($_SESSION['teacher_id']))) {
    session_destroy();
    if(!$isIndex) header('Location: index.php');
  }
?>
<?php include 'php/node_class.php'; ?>
<?php
  $teacher_id = $_SESSION['teacher_id'];
  $classes = $_SESSION['classes'];
  $name = $_SESSION['name'];
  
  if(!isset( $_GET['cN'] ) || empty( $_GET['cN'] )) {
    die('<h1>El registro ingresado no cumple los parámetros establecidos</h1>');
  }
  $class_id = $_GET['cN'];
  
  if(!in_array($class_id,$classes)) die( "No se ha encontrado registro." );

  $classNode = new Node;
  $node = $classNode->retrieveObjecti($class_id,$teacher_id) or die("No se ha encontrado registro.");

  $records = $node->getRecords();
?>
<html>
 <head>
  <link rel="stylesheet" href="css/style.css"/>
  <title><?php echo $name. ' - '.$node->getCode(). ' ('.$node->getSection().') '.$node->getYear(); ?></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <link href="../../assets/img/logo.png" rel="icon">
  <link href="../../assets/img/logo-grande.png" rel="apple-touch-icon">

  <link href="navbar-fixed-top.css" rel="stylesheet">
  <script>
    var numberOfDays = <?php echo $node->getDays(); ?>;
    var class_id = <?php echo $class_id;?>;
    var teacher_id = <?php echo $teacher_id; ?>;
  </script>
  <script src="js/take.js"></script>
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
      echo '<h1>Saludos, '.$name.'</h1>';
      echo '<h3>Clave de la asignatura: '.$node->getCode(). ' (Modulo: '.$node->getSection().') '.$node->getYear().'</h3>';
      echo '<h3>Clases impartidas: '.$node->getDays().'</h3>';
      echo '<button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Consultar guía</button> <button id="submit" class="btn btn-success">Registrar lista de asistencia</button>';
    ?>
    <div id="studentRecords">
    <?php
      foreach($records as $roll => $data) {
        echo '<div class="student-record">
          <span class="roll"><a href="student.php?roll='.str_replace("/","-",$roll).'&code='.$node->getCode().'&year='.$node->getYear().'&section='.$node->getSection().'">'.$roll.'</a></span>: 
          <span class="present">'.$data['present'].'</span>'.
          ' <button class="marker btn">A</button> <button class="btn btn-danger delete-roll" data-toggle="modal" data-target=".delete-warning">&times;</button>
        </div>';
      }      
    ?>
    </div>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <h2 class="text-center">Guía de navegación</h2>
          <hr>
          <ol class="text-left">
            <li>Presione en la matricula académica de cualquier estudiante para ver sus registros.</li>
            <li>El numero mostrado en el costado de la matricula, es el numero de asistencia que posee el alumno.</li>
            <li>Presione el botón <button class="btn">A</button> para marcar la asistencia del alumno.</li>
            <li>Presione el botón <button class="btn btn-success">P</button> si desea cancelar la asistencia del alumno.</li>
            <li>Al presionar el botón <button class="btn btn-danger">&times;</button> podrá eliminar la matricula del alumno.</li>
            <li>Para finalizar, presione el botón <button class="btn btn-success">Registrar Asistencia</button> para archivar la lista.</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="modal fade delete-warning" tabindex="-1" role="dialog" aria-labelledby="delete-warning" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <h2 class="text-center">El alumno con matricula: <span class="warning-roll"></span> será eliminado</h2>
          <hr>
          <div class="text-center">
            <p>
            ¿Estás seguro de eliminar este registro?<br>
            El sistema le recuerda que no podrás deshacer esta acción.
            </p>
            <button class="btn btn-danger delete-rollnumber">Eliminar</button> <button class="btn btn-primary" onclick="$('.delete-warning').modal('hide');">Cancelar</button>
          </div>
        </div>
      </div>
    </div> 
  </div>
 </body>
</html>
