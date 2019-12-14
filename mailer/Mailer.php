
<?php
require "class.phpmailer.php";
require "class.smtp.php";
class Mailer{
	private $currentMailer = null;

	public function defaultSMTPConf(){
		$mailer = new PHPMailer();
		//el servidor de correo
		$mailer->Host = "smtp.gmail.com";  
		//el puerto usado para la conexion al server smtp
		$mailer->Port = 587; 
		//el correo electronico (usuario) mediante el cual se accede al servidor
		$mailer->Username = "";  
		//la clave del correo electrónico
		$mailer->Password = "";	
		//El remitente (aparece a la izquierda del asunto en gmail por ejemplo)
		$mailer->FromName = "Valurq Mailer"; 
		//destinatarios a los cuales se enviara el mensaje
		$mailer->From = "valurq@test.com"; 
		//Booleano para indicar para acceder al servidor smtp se necesita autenticacion 
		//(si esto es false no se usaran credenciales para acceder al smtp lo cual es absurdo en 
		//ambiente de produccion)
		$mailer->SMTPAuth = true; 
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
		//$mailer->SMTPDebug = 2;
		//Actualizamos el mailer configurado actualmente
		$this->currentMailer = $mailer;
	}
			

	//public function __construct($mailServer, $localConf = true, $dbconf_id = ""){
	public function __construct(){
		/*switch($mailServer){
			//actualmente habilitado y funcional
			case "smtp":
				if($localConf){
					defaultSMTPConf();
				}else{
					//loadConfFromDB($dbconf_id);
				}
				break;
			//Conozco, requiere un configuracion diferente al smtp (no implementado)
			case "sendmail":
				break;
			//Una especie de SMTP pero es tratado de forma distinta (???)
			case "qmail":
				break;
		}*/
	}

	public function sendMsj($destinatarios, $cuerpo, $asunto, $ccs = array(), 
		$reply_to = "no-reply@valur.es"){
		$mailer = $this->currentMailer;
		//DEFINICION DEL CUERPO--------------------------------------
		$msjhtml = nl2br($cuerpo); //convierte saltos de linea en <BR>
		//{} --> Toma el contenido de la variable y no el nombre de la variable literalmente
		$mailer->Body = "{$msjhtml}"; 
		$mailer->AltBody = "{$cuerpo}";
		//DEFINICION DEL ASUNTO--------------------------------------
		$mailer->Subject = $asunto;
		//DEFINICION DE LOS DESTINATARIOS----------------------------
		foreach($destinatarios as $destinatario){
			$mailer->addAddress($destinatario);
		}
		//CC--------------------------
		foreach($ccs as $cc){
			$mailer->addCC($cc);
		}
		//Se agrega a quien responder
		$mailer->addReplyTo($reply_to);
		//Se envia el mensaje, retorna un booleano que indica si se logro o no la operacion
		return $mailer->Send();
	}

	//Debe ser inmediatamente llamado despues del fallo
	public function getLastError(){
		return $this->currentMailer->ErrorInfo;
	}
}


?>
