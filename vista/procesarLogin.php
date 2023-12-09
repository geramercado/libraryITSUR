<?php
    require_once("../datos/DAOUsuario.php");
    
    //Revisar que lleguen los datos
    if(ISSET($_POST["correo"]) && ISSET($_POST["password"])){
        
        //Revisar en BD que esten correctas
        $dao=new DAOUsuario();
        $usuario=$dao->autenticar($_POST["correo"],$_POST["password"]);
        
        if($usuario){
            session_start();
            //session_destroy();
            //$_SESSION["mensajes"]="Hola";
            $_SESSION["usuario"]=$usuario->id;
            $_SESSION["nombre"]=$usuario->nombre." ".$usuario->apellido1;
            $_SESSION["puesto"]=$usuario->puesto;
            header("Location: home.php");
            //Borra una clave
            //UNSET($_SESSION["mensajes"]);
            return;
        }
    }
    header("Location: login.php");
    
?>