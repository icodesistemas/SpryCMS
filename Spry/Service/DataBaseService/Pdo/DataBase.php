<?php
/**
 *   14/02/2014
 *   autor: Angel Bejarano
 *   Driver para conexiones de base de datos mysql y postgres
 */

class DataBase extends PDO{
	protected $fieldPK = "";
	private $semilla = "MTA5YjdjMjBmOGM4NjYwOGVlNTU3N2E5OWQwZjFjMWU=";
	private $driver;

	public function __construct($datosConexion,$persistent = true){
		$this->driver = $datosConexion["tipo"];
		$driver = $datosConexion["tipo"];
		$db = $datosConexion["nombre_base_datos"];
		$host = $datosConexion["servidor"];
		$dsn = "$driver:dbname=$db;host=$host";

		$nombre_usuario = $datosConexion["usuario"];
		$contrase_a =  $datosConexion["clave"];
		if($driver == "mysql"){
			$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => $persistent,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
		}else{
			$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => $persistent
			);
		}

		try{
			parent::__construct($dsn, $nombre_usuario, $contrase_a, $options);
			/*if($driver == "pgsql"){
				$this->setSchema($this->conf->schema);
			}*/

		}catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getArray($sql, $data = ""){
		//try{
		$stmt =parent::prepare($sql);

		if(empty($data)){
			$stmt->execute();
		}else{
			$stmt->execute($data);
		}
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $data;
		//}catch (PDOException $e) {
		//echo $e->getMessage();
		//}
	}

	public function getValue($sql, $data = ""){
		//try{
		$stmt =parent::prepare($sql);

		if(empty($data)){

			$stmt->execute();
		}else{
			$stmt->execute($data);
		}

		$rs = $stmt->fetchAll(PDO::FETCH_BOTH);
		$stmt->closeCursor();
		if(count($rs) > 0){
			return $rs[0][0];
		}else{
			return '';
		}

		//}catch (PDOException $e) {
		echo $e->getMessage();
		//}
	}
	public function getRow($sql, $data=""){
		$rs = $this->getArray($sql,$data);
		if(count($rs)>0){
			return $rs[0];
		}else{
			return 0;
		}

	}
	public function qqUpdate($table,$data){
		$table_data = $this->pairsColumnWithData($data, $table);

		$update = "update $table set ";
		$where = " where ";
		$i = 1;
		$arrayValue = "";
		$field  = "";
		if(!isset($table_data["PK"])){
			throw new PDOException("No se puede actualizar el registro por que no se halla definida la clave primaria");
			return false;
		}else{
			$where .= $table_data["PK"][0]. " = ?";
		}

		foreach ($table_data as $key => $val) {

			if($key  != "PK"){
				if(count($table_data) -1 > $i ){

					$field .= $val[0]." = ?,";
					$arrayValue .= $val[2]."***";
				}else{
					$field .= $val[0]." = ? ";
					$arrayValue .= $val[2];
				}
				$i++;
			}



		}
		$arrayValue .= "***".$table_data["PK"][2];
		$sql = $update.$field.$where;

		return $this->exec($sql,explode("***",$arrayValue));
	}
	public function qqInsert($table, $data){
		$table_data = $this->pairsColumnWithData($data, $table);
		$insert = "insert into $table ";
		$field = "(";
		$value = "values(";
		$arrayValue= "";
		$i = 1;

		foreach ($table_data as $key => $val) {
			if(count($table_data) > $i){
				if($i == 1){
					$value .= "?";
				}else{
					$value .= ",?";
				}
				$field .= $val[0].",";
				$arrayValue .= $val[2]."***";
			}else{
				if(count($table_data)>1){
					$field .= $val[0].")";
					$value .= ",?)";
					$arrayValue .= $val[2];
				}else{
					$field .= $val[0].")";
					$value .= "?)";
					$arrayValue .= $val[2];
				}

			}
			$i++;

		}

		$sql = $insert.$field." ".$value;

		return $this->exec($sql,explode("***",$arrayValue),"qqInsert", $table);

	}
	public function exec($sql, $data="", $action = "otro", $table = ""){
		/*echo $sql;
		echo" <pre>";
		print_r($data);
		echo" <pre>";
		*/
		if(empty($data)){
			return parent::exec($sql);
		}else{
			$stmt =parent::prepare($sql);
			//try{
			$stmt->execute($data);

			if($action == "qqInsert"){
				if(!empty($this->fieldPK)){
					$sql = "select max(".$this->fieldPK.") from $table";
					return $this->getValue($sql);
				}else{
					$rowCount = $stmt->rowCount();
					$stmt->closeCursor();
					return $rowCount;
				}

			}else{
				$rowCount = $stmt->rowCount();
				$stmt->closeCursor();
				return $rowCount;
			}
			//}catch(PDOException $e){
			//$error =  $e->getMessage();

			//throw new Exception($error);
			//}


		}
	}
	private function getFields($table){
		/* Obtener Conjunto de Campos de la Tabla */
		$COL = array();

		switch ($this->driver) {
			case 'pgsql':
				/*$sql = "select a.column_name as field,data_type as type, constraint_name as key
                        from information_schema.columns a left JOIN information_schema.key_column_usage b on a.COLUMN_NAME = b.column_name
                        where a.table_name = '".$table."'";*/
				$sql = "select a.column_name as Field,data_type as Type, constraint_name  as Key
						from information_schema.columns a LEFT JOIN information_schema.key_column_usage b on a.table_name = b.table_name and a.column_name = b.column_name
						where a.table_name = '".$table."'";
				break;
			case 'mysql':
				$sql = "SHOW COLUMNS FROM " . $table;
				break;
			default:
				throw new PDOException("El nombre del driver no esta definido");
				break;
		}

		$rsCol = parent::query($sql);

		if($this->driver == 'pgsql'){

			$rsCol = $this->getArray($rsCol->queryString);
		}


		foreach ($rsCol as $i => $row) {
			if($this->driver == 'pgsql'){
				$string = $row['key'];
				$var  = strpos($string,"pk");
				$var2 = strpos($string,"PRI");
				if($var !== false || $var2 !== false){
					$COL = array_merge($COL, array("PK" => array($row['field'],$row['type'])));
				}else{
					/* no me acuerdo para que esta el codigo del FK lo comente por que como ya existe el indice
					FK lo reemplaza. cuando una tabla tiene varios FK
					$var  = strpos($string,"fk");
	    			if($var !== false){
	    				$COL = array_merge($COL, array("FK" => array($row['field'],$row['type'])));
	    			}else{
	    				$COL = array_merge($COL, array("Field_".$i => array($row['field'],$row['type'])));
	    			}*/
					$COL = array_merge($COL, array("Field_".$i => array($row['field'],$row['type'])));
				}
			}elseif($this->driver == 'mysql'){
				$string = $row['Key'];
				$var  = strpos($string,"pk");
				$var2 = strpos($string,"PRI");
				if($var !== false || $var2 !== false){
					$COL = array_merge($COL, array("PK" => array($row['Field'],$row['Type'])));
				}else{
					$var  = strpos($string,"fk");
					if($var !== false){
						$COL = array_merge($COL, array("FK" => array($row['Field'],$row['Type'])));
					}else{
						$COL = array_merge($COL, array("Field_".$i => array($row['Field'],$row['Type'])));
					}
				}
			}



		}
		return $COL;

	}
	private function pairsColumnWithData($data,$table){

		if(!$table) {
			throw new PDOException("No se puede verificar los campos por que tabla no esta configurada");
			return false;
		}
		if(!is_array($data)) {
			throw new PDOException("La variable data debe ser una matriz asociativa");
			return false;
		}
		$structTable = $this->getFields($table);

		$arrayAssocc = array();

		/* checar si los campos pasados en el array $data existen en la estructura de la tabla y si existen asociar a esos campos su valor correspondiente */
		foreach ($structTable as $i => $val) {
			if($i == "PK"){
				$this->fieldPK = $val[0];
			}
			foreach ($data as $j => $value) {
				if($val[0] == $j){
					$arrayAssocc = array_merge($arrayAssocc, array($i => array($val[0],$val[1],$value)));
				}
			}
		}
		return ($arrayAssocc);
	}
	/** manejo de transacciones **/
	public function setBeginTrans(){
		parent::beginTransaction();
	}
	public function setCommit($commit){
		if($commit){
			parent::commit();
		}else{
			parent::rollBack();
		}
	}
}

?>