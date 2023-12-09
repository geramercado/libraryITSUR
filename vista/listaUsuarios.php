<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de registro ITSUR</title>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="dt/DataTables-1.13.6/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">

    <style>
        .btn-verde{
            background-color: rgb(8, 218, 148)!important;
        }
    </style>
</head>
<body>
      <?php
      require('menu.php');
      if(!ISSET($_SESSION["usuario"])){
        header("Location:login.php");
      }
      require_once('../datos/DAOUsuario.php');
      $dao=new DAOUsuario();

      if(ISSET($_POST["Id"]) && is_numeric($_POST["Id"])){
        //Eliminar
        if($dao->eliminar($_POST["Id"])){
          //echo '<script>eliminado()</script>';
        }else{
          //echo "No se pudo eliminar";
        }
      }
       // Asegúrate de iniciar la sesión antes de acceder a $_SESSION

// Imprimir todas las variables de sesión
      //print_r($_SESSION);

      $listaUsuarios=$dao->obtenerTodos();
      
      ?>
      <div class="container">
        <table id="lista" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Puesto</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
              <?php
                
                foreach ($listaUsuarios as $usuario){
                  echo "<tr><td>".trim($usuario->apellido1." ".$usuario->apellido2)." ".$usuario->nombre."</td>".
                           "<td>".$usuario->email."</td>".
                           "<td>".$usuario->puesto."</td>".
                           "<td><form method='post'>".
                              "<button formaction='usuario.php' class='btn btn-primary' name='id' value='".$usuario->id."'>Editar</button>".
                              "<button type='button' class='btn btn-danger' onclick='confirmar(this)' value='".$usuario->id."'>Eliminar</button>".
                            "</form></td></tr>";
                }
              ?>
                
            </tbody>
        </table>
    </div>
    <div class="modal" id="mdlConfirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Confirmar eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Está a punto de eliminar a <strong id="spnPersona"></strong> 
               ¿Desea continuar?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <form action="" method="post">
              <button type="submit" class="btn btn-danger"  data-bs-dismiss="modal" name="Id" id="btnConfirmar">Si, continuar con la eliminación</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="mdlEliminado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Eliminado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="dt/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="dt/DataTables-1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="dt/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="dt/Buttons-2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="dt/JSZip-3.10.1/jszip.min.js"></script>
    <script src="dt/pdfmake-0.2.7/pdfmake.min.js"></script>
    <script src="dt/pdfmake-0.2.7/vfs_fonts.js"></script>
    <script src="dt/Buttons-2.4.2/js/buttons.html5.min.js"></script>
    <script src="dt/Buttons-2.4.2/js/buttons.print.min.js"></script>
    <script src="dt/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
    <script src="js/listaUsuarios.js"></script>
</body>
</html>