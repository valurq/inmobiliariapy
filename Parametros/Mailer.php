
<?php
/*
	NOTA IMPORTANTE: no se hace el require de conexion.php porque se supone que ya debe estar 
	requerido antes de llamar a esta clase aun si se usase esta clase mediante cron
 */
require "class.phpmailer.php";
require "class.smtp.php";
class Mailer extends Consultas{
	private $config = array();
	private $currentMailer = null;
	private $lastError = "";

	//llama al cnstructor de consultas y este a su vez al constructor de conexion
	public function __construct(){
		parent::__construct();
	}

	//retorna TRUE si la configuracion fue cargada correctamente y FALSE si la 
	//no se pudo cargar
	public function loadRemoteConfig($id_conf = "1"){
		$campos = array(
			"mail_host","mail_puerto","mail_usuario","mail_pass",
			"mail_desde","mail_from","mail_autentica"
		);
		$config = $this->consultarDatos($campos,"parametros","id",$id_conf);
		if(gettype($config)!="boolean"){
			$this->config = $config->fetch_assoc();
			$this->loadLocalConfig();
			return true;
		}else{
			$this->lastError = "No se pudieron obtener los parametros de la base de datos";
			$this->logError($this->lastError);
			return false;
		}
	}

	//funcion encargada de setear la configuracion indicada en las variables privadas 
	///de la clasa
	private function loadLocalConfig(){
		if(!empty($this->config)){
			$mailer = new PHPMailer();
			//el servidor de correo
			$mailer->Host = $this->config['mail_host']; //"smtp.gmail.com";  
			//el puerto usado para la conexion al server smtp
			$mailer->Port = $this->config['mail_puerto'];//587; 
			//el correo electronico (usuario) mediante el cual se accede al servidor
			$mailer->Username = $this->config['mail_usuario'];  
			//la clave del correo electrónico
			$mailer->Password = $this->config['mail_pass'];	
			//El nombre del remitente
			$mailer->FromName = $this->config['mail_from'];//"Valurq Mailer"; 
			//El correo del remitente
			$mailer->From = $this->config['mail_desde'];//"valurq@test.com"; 
			//Booleano para indicar para acceder al servidor smtp se necesita autenticacion 
			//(si esto es false no se usaran credenciales para acceder al smtp lo cual es absurdo en 
			//ambiente de produccion)
			$auth = ($this->config['mail_autentica']=="true")?true:false;
			$mailer->SMTPAuth = $auth; 
			//Se indica que el correo contiene html
			$mailer->isHTML(true);
			//EL charset del correo 
			$mailer->CharSet = "UTF-8";
			//Indicamos que el servidor de correo es del tipo SMTP
			$mailer->isSMTP();
			//Configuraciones relacionadas al certificacdo SSL (inseguro)
			$mailer->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false, //verifica el certificado ssl utilizado
					'verify_peer_name' => false, //algo relacionado a lo anterior supongo
					'allow_self_signed' => true //permite uso de certificados ssl self-signed (no valid en prod)
				)
			);
			//HABILITACION DE DEPURACION
			//Actualizamos el mailer configurado actualmente
			$this->currentMailer = $mailer;
		}
	}

	/* CONSTANTES EXTRAIDAS DE LA DOCUMENTACION
	SMTP::DEBUG_OFF: No output 
	SMTP::DEBUG_CLIENT: Client messages (Este es el default... creo)
	SMTP::DEBUG_SERVER: Client and server messages
	SMTP::DEBUG_CONNECTION: As SERVER plus connection status
	SMTP::DEBUG_LOWLEVEL: Noisy, low-level data output, rarely needed*/
	public function setDebugMode($debug_option){
		$mailer = $this->currentMailer;
		$mailer->SMTPDebug = $debug_option;
		$this->currentMailer = $mailer;
	}

	//los parametros obligatorios son $destinatarios,$cuerpo,$asunto
	public function sendMsj($destinatarios = array(), $cuerpo, $asunto, 
		$reply_to = "no-reply@system.sys", $ccs = array()){

		$mailer = $this->currentMailer; //instancia inicial del mailer

		if($mailer != null){
			//VALIDACIONES-----------------------------------------------
			if(empty($destinatarios) or empty($cuerpo) or empty($asunto)){
				$mailer->ErrorInfo = "No se han indicado todos los parametros 
				obligatorios para el envio de mensajes";
				$this->currentMailer = $mailer;
				$this->logError($this->getLastError());
				return false;
			}

			//DEFINICION DEL CUERPO--------------------------------------
			//$msjhtml = nl2br($cuerpo); //convierte saltos de linea en <BR>
			//{} --> Toma el contenido de la variable y no el nombre de la variable literalmente
			$mailer->Body = "{$cuerpo}"; 
			$mailer->AltBody = "{$cuerpo}";

			//DEFINICION DEL ASUNTO--------------------------------------
			$mailer->Subject = $asunto;

			//DEFINICION DE LOS DESTINATARIOS----------------------------
			foreach($destinatarios as $destinatario){
				$mailer->addAddress($destinatario);
			}

			//CON COPIA A------------------------------------------------
			foreach($ccs as $cc){
				$mailer->addCC($cc);
			}

			//INDICAR REPLY TO-------------------------------------------
			$mailer->addReplyTo($reply_to);

			//SE ENVIA EL MENSAJE Y SE RETORNA EL BOOLEANO OBTENIDO DE LA ACCION
			if($mailer->Send()){
				//logSuccess(); //crea un fichero que puede crecer mucho en el tiempo
				return true;
			}else{
				$this->logError($this->getlastError());
				return false;
			}
		}else{
			$this->lastError = "Se ha intentado enviar un mensaje sin definir 
			la configuracion del mailer";
			$this->logError($this->lastError);
		}
	}	

	//Debe ser inmediatamente llamado si sendMsj retorna FALSE
	public function getLastError(){
		$mailer = $this->currentMailer;
		if($mailer != null){
			return $mailer->ErrorInfo;
		}else{	
			return $this->lastError;
		}
	}

	//Funcion para registrar errores de la clase en un fichero
	public function logError($error){
		$currentTime = date("Y-m-d H:i:s",time());
		$strLog = ">> Mailer --> $error ($currentTime) |.-".PHP_EOL;
		$log = fopen("Parametros/MailerErrors.log","a");
		fwrite($log,$strLog);
		fclose($log);
	}

}


?>
