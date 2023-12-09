<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once ('../modelos/usuario.php'); 

class DAOUsuario
{
    
	private $conexion; 
    
    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar(){
        try{
			$this->conexion = Conexion::conectar(); 
		}
		catch(Exception $e)
		{
			die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
		}
    }

    
    
   /**
    * Metodo que obtiene todos los usuarios de la base de datos y los
    * retorna como una lista de objetos  
    */
	public function obtenerTodos()
	{
		try
		{
            $this->conectar();
            
			$lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2,correo,puesto,genero FROM saci.usuarios");
			
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
			$sentenciaSQL->execute();
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
			
            foreach($resultado as $fila)
			{
				$obj = new Usuario();
                $obj->id = $fila->id;
	            $obj->nombre = $fila->nombre." ".$fila->apellido1." ".$fila->apellido2;
	            $obj->email = $fila->correo;
                $obj->puesto= $fila->puesto;
	            $obj->genero = $fila->genero;
				//Agrega el objeto al arreglo, no necesitamos indicar un índice, usa el próximo válido
                $lista[] = $obj;
			}
            
			return $lista;
		}
		catch(PDOException $e){
			return null;
		}finally{
            Conexion::desconectar();
        }
	}
    
    
	/**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($id)
	{
		try
		{ 
            $this->conectar();
            
            //Almacenará el registro obtenido de la BD
			$obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT *from saci.usuarios WHERE id=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
			
            $obj = new Usuario();
            
            $obj->id = $fila->id;
            $obj->nombre = $fila->nombre;
            $obj->apellido1 = $fila->apellido1;
            $obj->apellido2 = $fila->apellido2;
            $obj->fecha_nac = DateTime::createFromFormat('Y-m-d',$fila->fecha_nac);
            $obj->email = $fila->correo;
            $obj->genero = $fila->genero;
            $obj->puesto= $fila->puesto;
           
            return $obj;
		}
		catch(Exception $e){
            var_dump($e);
            return null;
		}finally{
            Conexion::desconectar();
        }
	}

    public function autenticar($correo,$password)
	{
		try
		{ 
            $this->conectar();
            
            //Almacenará el registro obtenido de la BD
			$obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2,puesto 
            FROM saci.usuarios WHERE correo=? AND 
            CAST(contrasenia as varchar(28))=CAST(sha224(?) as varchar(28))");
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$correo,$password]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
			if($fila){
                $obj = new Usuario();
                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
                $obj->puesto= $fila->puesto;
            }
            return $obj;
		}
		catch(Exception $e){
            //var_dump($e);
            return null;
		}finally{
            Conexion::desconectar();
        }
	}
    
    /**
     * Elimina el usuario con el id indicado como parámetro
     */
	public function eliminar($id)
	{
		try 
		{
			$this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM saci.usuarios WHERE id = ?");			          
			$resultado=$sentenciaSQL->execute(array($id));
			return $resultado;
		} catch (PDOException $e) 
		{
			//Si quieres acceder expecíficamente al numero de error
			//se puede consultar la propiedad errorInfo
			return false;	
		}finally{
            Conexion::desconectar();
        }

		
        
	}

    function calcularEdad($fechaNac){
        $h = new DateTime();
        return $h->diff($fechaNac)->y;
    }

	/**
     * Función para editar al empleado de acuerdo al objeto recibido como parámetro
     */
	public function editar(Usuario $obj)
	{
		try 
		{
			$sql = "UPDATE saci.usuarios
                    SET
                    nombre = ?,
                    apellido1 = ?,
                    apellido2 = ?,
                    fecha_nac = ?,
                    correo = ?,
                    genero = ?,
                    contrasenia = sha224(?),
                    puesto = ?
                    WHERE id = ?;";

            $this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare($sql);
			$sentenciaSQL->execute(
				array($obj->nombre,
                      $obj->apellido1,
                      $obj->apellido2,
					  $obj->fecha_nac->format('Y-m-d'),
                      $obj->email,
                      $obj->genero,
                      $obj->password,
                      $obj->puesto,
					  $obj->id)
					);
            return true;
		} catch (PDOException $e){
            //var_dump($e);
			//Si quieres acceder expecíficamente al numero de error
			//se puede consultar la propiedad errorInfo
			return false;
		}finally{
            Conexion::desconectar();
        }
	}

	
	/**
     * Agrega un nuevo usuario de acuerdo al objeto recibido como parámetro
     */
    public function agregar(Usuario $obj)
	{
        $clave=0;  
		try 
		{
            
                 $sql = "INSERT INTO saci.usuarios
                 (nombre,
                 apellido1,
                 apellido2,
                 fecha_nac,
                 correo,
                 genero,
                 contrasenia,
                 puesto)
                 VALUES
                 (:nombre,
                 :apellido1,
                 :apellido2,
                 :fecha_nac,
                 :email,
                 :genero,
                 sha224(:password),
                 :puesto);";
                 
             $this->conectar();
             $this->conexion->prepare($sql)
                  ->execute(array(
                 ':nombre'=>$obj->nombre,
                  ':apellido1'=>$obj->apellido1,
                  ':apellido2'=>$obj->apellido2,
                  ':fecha_nac'=>$obj->fecha_nac->format('Y-m-d'),
                  ':email'=>$obj->email,
                  ':genero'=>$obj->genero,
                  ':password'=>$obj->password,
                  ':puesto'=>$obj->puesto));
                 
            $clave=$this->conexion->lastInsertId();
            return $clave;
		} catch (Exception $e){
			return $clave;
		}finally{
            
            /*En caso de que se necesite manejar transacciones, 
			no deberá desconectarse mientras la transacción deba 
			persistir*/
            
            Conexion::desconectar();
        }
	}
}