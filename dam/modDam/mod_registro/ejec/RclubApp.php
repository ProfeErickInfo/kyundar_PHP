<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Plataforma | Sikerjapp</title> 

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
<link href="biblio10/css/boots/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>



 


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!--------------------------------------------------------------->

<!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!--------------------------------------------------->
<!----------------------------------------------------------------->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!--------------------------------------------------->

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<?php 
//echo"si entra"; 
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
 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
/*
$Nomclub=$_POST['txtNomclub'];
$idBarrio=1;
$direccion=$_POST['txtdireccion'];
$correo=$_POST['txtCorreo'];
$resp=$_POST['txtresponsable'];
$cel1=$_POST['txtcelular1'];
$entrenador=$_POST['txtEntrenador'];
$cel2=$_POST['txtCelular2'];
*/

///--------------------------------------------------------------
$Nomclub=mysqli_real_escape_string($conexion,$_POST['nom']);
$Nomclub = filter_var($Nomclub, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$idBarrio=1;
///--------------------------------------------------------------
$direccion=mysqli_real_escape_string($conexion,$_POST['dir']);
$direccion = filter_var($direccion, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$correo=mysqli_real_escape_string($conexion,$_POST['correo']);
$correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
///--------------------------------------------------------------
$resp=mysqli_real_escape_string($conexion,$_POST['resp']);
$resp = filter_var($resp, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$cel1=mysqli_real_escape_string($conexion,$_POST['cel1']);
$cel1 = filter_var($cel1, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
$entrenador=mysqli_real_escape_string($conexion,$_POST['entre']);
$entrenador = filter_var($entrenador, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$cel2=mysqli_real_escape_string($conexion,$_POST['cel2']);
$cel2 = filter_var($cel2, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
//--------------VALIDACION FINAL---------------------------
if((empty($correo))||(empty($Nomclub))||(empty($direccion))||(empty($resp))||(empty($cel1))||(empty($entrenador))||(empty($cel2))){
  ?>
  <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
  <?php
  exit();
}


//----------------------------------------------------------
$film="escudo.jpg";
//echo "Telefonos: ".$cel1."-".$cel2."-";

 $urlx=$_SERVER ['SERVER_NAME']."/app.sikerjapp.com/dam/"; 
 
//echo "Ruta1".$urlx;

$sqlvacio = mysqli_query($conexion,"select id from tbx_club where nombre='".$Nomclub."'");
 
 $sqlsivacio=mysqli_num_rows($sqlvacio);


 if ($sqlsivacio==0){

   $SqlInsertClub = mysqli_query($conexion, "INSERT INTO tbx_club(nombre, id_barrio, direccion, entrenador, telefono, representante, cel, email, website, escudo, fec_reg, tipo_U) VALUES(upper('".$Nomclub."'),".$idBarrio.",'".$direccion."','".$entrenador."',".$cel2.",'".$resp."', ".$cel1.",'".$correo."','NO Aplica','".$film."', curdate(), 2)");
   
  // echo "INSERT INTO tbx_club(nombre, id_barrio, direccion, entrenador, telefono, representante, cel, email, website, escudo, fec_reg, tipo_U) VALUES(upper('".$Nomclub."'),".$idBarrio.",'".$direccion."','".$entrenador."',".$cel2.",'".$resp."', ".$cel1.",'".$correo."','NO Aplica','".$film."', curdate(), 2)";
    
   if($SqlInsertClub!=0){
	  //////////////////////////////////////////
    
	   $sqlultimo = mysqli_query($conexion,"select max(id) from tbx_club");
	   $fila=mysqli_fetch_array($sqlultimo, MYSQLI_NUM);
	   $idAsoc=$fila[0];
	   
	   $pas=$idAsoc."97861";

	  $SqlSecurClub = mysqli_query($conexion, "INSERT INTO tbz1_usu(tipoU, id_asocc, nickz, pazz, fec_reg, estado) VALUES(2,".$idAsoc.",'".$correo."','".$pas."', curdate(), 0)");
	  if($SqlSecurClub!=0){
	  
	ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
   

# ojo, es una concatenación:
    
    $from = "info@taekwondocartagena.com";
    $to = $correo;
    $subject = "Datos de Acceso Sikerjapp";
///////////////////////////////////////////////

// Cabecera que especifica que es un HMTL
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<!--[if gte mso 9]>
<xml>
  <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings>
</xml>
<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
  <title></title>
  
    <style type="text/css">
      @media only screen and (min-width: 520px) {
  .u-row {
    width: 500px !important;
  }
  .u-row .u-col {
    vertical-align: top;
  }

  .u-row .u-col-100 {
    width: 500px !important;
  }

}

@media (max-width: 520px) {
  .u-row-container {
    max-width: 100% !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .u-row .u-col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important;
  }
  .u-row {
    width: 100% !important;
  }
  .u-col {
    width: 100% !important;
  }
  .u-col > div {
    margin: 0 auto;
  }
}
body {
  margin: 0;
  padding: 0;
}

table,
tr,
td {
  vertical-align: top;
  border-collapse: collapse;
}

p {
  margin: 0;
}

.ie-container table,
.mso-container table {
  table-layout: fixed;
}

* {
  line-height: inherit;
}

a[x-apple-data-detectors="true"] {
  color: inherit !important;
  text-decoration: none !important;
}

table, td { color: #000000; } #u_body a { color: #0000ee; text-decoration: underline; }
    </style>
  
  

</head>

<body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
  <!--[if IE]><div class="ie-container"><![endif]-->
  <!--[if mso]><div class="mso-container"><![endif]-->
  <table id="u_body" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%" cellpadding="0" cellspacing="0">
  <tbody>
  <tr style="vertical-align: top">
    <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #e7e7e7;"><![endif]-->
    

<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
  <div style="height: 100%;width: 100% !important;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->
  
<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <h1 style="margin: 0px; color: #236fa1; line-height: 140%; text-align: center; word-wrap: break-word; font-size: 22px; font-weight: 400;"><strong>BIENVENIDO A SIKERJAPP</strong></h1>

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
  <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->
  
<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td style="padding-right: 0px;padding-left: 0px;" align="center">
      <a href="https://app.sikerjapp.com/log.html" target="_blank">
      <img align="center" border="0" src="../../../../biblio10/images/banner_dam.png" alt="" title="" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 480px;" width="480"/>
      </a>
    </td>
  </tr>
</table>

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
  <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
      <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->
      
<!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
<div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
  <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
  <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->
  
<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
    <p style="line-height: 140%;"><em>La plataforma para la gestión digital de la información de atletas en general.</em></p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
      <tr style="vertical-align: top">
        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
          <span>&#160;</span>
        </td>
      </tr>
    </tbody>
  </table>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
  
    <p style="line-height: 140%;">Sus datos de acceso son: Usuario: '.$correo.'  <span style="color: #169179; line-height: 19.6px;"><strong>- Contraseña: '.$pas.'</strong></span></p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <!--[if mso]><style>.v-button {background: transparent !important;}</style><![endif]-->
<div align="center">
  <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://app.sikerjapp.com/log.html" style="height:37px; v-text-anchor:middle; width:191px;" arcsize="11%"  stroke="f" fillcolor="#a246d1"><w:anchorlock/><center style="color:#FFFFFF;font-family:arial,helvetica,sans-serif;"><![endif]-->  
    <a href="https://app.sikerjapp.com/log.html" target="_blank" class="v-button" style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #a246d1; border-radius: 4px;-webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;font-weight: 700; ">
      <span style="display:block;padding:10px 20px;line-height:120%;"><span style="line-height: 16.8px;">Ingresar a Sikerjapp.</span></span>
    </a>
  <!--[if mso]></center></v:roundrect><![endif]-->
</div>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
      <tr style="vertical-align: top">
        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
          <span>&#160;</span>
        </td>
      </tr>
    </tbody>
  </table>

      </td>
    </tr>
  </tbody>
</table>

<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
  <tbody>
    <tr>
      <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
        
  <div style="font-size: 14px; line-height: 140%; text-align: center; word-wrap: break-word;">
    <p style="line-height: 140%;">Para obtener ayuda escribe al WhatsApp 3135613086</p>
  </div>

      </td>
    </tr>
  </tbody>
</table>

  <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
  </div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
      <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
    </div>
  </div>
</div>


    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    </td>
  </tr>
  </tbody>
  </table>
  <!--[if mso]></div><![endif]-->
  <!--[if IE]></div><![endif]-->
</body>

</html>

' ;
//$message = wordwrap($message,70);
 
////////////////////////////////////////////////

// Cabeceras adicionales
//$headers .= 'From: Recordatorio <tarifas@example.com>' . "\r\n";
//$headers .= 'Cc: archivotarifas@example.com' . "\r\n";
//$headers .= 'Bcc: copiaoculta@example.com' . "\r\n";

   //$message = "Usuario: ".$correo.", Clave de acceso: ".$pas;
    //$headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    
	  ///////////////////////////////////////
	  }else{
		// echo  "INSERT INTO tbz1_usu(tipoU, id_assoc, nickz, pazz, fec_reg, estado) VALUES(2,".$idAsoc.",'".$correo."','".$pas."', curdate(), 0)";
	  }
	  
	  
  ?>
 <p>&nbsp;</p>
<p>&nbsp;</p>
<div class="alert alert-success d-flex align-items-center" role="alert">
 <div>
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
 
  <strong>Se Registró al Invitado Correctamente, revise su correo para obtener los daros de acceso.No olvides revisar los SPAM!</strong> .
     
      </div>
    </div>
    <div class="row " > 
      <div class="form-group  col-md-5  " > <label>     </label>  
        
        <a class="btn btn-danger" href="<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" >REGRESAR </a>
      </div>  
    </div>     

 
 
   <meta http-equiv="Refresh" content="10; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" />
     <?php
            

   }else{
	  //  echo "ruta:".$urlx;
	   ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div>
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <strong>Presento dificultades en el registro comuniquese al 3135613086!</strong> .
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  <div class="row " > 
      <div class="form-group  col-md-5  " > <label>     </label>  
        
        <a class="btn btn-danger" href="<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" >REGRESAR </a>
      </div>  
    </div>  
  <meta http-equiv="Refresh" content="5; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" />
<?
  $CantInfo=0;
   }
			
 }else{
	 //echo "ruta:".$urlx;
 ?>
  
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div>
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <strong>resento dificultades en el registro, ya que este nombre fue usado con anterioridad. Por favor comuniquese al 3135613086!</strong> .
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  <div class="row " > 
      <div class="form-group  col-md-5  " > <label>     </label>  
        
        <a class="btn btn-danger" href="<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" >REGRESAR </a>
      </div>  
    </div>  
  <meta http-equiv="Refresh" content="5; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/log.html" />
<?
  $CantInfo=0;

 }

}
?>
</html>