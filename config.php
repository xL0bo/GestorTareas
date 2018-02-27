<?php 


class Conexion extends PDO{

	private $nombre_de_base = 'pruebaNetberry';
	private $usuario = 'root';
	private $contrasena = ''; 

	public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
         parent::__construct('mysql:host=localhost;dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   	}

}


class Tarea{

   private $conexion;

   public function __construct(){
      $this->conexion = new Conexion();
   }

   public function add($tarea, $categorias){

      try{
         //insertamos la tarea en su tabla
         $this->conexion->query('INSERT INTO tareas (tarea) VALUES ("'.$tarea.'")');

         $idTarea = $this->conexion->lastInsertId();


         if($this->conexion->lastInsertId()){
            foreach(json_decode($categorias, true) as $categoria){  
               $this->conexion->query('INSERT INTO categorias (idTarea, categoria) VALUES ("'.$idTarea.'", "'.$categoria.'")');

               if(!$this->conexion->lastInsertId())
                  return "ERROR";
            }
         }else{
            return "ERROR";
         }

         return $idTarea;

      }catch(Exception $e){
         return $e->getMessage();
      }
   }

   public function delete($idTarea){
      try{

         $this->conexion->query("DELETE FROM tareas WHERE id = ".$idTarea);

         return "OK";
      }catch(Exception $e){
         return $e->getMessage();
      }
   }

   public function listar(){
      $datos = array();
      $arrayAux = array();

      $sql = $this->conexion->prepare("SELECT tareas.id as id, tareas.tarea as nombre, categorias.categoria as categoria FROM tareas INNER join categorias on tareas.id=categorias.idTarea");
      $sql->execute();

      foreach($sql->fetchAll(PDO::FETCH_OBJ) as $tarea){
         if(!in_array($tarea->id, $arrayAux)){
            $datos['datos'][] = array(
                           'id' => $tarea->id,
                           'nombre' => $tarea->nombre
                        );
            array_push($arrayAux, $tarea->id);
         }

         $datos['categorias'][$tarea->id][] = array(
                                    'categoria' => $tarea->categoria
                                    );   
      }
      return $datos;
   }

}
