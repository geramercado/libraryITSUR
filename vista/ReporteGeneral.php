<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        #c1{
            background-color:green;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        #m1{
            margin-top:10px;
            margin-left:10px;
        }
        .form-select,form-select-sm{
            margin-right:10px;
        }
        p{
            color:white;
            font-size:medium;
            text-align: center;
            margin-right: 10px;
        }
        #btnFiltro{
            margin-right: 10px;
        }
        input{
            width: 200px;
        }
        #f2,#f1{
            margin-right: 10px;
        }
    </style>
</head>
<body>
<?php 
    require_once('../datos/DAOPrestamo.php');
    $dao=new DAOPrestamo();
    include("menu.php");
    if(!ISSET($_SESSION["usuario"])){
        header("Location:login.php");
    }
    $listaReportes;
    //Checar los datos que se mandan al hacer el subtmit
    if(ISSET($_POST["fecIni"])&&ISSET($_POST["fecFin"])){
        $listaReportes=$dao->obtenerReportes($_POST["fecIni"],$_POST["fecFin"]);
    }
?>
    <form method="post">
        <div id="c1">
            <p id="m1">Filtrar busqueda</p>
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="select" name="select1">
                <option value="1">Periodo</option>
            </select>
            <input type="date" class="form-control-sm" id="f1" name="fecIni">
            <input type="date" class="form-control-sm" id="f2" name="fecFin">
            <button id="btnFiltro" class="btn btn-primary">Filtrar</button>
        </div>
    </form>
      <div class="container">
        <table id="lista" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Cuenta</th>
                    <th>Usuario</th>
                    <th>Carrera</th>
                    <th>Servicio</th>
                    <th>Fecha inicio</th>
                </tr>
            </thead>
            <tbody>
              <?php
                foreach ($listaReportes as $reportes){
                  $i="";
                  switch ($reportes->tipo) {
                      case 1:
                          $i='Cubiculos de estudio';
                          break;
                      case 2:
                          $i='Computadoras';
                          break;
                      case 3:
                          $i='Sala audiovisual';
                          break;
                      case 4:
                          $i='Visita guiada';
                          break;
                      case 5:
                          $i='Acceso general';
                          break;
                  }
                  echo "<tr><td>".$reportes->no_cuenta."</td>".
                  "<td>".$reportes->nombre."</td>".
                  "<td>".$reportes->carrera."</td>".
                    "<td>".$i."</td>".
                    "<td>".$reportes->fecha_ini."</td>".  
                    "<td>".$reportes->hora_fin."</td>"; 
                }
              ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>