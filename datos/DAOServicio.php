<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once ('../modelos/servicio.php'); 

class DAOServicio
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
    
   /** Obtener los espacios disponibles  */
   public function obtenerEspacios(){
        try
        {
            $this->conectar();
            
            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT numero, descripcion from catalogos.espacios where disponible=true and numero<=8");
            
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            
            foreach($resultado as $fila)
            {
                $obj = new Servicio();
                $obj->id=$fila->numero;
                $obj->nombre=$fila->descripcion;
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
   /** Obtener los computadoras disponibles  */
   public function obtenerComputadoras(){
        try
        {
            $this->conectar();
            
            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT idcomputadora, descripcion from catalogos.computadoras where disponible=true");
            
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            
            foreach($resultado as $fila)
            {
                $obj = new Servicio();
                $obj->id=$fila->idcomputadora;
                $obj->nombre=$fila->descripcion;
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

    

    
    

    

}