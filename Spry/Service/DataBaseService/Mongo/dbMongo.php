<?php
	/**
	*  Autor: Angel Bejarano 
	*  Email: programador.angel@gmail.com
	*  Date: 28/04/2015
	* Description: Clase para conexion insert, delete, update, select
	*   
	*/
	require_once 'coreMongo.php';

	class dbMongo extends coreMongo{
		private $Query;
		private $conditionalOperators = array('>' => '$gt', 
			                                  '<' => '$lt', 
			                                  '>=' => '$gte',
			                                  '<=' => '$lte');

		private $logicalOperators =  array('and' => '$and', 
			                               'or' => '$or', 
			                               '!=' => '$ne',
			                               '!' => '$not',
			                               'in' => '$in',
			                               '=' => '',
			                               'like' =>'$regex');
		public function __construct($datosConexion){
			parent::__construct($datosConexion);
		}
		public function query($Query){
			$this->Query = $Query;
			return $this->searchTypeSentence();

		}
		private function getResult($rs){

			$result = array();
			$i = 0;
			foreach ($rs as $key => $value) {
				$result = array_merge((array)$result, array($i =>$value) );
				
				$i++;
			}

			return $result;
		}
		private function searchTypeSentence(){
			foreach ($this->Query as $key => $value) {
				switch (strtoupper($key)) {
					case 'SELECT':
						if(array_key_exists("limit",$this->Query) || array_key_exists("LIMIT",$this->Query)){
							return $this->getResult($this->createSelect("limit"));
						}else{
							return $this->getResult($this->createSelect());
						}

						break;
					case 'DELETE':
						return $this->setDelete();
						break;
					case 'UPDATE':
						return $this->setUpdate();
						break;
					case 'INSERT';
						return $this->setInsert();
						break;

					default:
						# code...
						break;
				}
			}
		}
		private function setInsert(){
			
			$db = $this->dbCurrent();
			$table = $this->$db->selectCollection($this->Query["table"]);
			try {

				$table->insert($this->Query["insert"]);
				return $this->Query["insert"]["_id"];
				
			}catch(MongoCursorException $e){
				
			}	
		}
		private function setUpdate(){

			$db = $this->dbCurrent();
			$table = $this->$db->selectCollection($this->Query["update"]);

			try {
				$wh = $this->createWhere($this->Query["where"]);
				$table->update($wh, array('$set' => $this->Query["value"]));
				return true;
			}catch(MongoCursorException $e){
				return false;
			}		
		}
		private function setDelete(){

			$db = $this->dbCurrent();
			$wh = $this->createWhere($this->Query["where"]);

			$table = $this->$db->selectCollection($this->Query["delete"]);
			try {
				$table->remove($wh, array("justOne" => true));
				return true;
			}catch(MongoCursorException $e){
				return false;

			}
		}
		private function createSelect($limit=false){
			$Tables = $this->Query["from"];
			$db = $this->dbCurrent();
			
			/* crear las condiciones */
			if(isset($this->Query["where"])){
				$wh = $this->createWhere($this->Query["where"]);
			}else{
				$wh = array();
			}
			
			/*$data = array(
								'user_full_name' =>'Otro',
								'user_email' => 'otro@oraculo.com',
								'user_profile' => 1,
								'user_status' => 'A'
						);
			
			$this->$db->$Tables->insert($data);*/	
			try{
				$table = $this->$db->selectCollection($Tables);
				$result = $table->find($wh, $this->Query["select"])->sort(array($this->Query["select"][0] => -1));
				if($limit){
					/*mejorar para los order by*/
					//$result = $result->sort(array($this->Query["select"][0] => 1));

					$cursor = iterator_to_array($result->limit($this->Query['limit']));
				}else{
					//$result = $result->sort(array($this->Query["select"][0] => 1));

					$cursor = iterator_to_array($result);
				}

				return $cursor;
			}catch(MongoCursorException $e){
				echo $e->getMessage();
			}
		}
		/* Reemplazar el operador recibido por un operador real de mongodb */
		private function searchOperatorMongodb($opr){
			foreach ($this->logicalOperators as $k => $val) {
				
				if(trim($opr) == $k){
					return $val;
				}
			}
		}
		private function createWhere($wh){
			$where = array();
			foreach ($wh as $key => $value) {
				$x = explode('{',$key);
				$operador = str_replace('}', '', $x[1]);
				$campoTabla = $x[0];

				/*if(is_array($value)){
					$valorCampo = $value[0];
					$siguienteOperador = $value[1];
				}else{
					$valorCampo = $value;
					$siguienteOperador = '';
				}*/
				$oprMongo = $this->searchOperatorMongodb($operador);
				
				switch ($oprMongo) {
					case '$or':
						if(is_array($value)){
							foreach ($value as $val) {
								$aux = array($campoTabla => $val);
								$where =  array_merge((array)$where, (array)$aux);
							}	
						}else{
							$aux = array($campoTabla => $value);
							$where =  array_merge((array)$where, (array)$aux);
						}
						
						break;
					case '':
						if(is_array($value)){
							$valorCampo = $value[0];
						}else{
							$valorCampo = $value;
							$siguienteOperador = '';
						}
						$where = array_merge((array)$where, array($campoTabla => $valorCampo));
						break;
					case '$in':	
						$where = array_merge((array)$where, (array)$value);
						break;
					case '$regex':	
						if(is_array($value)){
							$valorCampo = $value[0];
						}else{
							$valorCampo = $value;
						}					
						$where = array_merge((array)$where, array($campoTabla => array('$regex' => new MongoRegex("/^$valorCampo/i"))));
						
						break;
					default:
						# code...
						break;
				}
			/*	$var = explode(',', $key);
				if(empty($opr)){
					$where = array_merge($where, array($var[0] => $var[1]));
				}else{
					$where = array_merge($where, array("'".$opr."'" =>array($var[0] => $var[1])));	
				}
			*/	
			}
			
			return $where;
		}
		private function parcearConditions($wh){
			$conditions = array();
			foreach ($wh as $key => $value) {

				$aux = explode('{', $key);
				$operator = str_replace('}', '', $aux[1]);

				echo $aux;
			}
		}
		
	}	