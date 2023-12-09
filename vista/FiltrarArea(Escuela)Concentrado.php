<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area (Escuela) Concetrado</title>
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
    include("menu.php");
    if(!ISSET($_SESSION["usuario"])){
        header("Location:login.php");
    }

?>
    <form action="">
        <div id="c1">
            <p id="m1">Filtrar busqueda</p>
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="select" name="select1">
                <option selected value="0">Filtrar por:</option>
                <option value="1">Periodo</option>
                <option value="2">Área</option>
                <option value="3">Servicio</option>
            </select>
            <input type="date" class="form-control-sm" id="f1" hidden = true name="fecIni">
            <input type="date" class="form-control-sm" id="f2" hidden = true name="fecFin">
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="area" hidden=true name="select2">
                <option selected>Selecciona una Área</option>
                <option value="1">Ing. Sistemas Computacionales</option>
                <option value="2">Ing. Industrial</option>
                <option value="3">Ing. Ambiental</option>
                <option value="4">Ing. Electrónica</option>
                <option value="5">Ing. Gestión Empresarial</option>
                <option value="6">Ing. Sistemas Automotrices</option>
                <option value="7">Gastronomía</option>
            </select>
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="servicio" hidden=true name="select3">
                <option selected>Selecciona un servicio</option>
                <option value="1">Sala general</option>
                <option value="2">Cubículos de estudio</option>
                <option value="3">Sala audiovisual</option>
                <option value="4">Visita guiada</option>
                <option value="5">Computadoras</option>
            </select>
            <button id="btnFiltro" class="btn btn-primary">Filtrar</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/fun.js"></script>
</body>
</html>