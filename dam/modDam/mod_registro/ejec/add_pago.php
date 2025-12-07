<?PHP
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
session_start();
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

// obtenemos los datos del formulario.



	$nMes = $_POST['nMes'];
	$fecha = $_POST['txtFechaPago'];
	$valor = $_POST['txtVpago'];
	$idSocio = $_GET['idAsoc'];
	$id_usu=(int)@$_SESSION['id_usuario'];
	$idClub=$id_usu;
	$opcion=$_POST['optAbono'];

	

	 
	
	$buscarE=mysqli_query($conexion,"select * from tbx_deportistas where id=".$idSocio);
	
$fila=mysqli_fetch_array($buscarE, MYSQLI_ASSOC);
$Nombres=$fila['nombres'];
$Apellidos=$fila['apellidos'];
$email=$fila['email'];
if ($opcion==1){
	$Fpago="Pago Total";
}elseif($opcion==2){
	$Fpago="Abono";
}elseif($opcion==3){
	$Fpago="Pago de la Clase";
}


//echo "opt: ".$opcion;
if ($opcion==1){
///////////////////////////////////////////////////////////////
$periodo=date("Y");

$buscarPrevio=mysqli_query($conexion,"select * from reg_pago where id_socio=".$idSocio." and mes=".$nMes." and periodo=".$periodo);
$CantBP = mysqli_num_rows($buscarPrevio);
if($CantBP>0){
	$filaP=mysqli_fetch_array($buscarPrevio, MYSQLI_ASSOC);
    $fechaSi=$filaP['fecha'];
   echo"El mes seleccionado ya fue registrado en ".$fechaSi;
   exit();	
}
///////////////////////////////////////////////////////////////	
$SqlInsertPago = mysqli_query($conexion, "INSERT INTO reg_pago(id_club, id_socio, mes, valor, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", ".$nMes." , ".$valor.", '".$fecha."',".$periodo.")");
}else{
	$periodo=date("Y");

	$buscarAbono=mysqli_query($conexion,"select * from reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$Nmes);

$CantAB = mysqli_num_rows($buscarAbono);
	$SqlInsertPago=mysqli_query($conexion,"INSERT INTO  reg_abono(id_club, id_socio, mes, valor, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", ".$nMes." , ".$valor.", '".$fecha."',".$periodo.")");
	
	
	//$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$Nmes);
$filaAB=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);

}

/////////////////////////////////////////////////////////
/*$buscarMax=mysqli_query($conexion,"select MAX(id) AS mayor from tbx_infoxgrado where id_deportista=".$idDep);
$fila=mysqli_fetch_array($buscarMax, MYSQLI_ASSOC);

 $editar =mysqli_query($conexion,"UPDATE tbx_infoxgrado SET  ultimo=0 where id_deportista=".$idDep." and id<>".$fila['mayor']);
 
  $editar2 =mysqli_query($conexion,"UPDATE tbx_deportistas SET  id_grado=".$grado." where id=".$idDep);
  */ 
 		
//////////////////////////////////////////////////////////			
			
			
				if($SqlInsertPago==0)

	{

		echo "No pudo registrarse el PAGO del  socio/deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  

			

			echo "Se Actualizo el PAGO del socio/deportista Satisfactoriamente.";
			
		//$correo="profe.erick.florez@gmail.com";
		$correo=$email;
		$subject = "Recibo de Pago";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .="From: info@taekwondocartagena.com". "\r\n";
		$headers .="Content-type:text/html;charset=UTF-8". "\r\n";
	
	
	ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $to = $correo;
   
    $message = "<b>REGISTRO DE APORTE MENSUAL</b>
				<p><b>Socio Afiliado:</b> ".$Nombres." ".$Apellidos."</p>
				<p><b>Fecha de Pago:</b> $fecha</p>
				<p><b>Tipo  de Pago:</b> $Fpago</p>
				<p><b>Mes:</b> $nMes </p>
				<p><b>Valor:</b> $valor</p>
				
	";
	
	
	
   // $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    
	  ///////////////////////////////////////
	 
			?>
		
		
		
		
		<?
			
			

		
	
		}

	
}
?>