<?php  
session_start();
	//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  
if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <?php
}  
else  
{  
    // Se ejecuta el ajax normalmente  
 
?>  
<?php
 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

$Nomclub=$_POST['txtNomclub'];
$idBarrio=$_POST['Barrio'];
$direccion=$_POST['txtdireccion'];
$correo=$_POST['txtCorreo'];
$resp=$_POST['txtresponsable'];
$cel1=$_POST['txtcelular1'];
$entrenador=$_POST['txtEntrenador'];
$cel2=$_POST['txtCelular2'];

$film="escudo.jpg";
$date = date("Y/m/d");
//echo $razonS."-".$Nnit."-".$Aproba;


 
 

 $sqlvacio = mysqli_query($conexion,"select id from tbx_club where nombre='".$Nomclub."'");
 
 $sqlsivacio=mysqli_num_rows($sqlvacio);


 if ($sqlsivacio==0){

   $SqlInsertClub = mysqli_query($conexion, "INSERT INTO tbx_club(nombre, id_barrio, direccion, entrenador, telefono, representante, cel, email, website, escudo, fec_reg, tipo_U) VALUES(upper('".$Nomclub."'),".$idBarrio.",'".$direccion."','".$entrenador."',".$cel2.",'".$resp."', ".$cel1.",'".$correo."','NO Aplica','".$film."', curdate(), 1)");
   
   if($SqlInsertClub!=0){
 echo "Registro del Club Satisfactoriamente! - ";
   $sqlultimo = mysqli_query($conexion,"select max(id) from tbx_club");
	   $fila=mysqli_fetch_array($sqlultimo, MYSQLI_NUM);
	   $idAsoc=$fila[0];
	   $num=((int)$idAsoc*345);
	   $pas=$idAsoc."Club".$idAsoc."@".$num;

	  $SqlSecurClub = mysqli_query($conexion, "INSERT INTO tbz1_usu(tipoU, id_asocc, nickz, pazz, fec_reg, estado) VALUES(1,".$idAsoc.",'".$correo."','".$pas."', curdate(), 0)");
	 

	
//////////////////////////////////////////////////////////////7
require '../../../libros/PHPMailer/src/Exception.php';
require '../../../libros/PHPMailer/src/PHPMailer.php';
require '../../../libros/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
try {
    #$mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
    $mail->isSMTP();
    $mail->Host = 'mail.erickdev.net';  // Host de conexión SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'contactos@erickdev.net';                 // Usuario SMTP
    $mail->Password = '3SP105E#LAA@..';                           // Password SMTP
    $mail->SMTPSecure = 'ssl';                            // Activar seguridad TLS
    $mail->Port = 465;                                    // Puerto SMTP

    #$mail->SMTPOptions = ['ssl'=> ['allow_self_signed' => true]];  // Descomentar si el servidor SMTP tiene un certificado autofirmado
    #$mail->SMTPSecure = false;				// Descomentar si se requiere desactivar cifrado (se suele usar en conjunto con la siguiente línea)
    $mail->SMTPAutoTLS = false;			// Descomentar si se requiere desactivar completamente TLS (sin cifrado)
 
    $mail->setFrom('contactos@erickdev.net');		// Mail del remitente
    $mail->addAddress($correo);     // Mail del destinatario
 
    $mail->isHTML(true);
    $mail->Subject = 'Registro en plataforma';  // Asunto del mensaje
    $mail->Body    = '
	<b>Su organización fue registrada con los siguientes datos</b>
<p><b>Fecha de Registro:</b> '.$date.'</p>
<p><b>Usuario:</b> '.$correo.' </p>
<p><b>Clave de acceso:</b> '.$pas.'</p>
<p><b>Correo electronico:</b> '.$correo.'</p>
	
	';    // Contenido del mensaje (acepta HTML)
    #$mail->AltBody = 'Este es el contenido del mensaje en texto plano';    // Contenido del mensaje alternativo (texto plano)
 
    $mail->send();
    echo 'El mensaje ha sido enviado!';
} catch (Exception $e) {
    echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
}
 
	  ///////////////////////////////////////
	 
include('pdir.php');
 
   }else{
   echo"Se ha perdido la conexión de los datos, intentelo nuevamente";
   }
 }else{
echo "Imposible Crear";
 $CantInfo=0;

 }
?>
<?
}
?>