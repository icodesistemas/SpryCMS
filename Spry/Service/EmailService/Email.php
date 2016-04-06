<?php
	require_once 'ComponentEmail/PHPMailerAutoload.php';
	class ServiceMail extends PHPMailer{
		private $mail;
		private $EmailFrom;
		private $From_Name;
		private $file;
		public function __construct($conf){

			parent::__construct(true);
			$this->conf($conf);
		}
		private function conf($conf){

			if(strtoupper($conf["smtp"]) == "SI"){
				$this->IsSMTP();
				
			}else{
				$this->IsSendmail(); 
			}      
			$this->Host       = $conf["servidor"];
			$this->Port       = $conf["puerto"];
			if(!empty($conf["seguridad"])){
				$this->SMTPSecure = $conf["seguridad"];
			}
			
			$this->SMTPAuth   = true;    
			
			$this->Username   = $conf["usuario"];
			$this->Password   = $conf["clave"];
			//$this->Subject    = $xml->Subject;
			
			$this->IsHTML(true);

			$this->EmailFrom = $conf["correo"];
			$this->From_Name  = $conf["nombre"];

		}
		public function datosEmail($nombre, $correo){
			$this->EmailFrom = $correo;
			$this->From_Name  = $nombre;
		}
		public function sendEmail($email,$content,$Subject,$replay = "", $file = array()){
			//parent::mailReply = $replay;

			 try {
				$this->Subject    = utf8_decode($Subject);
				$body = utf8_decode($content);
				$this->SetFrom($this->EmailFrom, $this->From_Name); 
				$this->addAddress($email);
				
				if(count($file)>0){
					$this->AddAttachment($file[0],$file[1]);
				}

				$this->AltBody    = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!"; // optional, comment out and test
				$this->WordWrap   = 80; // set word wrap
				$this->MsgHTML($body);

				$this->Send();
				return true;
			} catch (phpmailerException $e) {
                 http_response_code(501);
                 json_encode(array("message" => $e->getMessage()));

				return false;
			}
		}
	}



?>
