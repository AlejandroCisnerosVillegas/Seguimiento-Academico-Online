<html>
 <head>
  <link rel="stylesheet" href="css/style.css"/>
  <title>Seguimiento académico online</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/c3.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/highcharts.js"></script>
  <script src="js/highcharts-exporting.js"></script>
  <script src="js/jquery.knob.js"></script>
  <script src="js/student.js"></script>

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
            <li class="active"><a href="index.php">Inicio</a></li>
            <li><a href="../../index.html">Acerca de nosotros</a></li>
            <li><a href="https://wa.me/+525529002158">Contacto</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br></br>

 <div class="container">
  <div id="output"></div>
  <form id="getAttendance">
    <div class="form-group">
      <label>Año de la asignatura:</label>
      <select name="year" class="form-control">
        <?php foreach(range(date('Y',time()),2003) as $r) echo '<option>'.$r.'</option>'; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Núm.de Modulo:</label>
      <select name="section" class="form-control">
      <option>1</option><option>2</option><option>3</option>	
    </select>
    </div>
    <div class="form-group">
      <label>Clave de asignatura:</label>
      <input type="text" class="form-control" name="code" placeholder="Clave (Ej. COE-322)">
      <span class="help-block">DDD-NNN en donde D: Departamento, N: Numero.</span>
    </div>
    <div class="form-group">
      <label>Matricula académica:</label>
      <input type="text" class="form-control" name="roll" placeholder=" (Ej. 201/ES/21)">
      <span class="help-block">NNN/DD/AA en donde N: Numero, D: Departamento, A: Año.</span>
    </div>
    <button class="btn btn-primary">Solicitar expediente</button>
  </form>
  </div>
  </div>

 </body>
</html>
