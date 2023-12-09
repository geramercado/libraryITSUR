<?php
    $prestamo=new Prestamo();
    
    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }    
    
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
        if(($_POST["no_hombres"]<0 || $_POST["no_mujeres"]<0)|| 
        ($_POST["no_hombres"]==0 && $_POST["no_mujeres"]==0)){
            $valMujeres="is-invalid";
            $valido=false;
        } 
        if($prestamo==null){
            $prestamo=new Prestamo();
        }
        if($_POST["espacio"]>0){
            if($_POST["espacio"]>=1 && $_POST["espacio"]<=6)$prestamo->tipo=1;
            else if($_POST["espacio"]==7)$prestamo->tipo=3;
            else $prestamo->tipo=4;
        }
        else{
            $valido=false;
            $valEspacio="is-invalid";
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
        $prestamo->id=ISSET($_POST["id"])?$_POST["id"]:0;
        $prestamo->no_cuenta=ISSET($_POST["no_cuenta"])?trim($_POST["no_cuenta"]):0;
        $prestamo->no_hombres=ISSET($_POST["no_hombres"])?trim($_POST["no_hombres"]):0;
        $prestamo->no_mujeres=ISSET($_POST["no_mujeres"])?trim($_POST["no_mujeres"]):0;
        $prestamo->id_espacio=ISSET($_POST["espacio"])?trim($_POST["espacio"]):0;
        $prestamo->hora_ini=ISSET($_POST["hora_ini"])?trim($_POST["hora_ini"]):"";
        $prestamo->hora_fin=ISSET($_POST["hora_fin"])?trim($_POST["hora_fin"]):"";
        $prestamo->id_computadora=0;
        $prestamo->fecha_ini= date('Y-m-d');
        $prestamo->fecha_fin=date('Y-m-d');
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