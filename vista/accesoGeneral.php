<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="body">
<?php 
    include("menu.php");
    if(!ISSET($_SESSION["usuario"])){
      header("Location:login.php");
    }
    require_once('../datos/daoUsuario.php');
    require_once('../datos/DAOPrestamo.php');
    $dao = new DAOPrestamo();
    $obj = new Prestamo();
    if(isset($_POST["no_cuenta"])){
      $obj=$dao->existe($_POST["no_cuenta"]);
      if($obj){
        if($dao->agregarGeneral($_POST["no_cuenta"],$obj->genero)){
          //echo "agregado";
        }
        else{
          //echo "no se pudo agregar";
        }
      }
    }
?>
    <div class="contenedorCarta" >
      <div class="carta2">
          <div class="card-body p-md-5 mx-md-4">
          <div class="text-center">
              <h4 class="mt-1 mb-5 pb-1">Acceso general</h4>
            </div>
            <form method="post">  
              <div class="form-outline mb-4">
                <input type="text" class="form-control"
                    name="no_cuenta"/>
                <label class="form-label">N. Cuenta</label>
                <?php
                        if($obj==null){
                            echo "<label class='form-label'>No existe</label>";
                        }
                        else echo "<label class='form-label'></label>";
                ?>
              </div>
              <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-primary text-white btn-block fa-lg gradient-custom-2 mb-3">Entrar</button>
              </div>
            </form>

          </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>