<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once ('../modelos/prestamo.php'); 

class DAOPrestamo
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
			$sentenciaSQL = $this->conexion->prepare("SELECT p.id_prestamo,p.no_cuenta,u.nombre,
            p.no_hombres,p.no_mujeres,p.fecha_ini,p.fecha_fin,p.tipo FROM saci.prestamos p
            join catalogos.usuarios u on p.no_cuenta=u.no_cuenta");
			
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
			$sentenciaSQL->execute();
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
			
            foreach($resultado as $fila)
			{
				$obj = new Prestamo();
                $obj->id = $fila->id_prestamo;
	            $obj->no_cuenta = $fila->no_cuenta;
                $obj->no_hombres = $fila->no_hombres;
                $obj->no_mujeres = $fila->no_mujeres;
                $obj->tipo = $fila->tipo;
	            $obj->fecha_ini = $fila->fecha_ini;
	            $obj->fecha_fin = $fila->fecha_fin;
                $obj->nombre=$fila->nombre;
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
     * 
     * ver si existe el usuario
     */
    public function existe($noCuenta){
        try{
            $this->conectar();

            $obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT nombre,genero from  catalogos.usuarios WHERE no_cuenta=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$noCuenta]);
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if($fila){
                $obj = new Prestamo();
                $obj->nombre=$fila->nombre;
                $obj->genero=$fila->genero;
            }
            return $obj;

        }
        catch(Exception $e){
            return null;
        }
        finally{
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
            //SELECT id_prestamo,no_cuenta,no_hombres,no_mujeres,fecha_ini,fecha_fin,tipo FROM saci.prestamos where id=?"
			$sentenciaSQL = $this->conexion->prepare("SELECT p.id_prestamo,p.no_cuenta,
            u.nombre,p.no_hombres,p.no_mujeres,p.hora_ini,p.hora_fin,p.id_espacio FROM saci.prestamos p join catalogos.usuarios u
            on p.no_cuenta=u.no_cuenta  and id_prestamo=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
            $obj = new Prestamo();
            $obj->id = $fila->id_prestamo;
            $obj->no_cuenta = $fila->no_cuenta;
            $obj->no_hombres = $fila->no_hombres;
            $obj->no_mujeres = $fila->no_mujeres;
            $obj->hora_ini = $fila->hora_ini;
            $obj->hora_fin = $fila->hora_fin;
            $obj->id_espacio=$fila->id_espacio;
            $obj->nombre=$fila->nombre;

            
            return $obj;
		}
		catch(Exception $e){
            return null;
		}finally{
            Conexion::desconectar();
        }
	}

    /**
     * 
     * 
     * Acceso general
     */

     public function agregarGeneral($noCuenta,$genero)
     {
         $clave=0;
         
         try 
         {
             $sql = "INSERT INTO saci.prestamos
                 (no_cuenta,
                 no_hombres,
                 no_mujeres,
                 fecha_ini,
                 fecha_fin,
                 hora_ini,
                 hora_fin,
                 id_espacio,
                 id_computadora,
                 tipo)
                 VALUES
                 (:no_cuenta,
                 :no_hombres,
                 :no_mujeres,
                 :fecha_ini,
                 :fecha_fin,
                 :hora_ini,
                 :hora_fin,
                 :id_espacio,
                 :id_computadora,
                 :tipo);";
                 
             $this->conectar();
             $this->conexion->prepare($sql)
                  ->execute(array(
                     ':no_cuenta'=>$noCuenta,
                     ':no_hombres'=>$genero=="H"?1:0,
                     ':no_mujeres'=>$genero=="M"?1:0,
                     ':fecha_ini'=>date('Y-m-d'),
                     ':fecha_fin'=>date('Y-m-d'),
                     ':hora_ini'=>date('H:i'),
                     ':hora_fin'=>date('H:i'),
                     ':id_espacio'=>null,
                     ':id_computadora'=>null,
                     ':tipo'=>5));
                  
             $clave=$this->conexion->lastInsertId();
             return $clave;
         } catch (Exception $e){
             var_dump($e);
             return $clave;
         }finally{
             
             /*En caso de que se necesite manejar transacciones, 
             no deberá desconectarse mientras la transacción deba 
             persistir*/
             
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
            
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM saci.prestamos WHERE id_prestamo = ?");			          
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
	/**
     * Función para editar al empleado de acuerdo al objeto recibido como parámetro
     */
	public function editar(Prestamo $obj)
	{
		try 
		{
			$sql = "UPDATE saci.prestamos
                    SET
                    no_cuenta = ?,
                    no_hombres = ?,
                    no_mujeres = ?,
                    hora_ini = ?,
                    hora_fin = ?,
                    id_espacio = ?,
                    id_computadora = ?,
                    tipo = ?
                    WHERE id_prestamo = ?;";

            $this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare($sql);
			$sentenciaSQL->execute(
				array($obj->no_cuenta,
                      $obj->no_hombres,
                      $obj->no_mujeres,
					  $obj->hora_ini,
                      $obj->hora_fin,
                      $obj->id_espacio==0?null:$obj->id_espacio,
                      $obj->id_computadora==0?null:$obj->id_computadora,
                      $obj->tipo,
					  $obj->id)
					);
            return true;
		} catch (PDOException $e){
            var_dump($e);
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
    public function agregar(Prestamo $obj)
	{
        $clave=0;
        
		try 
		{
            $sql = "INSERT INTO saci.prestamos
                (no_cuenta,
                no_hombres,
                no_mujeres,
                fecha_ini,
                fecha_fin,
                hora_ini,
                hora_fin,
                id_espacio,
                id_computadora,
                tipo)
                VALUES
                (:no_cuenta,
                :no_hombres,
                :no_mujeres,
                :fecha_ini,
                :fecha_fin,
                :hora_ini,
                :hora_fin,
                :id_espacio,
                :id_computadora,
                :tipo);";
                
            $this->conectar();
            $this->conexion->prepare($sql)
                 ->execute(array(
                    ':no_cuenta'=>$obj->no_cuenta,
                    ':no_hombres'=>$obj->no_hombres,
                    ':no_mujeres'=>$obj->no_mujeres,
                    ':fecha_ini'=>$obj->fecha_ini,
                    ':fecha_fin'=>$obj->fecha_fin,
                    ':hora_ini'=>$obj->hora_ini,
                    ':hora_fin'=>$obj->hora_fin,
                    ':id_espacio'=>$obj->id_espacio==0?null:$obj->id_espacio,
                    ':id_computadora'=>$obj->id_computadora==0?null:$obj->id_computadora,
                    ':tipo'=>$obj->tipo));
                 
            $clave=$this->conexion->lastInsertId();
            return $clave;
		} catch (Exception $e){
            //var_dump($e);
			return $clave;
		}finally{
            
            /*En caso de que se necesite manejar transacciones, 
			no deberá desconectarse mientras la transacción deba 
			persistir*/
            
            Conexion::desconectar();
        }
	}

    //Reporte general
    public function obtenerReportes($fecha_ini, $fecha_ini1)
	{
		try
		{ 
            $this->conectar();
            $lista = array();
            
            //Almacenará el registro obtenido de la BD
            //SELECT id_prestamo,no_cuenta,no_hombres,no_mujeres,fecha_ini,fecha_fin,tipo FROM saci.prestamos where id=?"
			$sentenciaSQL = $this->conexion->prepare("SELECT p.no_cuenta, u.nombre, c.nombre as carrera, p.tipo, p.fecha_ini, p.hora_fin
            from saci.prestamos p join catalogos.usuarios u 
            on p.no_cuenta=u.no_cuenta join catalogos.carreras c
            on c.idcarrera=u.idcarrera where p.fecha_ini between ? and ?;"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([date("Y-m-d", strtotime($fecha_ini)), date("Y-m-d", strtotime($fecha_ini1))]);
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach($resultado as $fila)
			{
				$obj = new Prestamo();
                $obj->no_cuenta = $fila->no_cuenta;
                $obj->nombre = $fila->nombre;
                $obj->carrera = $fila->carrera;
                $obj->tipo = $fila->tipo;
                $obj->fecha_ini = $fila->fecha_ini;
                $obj->hora_fin = $fila->hora_fin;
				//Agrega el objeto al arreglo, no necesitamos indicar un índice, usa el próximo válido
                $lista[] = $obj;
			}
            
			return $lista;
		}
		catch(Exception $e){
           var_dump($e);
            return null;
		}finally{
            Conexion::desconectar();
        }
	}

    //ReporteGeneralConcentrado
    public function obtenerReportes2($fecha_ini, $fecha_ini1)
	{
		try
		{ 
            $this->conectar();
            $lista = array();
            
            //Almacenará el registro obtenido de la BD
            //SELECT id_prestamo,no_cuenta,no_hombres,no_mujeres,fecha_ini,fecha_fin,tipo FROM saci.prestamos where id=?"
			$sentenciaSQL = $this->conexion->prepare("SELECT 
            escuela.nombre AS carrera,
            prestamo.tipo AS servicio,
            SUM(prestamo.no_hombres) AS hombres,
            SUM(prestamo.no_mujeres) AS mujeres,
            SUM(prestamo.no_hombres) + SUM(prestamo.no_mujeres) AS total
        FROM
            saci.prestamos prestamo JOIN catalogos.usuarios usuario
            ON prestamo.no_cuenta = usuario.no_cuenta
            JOIN catalogos.escuelas escuela
            ON escuela.idescuela = prestamo.idescuela
        WHERE
            prestamo.fecha_ini BETWEEN ? AND ? 
        GROUP BY
            carrera, 
            servicio
        ORDER BY
              carrera, 
            servicio
            ;"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([date("Y-m-d", strtotime($fecha_ini)), date("Y-m-d", strtotime($fecha_ini1))]);
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach($resultado as $fila)
			{
				$obj = new Prestamo();
                $obj->carrera = $fila->carrera;
                $obj->servicio = $fila->servicio;
                $obj->hombres = $fila->hombres;
                $obj->mujeres = $fila->mujeres;
                $obj->total = $fila->total;
				//Agrega el objeto al arreglo, no necesitamos indicar un índice, usa el próximo válido
                $lista[] = $obj;
			}
            
			return $lista;
		}
		catch(Exception $e){
           var_dump($e);
            return null;
		}finally{
            Conexion::desconectar();
        }
	}


}

//