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
	$idTipo=$_POST['optPago'];
	if($idTipo==2){
		$pago_parcial=$_POST['txtParcial'];
	}
	$id_usu=(int)@$_SESSION['id_usuario'];
	$idClub=$id_usu;
	$opcion=$_POST['optPago'];
    $nMeses=array("Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
 
////	echo"Pago: ".$valor." - Tipo de pago: ".$opcion;


$periodo=date("Y"); 
$mesActual=(int)date("m");
/////////////////////////
/////VALIDACIONES////////
/////////////////////////


/////////////////1- MES YA PAGO/////////////
$buscarId=mysqli_query($conexion,"select max(id) as idm from tbx_reg_pago where id_socio=".$idSocio."  and periodo=".$periodo);
$filaId=mysqli_fetch_array($buscarId, MYSQLI_ASSOC);
$Idm=(int)$filaId['idm'];
if($Idm>0){
$buscarMpago=mysqli_query($conexion,"select *  from tbx_reg_pago where id=".$Idm);
$filaP=mysqli_fetch_array($buscarMpago, MYSQLI_ASSOC);
$NmesP=(int)$filaP['mes'];
if($NmesP==$nMes){
	echo"El mes de ".$nMeses[$nMes]." registrá pago el ".$filaP['fecha'];
	exit();
}
}
/////////////////2- MES APLICA ABONO PREVIO/////////////

$buscarIdA=mysqli_query($conexion,"select max(id) as idA from tbx_reg_abono where id_socio=".$idSocio."  and periodo=".$periodo);
$filaA=mysqli_fetch_array($buscarIdA, MYSQLI_ASSOC);
$IdA=(int)$filaA['idA'];
if($IdA>0){
$buscarMabono=mysqli_query($conexion,"select *  from tbx_reg_abono where id=".$IdA);
$filaAb=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC);
$NmesA=(int)$filaAb['mes'];
if($NmesA==$nMes){
	echo"El mes de ".$nMeses[$nMes]." registrá abono previo.";
	exit();
}
}
/////////////////2- MES APLICA PAGO POR CLASE PREVIO/////////////
$buscarId=mysqli_query($conexion,"select max(id) as idm from tbx_reg_pago where id_socio=".$idSocio."  and periodo=".$periodo." and tipo_pago=1");
$filaId=mysqli_fetch_array($buscarId, MYSQLI_ASSOC);
$Idm=(int)$filaId['idm'];
if($Idm>0){
$buscarMpago=mysqli_query($conexion,"select *  from tbx_reg_pago where id=".$Idm);
$filaP=mysqli_fetch_array($buscarMpago, MYSQLI_ASSOC);
$NmesP=(int)$filaP['mes'];
if($NmesP==$nMes){
	echo"El mes de ".$nMeses[$nMes]." registrá pago por clase.";
	exit();
}
}

////////////////////////CONCEPTO DE PAGO PARA EL EMAIL//////////////////////////////////

if ($opcion==1){
	$Fpago="Pago total del mes";
}elseif($opcion==2){
	$Fpago="Pago parcial del mes";
}elseif($opcion==3){
	$Fpago="Pago de la Clase";
}
//////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////Consulta de datos base y descuentos//////////////////////////

$sQlCOnfig=mysqli_query($conexion,"select * from tcx_config where id_club=".$idClub);
$filaConf=mysqli_fetch_array($sQlCOnfig, MYSQLI_ASSOC);
$valmes=$filaConf['valmes'];
$valclase=$filaConf['valclase'];
$valextra=$filaConf['valmas'];
$xdias=$filaConf['maxdias'];
//cho"Valor del mes: ".$idClub;
////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////CONSULTAR DESCUENTOS APLICABLES AL SOCIO DEPORTISTA/////////////////////////////
$buscarD=mysqli_query($conexion,"select * from tcx_descuentox where id_Dep=".$idSocio." and ".$nMes." BETWEEN Minicio AND Mfin");
$filaD=mysqli_fetch_array($buscarD, MYSQLI_ASSOC);
$valAplica=$filaD['valor'];
$valmes=$valmes-$valAplica;
///INFORMACION DEL SOCIO DEPORTISTA////////////////////////////////////////////////////////////////	
$buscarE=mysqli_query($conexion,"select * from tbx_deportistas where id=".$idSocio);
	
$filaE=mysqli_fetch_array($buscarE, MYSQLI_ASSOC);
$Nombres=$filaE['nombres'];
$Apellidos=$filaE['apellidos'];
$email=$filaE['email'];




//////////////PROCESOS DEACUERDO AL TIPO DE PAGO///////////////////////////
if ($opcion==1){
	$Fpago="Pago total del mes";
	$SqlInsertPago = mysqli_query($conexion, "INSERT INTO tbx_reg_pago(id_club, id_socio, mes,tipo_pago, valor, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", ".$nMes." ,".$idTipo.", ".$valor.", '".$fecha."',".$periodo.")");

}elseif($opcion==2){////ABONOS		
	$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from  tbx_reg_abono where id_socio=".$idSocio."  and periodo=".$periodo." and mes=".$nMes);
	$filaSUM=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);
	$subTot=(int)$filaSUM['subtotal'];
	$saldo=$valMes-$subTot;
	$Nmes=(int)$filaAb['mes'];
	if($saldo<0){
			echo"El socio esta sobrepasando el valor a pagar, teniendo en cuenta el valor del saldo a pagar.";
			exit();

	}elseif($saldo==0){
		$SqlInsertPago=mysqli_query($conexion,"INSERT INTO  tbx_reg_abono(id_club, id_socio, estado, mes, valor, saldo, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", 0, ".$nMes." , ".$valor.",".$saldo.", '".$fecha."',".$periodo.")");
		$SqlInsertPago = mysqli_query($conexion, "INSERT INTO tbx_reg_pago(id_club, id_socio, mes,tipo_pago, valor, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", ".$nMes." ,".$idTipo.", ".$valor.", '".$fecha."',".$periodo.")");

	}elseif($saldo>0){
		$SqlInsertPago=mysqli_query($conexion,"INSERT INTO  tbx_reg_abono(id_club, id_socio, estado, mes, valor, saldo, fecha, periodo) VALUES(".$idClub.", ".$idSocio.", 1, ".$nMes." , ".$valor.",".$saldo.", '".$fecha."',".$periodo.")");
	
	}
}elseif($opcion==3){
	$Fpago="Pago de la Clase";
	$SqlInsertPago = mysqli_query($conexion, "INSERT INTO tbx_reg_pago(id_club, id_socio, tipo_pago, mes, valor, fecha, periodo) VALUES(".$idClub.", ".$idSocio.",".$idTipo.",".$nMes." , ".$valor.", '".$fecha."',".$periodo.")");

}
//////////////////////////////////////////////////////////////////////////





///////////////////////////////////////////////





//echo "opt: ".$opcion;

 		
//////////////////////////////////////////////////////////			
			
			
	if($SqlInsertPago==0){

		echo "No pudo registrarse el PAGO del  socio/deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  
$nomMes= $nMeses[$nMes];
$ValPay = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY );
$valor2=$ValPay->formatCurrency($valor, "COP");
			echo "Se Actualizo el PAGO del socio/deportista Satisfactoriamente.";
			
		//$correo="profe.erick.florez@gmail.com";
		$correo=$email;
		$subject = "Recibo de Pago";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .="From: info@taekwondocartagena.com". "\r\n";
		$headers .="Content-type:text/html;charset=UTF-8". "\r\n";
	
	
	ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
   // $to = $correo;
   $to ='profe.erick.florez@gmail.com';
   
    $message = "<b>REGISTRO DE APORTE MENSUAL</b>
				<p><b>Socio Afiliado:</b> ".$Nombres." ".$Apellidos."</p>
				<p><b>Fecha de Pago:</b> $fecha</p>
				<p><b>Tipo  de Pago:</b> $Fpago</p>
				<p><b>Mes:</b> $nomMes </p>
				<p><b>Valor:</b> $valor2</p>
				
	";
	
	
	
   // $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    
	  ///////////////////////////////////////
	 
			?>
		
		
		
		
		<?
			
			

		
	
		}

	
}
?>