<?php
	/**
	*  Autor: Angel Bejarano 
	*  Email: programador.angel@gmail.com
	*  Date: 28/04/2015
	*  Description: Adminsitracion de base de datos nosql MondoDB, y funciones de
	*  backend de mongo, creaete user, create database, drops 
	*/
	

	class coreMongo extends MongoClient{
		private $dbCurrent;		
		private $user;
		private $pass;
		private $db;
		protected $server;
		private $puerto;

		public function __construct($datosConexion){
				$this->db = $datosConexion["nombre_base_datos"];
				$this->user = $datosConexion["usuario"];
				$this->pass = $datosConexion["clave"];
				$this->server = $datosConexion["servidor"];
				$this->puerto = $datosConexion["puerto"];

				$this->dbCurrent = $this->db;
				try{
					if(empty($this->user) && empty($this->pass)){
						parent::__construct($this->server, $this->db);
					}else{
						$array = array('username' => $this->user, 
							           'password' => $this->pass, 
							           'db' => $this->db);
						
						parent::__construct("mongodb://{$this->server}:{$this->puerto}",$array);	
					}
				}catch(MongoConnectionException $e){
					die($e->getMessage());
				}	

		}
		/*private function openFileConfigurate(){
			$fileConex = pathIsNow."/Permit/conf-conex-mongo.xml";
			$file = file_get_contents($fileConex);
			$file = str_replace("\v", "", $file);
			$xml = new SimpleXMLElement($file);
			
			$this->db 	  = $xml->database;
	        $this->server = $xml->srv;
	        $this->user   = $xml->userdb;
	        $this->pass   = $xml->passdb;
	        $this->puerto = $xml->puert;
			return true;
		}*/
		public function showDatabase(){
			$dbs = $this->listDBs();
			
		}
		public function dropDataBase($nameDB){
			$myDB = $this->selectDB($nameDB);
			$myDB->drop();
			//$this->drop();
		}
		
		public function searchTable($nameTable){
			$db = $this->selectDB($this->dbCurrent);
			$tables = $db->getCollectionNames();
			foreach ($tables as $key => $value) {
				if($value == $nameTable){
					return true;
				}
			}
			return false;
		}

		public function showTables(){
			$db = $this->selectDB($this->dbCurrent);

			$tables = $db->getCollectionNames();

			if(count($tables) < 1){
				echo 'No hay tablas';
			}else{
				return $tables;
				
			}
			
		}
		public function dropTable($nameTable){
			if(!$this->searchTable($nameTable)){
				return 'tabla "'.$nameTable.'" no existe';
			}
			$db = $this->selectDB($this->dbCurrent);
			$resp = $db->drop_collection($nameTable);
			
			if($resp['ok']){
				return 'Tabla eliminada con exito';	
			}else{
				return $resp['msg'];	
			}
			
		}
		
		/**
		* retorna verdadero o falso
		*/
		public function searchDataBase($nameDB){
			$dbs = $this->listDBs();
			$dbs = $dbs['databases'];


			foreach ($dbs as $key => $value) {
				if($value['name'] == $nameDB){
					return true;
				}
			}
			return false;
		}

		public function dbCurrent(){
			return $this->dbCurrent;
		}

		public function createTable($nameTable, $fieldPk = ''){
			if($this->searchTable($nameTable)){
				return 'Tabla "'.$nameTable.'" ya existe';
			}
			$db = $this->selectDB($this->dbCurrent() );
			$db->createCollection($nameTable);
			if(!empty($fieldPk)){
				try{
					$table = $this->database->$nameTable;
					$table->createIndex(array($fieldPk => 1), array('unique' => true));	
				}catch(MongoDuplicateKeyException $e){
					echo $e->getMessage();
				}
				
			}
			

			return 'Tabla creada con exito';
		}
		
	}