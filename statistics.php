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
  <script src="js/highcharts.js"></script>
  <script src="js/highcharts-exporting.js"></script>
  <script src="js/statistics.js"></script>
  
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
            <li><a href="profile.php">Perfil</a></li>
            <li><a href="class.php">Gestor de asignaturas</a></li>
            <li class="active"><a href="statistics.php">Estadísticas</a></li>
            <li><a href="../../index.html" target="_blank">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+525529002158" target="_blank">Contacto</a></li>
			      <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br></br>
 
  <div class="container">
    <div class="wrapper">
      <?php
        $classes = $_SESSION['classes'];
        $teacher_id = $_SESSION['teacher_id'];
        $n = new Node;
        if($classes != 0) {
          $data = array();
          foreach($classes as $c) {
            $node = $n->retrieveObjecti($c,$teacher_id) or die("No se encontró registro");

            $key = $node->getCode().' ( '.$node->getSection().' ) ,'.$node->getYear();
          
            $total_days = $node->getDays();
           
            $data[$key] = array("total"=>$total_days,"average"=>0,"detained"=>0);
            if($total_days)  {
              $detained = array();
              $sum = 0;
              $count = 0;
              foreach($node->getRecords() as $roll => $rec) {
                $sum += $rec['present'];
                $count++;
                if($rec['present']/$total_days < 0.5)  $detained[$roll] = (100*($rec['present']/$total_days));
              }
              $data[$key]['average'] = ($sum/($count));
              $data[$key]['detained'] = $detained;
            }
          }
          echo '<script> var data = '.json_encode($data).'; </script>';
          echo '<ul class="nav nav-tabs">
            <li class="active"><a href="#graph">Índice de asistencia general</a></li>
            <li><a href="#detained">Porcentaje de asistencia</a></li>
          </ul>
          <div class="content">
            <div id="graph">
            </div>
            <div id="detained">';
          foreach($data as $class => $d) {
            echo '<div class="classes">'.$class.' <span class="badge">'.($d['detained']==0?0:count($d['detained'])).'</span> <div class="list">';
            if($d['detained'] !=0)
              foreach($d['detained'] as $roll => $percent) {
                echo '<p>'.$roll.' ( '.$percent.' % )</p>';
              }
            echo '</div></div>';
          }
          echo '
            </div>
          </div>
          ';
        }
        else {
          echo "<h3>Aun no tienes listas de asistencia registradas en el sistema</h3>";
        }
      ?>
    </div>
  </div>
 </body>
</html>
