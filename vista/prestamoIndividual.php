<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body  >
<?php 
    include("menu.php");
    if(!ISSET($_SESSION["usuario"])){
        header("Location:login.php");
    }
    require_once('../datos/daoPrestamo.php');
    require_once('../datos/daoServicio.php');
    require_once('prestamoIndividualUtil.php');

    $dao=new DAOServicio();
    $listaCompuatadoras=$dao->obtenerComputadoras();

?>
    <div class="contenedorCarta">
        <div class="carta">
            <div class="text-center">
                <h4  class="mt-1 mb-5 pb-1">Prestamos Biblioteca</h4>
            </div>
            <form method="post">
                <input type="hidden" name="id" value="<?=$prestamo->id?>">
                <div class="form-outline mb-3">
                    <input type="text"  class="form-control  <?=$valNoCuenta?>" name="no_cuenta"
                    value="<?=$prestamo->no_cuenta ?>" required>
                    <label class="form-label ">N. Cuenta</label>
                    <?php
                        if($prestamo->nombre){
                            echo "<label class='form-label'>".$prestamo->nombre."</label>";
                        }
                    ?>
                    <div class="invalid-feedback">
                        <ul>
                            <li>No se encontro un n.cuenta asociado</li>
                        </ul>
                    </div>
                </div>
                <div class="form-outline mb-3">
                    <select class="form-select <?=$valComputadora?>" name="pc" readonly>
                        <option value="0">Elige una opcion</option>
                        <?php 
                            foreach($listaCompuatadoras as $pc){
                                echo "<option value=".$pc->id.">".$pc->nombre."</option>";
                            }
                        ?>
                    </select>
                    <label class="form-label" >PC</label>
                    <div class="invalid-feedback">
                        <ul>
                            <li>Debes elegir una pc</li>
                        </ul>
                    </div>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" class="form-control <?=$valHoraIni?>" name="hora_ini"
                    value="<?= $prestamo->hora_ini ?>" required>
                    <label class="form-label" >Hora de entrada</label>
                    <div class="invalid-feedback">
                        <ul>
                            <li>La hora debe cumplir con el formato HH:MM</li>
                        </ul>
                    </div>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" class="form-control <?=$valHoraFin?>" name="hora_fin"
                    value="<?= $prestamo->hora_fin ?>">
                    <label class="form-label" >Hora de salida</label>
                    <div class="invalid-feedback">
                        <ul>
                            <li>La hora debe cumplir con el formato HH:MM</li>
                            <li>La hora de entrada debe ser menor </li>
                            <li>o igual a la hora de salida</li>
                        </ul>
                    </div>
                </div>
                <div id="botonRegistrar" class="form-outline mb-3">
                    <button id="btnRegistrar" class="btn btn-primary text-white btn-block">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>