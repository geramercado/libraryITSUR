<?php
    $prestamo=new Prestamo();
    

    
    // va editar
    if(count($_POST)==1 && ISSET($_POST["id"]) && is_numeric($_POST["id"])){
        //Obtener la info del prestamo con ese id
        $dao=new DAOPrestamo();
        $prestamo=$dao->obtenerUno($_POST["id"]);
    }elseif(count($_POST)>1){
        $valMujeres=$valComputadora=$valEspacio=$valHombres="is-valid";
        $valNoCuenta=$valHoraIni=$valHoraFin="is-invalid";
        $valido=true;
        if($_POST["no_cuenta"]){
            $dao=new DAOPrestamo();
            $prestamo=$dao->existe($_POST["no_cuenta"]);
            if($prestamo){
                $valNoCuenta="is-valid";
            }
            else $valido=false;
        }
        else $valido=false;
        if($_POST["pc"]==0){
            $valComputadora="is-invalid";
            $valido=false;
        }
        if(isset($_POST["hora_ini"])){
            if(preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $_POST["hora_ini"])){
                $valHoraIni="is-valid";
            }
            else $valido=false;
        }
        else $valido=false;
        if(isset($_POST["hora_fin"])){
            if(preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $_POST["hora_fin"])){
                $valHoraFin="is-valid";
            }
            else $valido=false;
        }
        else $valido=false;
        if($prestamo==null){
            $prestamo=new Prestamo();
        }
        $prestamo->id=ISSET($_POST["id"])?$_POST["id"]:0;
        $prestamo->no_cuenta=ISSET($_POST["no_cuenta"])?trim($_POST["no_cuenta"]):0;
        $prestamo->no_hombres=0;
        $prestamo->no_mujeres=0;
        $prestamo->genero=="M"?$prestamo->no_mujeres=1:$prestamo->no_hombres=1;
        $prestamo->id_espacio=ISSET($_POST["espacio"])?trim($_POST["espacio"]):0;
        $prestamo->hora_ini=ISSET($_POST["hora_ini"])?trim($_POST["hora_ini"]):"";
        $prestamo->hora_fin=ISSET($_POST["hora_fin"])?trim($_POST["hora_fin"]):"";
        $prestamo->id_computadora=isset($_POST["pc"])?$_POST["pc"]:0;
        $prestamo->fecha_ini= date('Y-m-d');
        $prestamo->fecha_fin=date('Y-m-d');
        $prestamo->tipo=2;
        if($valido){
            if($_POST["hora_fin"]<$_POST["hora_ini"]){
                $valHoraFin="is-invalid";
                $valido=false;
            }
        }
        if($valido){
            $dao= new DAOPrestamo();
            //Guardar 
            //Crear un modelo prestamo con todos los datos
            //Usar el método agregar del dao
            if($prestamo->id==0){
                
                if($dao->agregar($prestamo)==0){
                    echo "Error al guardar";
                }else{
                    //Al finalizar el guardado redireccionar a la lista
                    echo "guardado";
                    header("Location: listaprestamos.php");
                }
            }else{
                if($dao->editar($prestamo)){
                    //Al finalizar el guardado redireccionar a la lista
                    header("Location: listaprestamos.php");
                }else{
                    echo "Error al guardar1";
                }
            }
        }
    }
?>