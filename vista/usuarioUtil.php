<?php
    $usuario=new Usuario();
    
    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }   
    $valNombre=$valApe1=$valApe2=$valEmail=$valGenero=$valIntereses=$valFechaNac=$valTerminos=$valEstadoCivil=$valPassword="";
    if(count($_POST)==1 && ISSET($_POST["id"]) && is_numeric($_POST["id"])){
        //Obtener la info del usuario con ese id
        $dao=new DAOUsuario();
        $usuario=$dao->obtenerUno($_POST["id"]);
        
    }elseif(count($_POST)>1){
        $valNombre=$valApe1=$valApe2=$valEmail=$valGenero=$valIntereses=$valFechaNac=$valTerminos=$valEstadoCivil=$valPassword="is-invalid";
        $valido=true;
        if(ISSET($_POST["Nombre"]) && 
          (strlen(trim($_POST["Nombre"]))>3 && strlen(trim($_POST["Nombre"]))<51) &&
            preg_match("/^[a-zA-Z.\s]+$/",$_POST["Nombre"])){
            $valNombre="is-valid";
        }else{
            $valido=false;
        }
        if(ISSET($_POST["Apellido1"]) && 
          (strlen(trim($_POST["Apellido1"]))>3 && strlen(trim($_POST["Apellido1"]))<51) &&
            preg_match("/^[a-zA-Z.\s]+$/",$_POST["Apellido1"])){
            $valApe1="is-valid";
        }else{
            $valido=false;
        }
        if(ISSET($_POST["Apellido2"]) && 
          (strlen(trim($_POST["Apellido2"]))==0) ||
          (strlen(trim($_POST["Apellido2"]))>3 && strlen(trim($_POST["Apellido2"]))<51) &&
            preg_match("/^[a-zA-Z.\s]+$/",$_POST["Apellido2"])){
            $valApe2="is-valid";
        }else{
            $valido=false;
        }
        if(ISSET($_POST["Email"]) && 
            filter_var($_POST["Email"],FILTER_VALIDATE_EMAIL)){
            $valEmail="is-valid";
        }else{
            $valido=false;
        }
        if(ISSET($_POST["Password"]) && 
          (strlen(trim($_POST["Password"]))>=6 && strlen(trim($_POST["Password"]))<16)){
            $valPassword="is-valid";
        }else{
            $valido=false;
        }
        if(ISSET($_POST["fecha_nac"]) && validateDate($_POST["fecha_nac"])){
            $fNac=DateTime::createFromFormat('Y-m-d', $_POST["fecha_nac"]);
            $h = new DateTime();
            $dif = $h->diff($fNac)->y;
            var_dump($dif);
            if($dif>=18)
                $valFechaNac="is-valid";
            else $valido=false;
        }else{
            $valido=false;
        }
        if(ISSET($_POST["Genero"]) && 
          ($_POST["Genero"]=='M' || $_POST["Genero"]=='F')){
            $valGenero="is-valid";
        }else{
            $valido=false;
        }

        
        $usuario->id=ISSET($_POST["id"])?$_POST["id"]:0;
        $usuario->nombre=ISSET($_POST["Nombre"])?trim($_POST["Nombre"]):"";
        $usuario->apellido1=ISSET($_POST["Apellido1"])?trim($_POST["Apellido1"]):"";
        $usuario->apellido2=ISSET($_POST["Apellido2"])?trim($_POST["Apellido2"]):"";
        $usuario->fecha_nac=ISSET($_POST["fecha_nac"])?DateTime::createFromFormat('Y-m-d', $_POST["fecha_nac"]):new DateTime();
        $usuario->email=ISSET($_POST["Email"])?$_POST["Email"]:"";
        $usuario->genero=ISSET($_POST["Genero"])?$_POST["Genero"]:"M";
        $usuario->password=ISSET($_POST["Password"])?$_POST["Password"]:"";
        $usuario->puesto=ISSET($_POST["puesto"])?$_POST["puesto"]:"";
       // var_dump($_POST["puesto"][0]);

        if($valido){
            //Guardar 
            //Crear un modelo Usuario con todos los datos
        
            //Usar el método agregar del dao
            $dao= new DAOUsuario();
            if($usuario->id==0){
                if($dao->agregar($usuario)==0){
                    echo "Error al guardar 1";
                }else{
                    //Al finalizar el guardado redireccionar a la lista
                    echo "guardado";
                    header("Location: listaUsuarios.php");
                }
            }else{
                if($dao->editar($usuario)){
                    //Al finalizar el guardado redireccionar a la lista
                    header("Location: listaUsuarios.php");
                }else{
                    echo "Error al guardar";
                }

            }
        }

      }
?>