<?php

//Codigo de  conexion

@$nomBD="edev_klubd3025";
@$nomhost="localhost";
@$nomuser="edev_gestionador3025";
@$nomclave="C0n3Kt@rRok#O0NK3r@r";




/*
Edev_yellowp1
Usu: edev_rubikmaster
Pas: P0s1ll0Volt3@D056




@$nomBD="damdb21";
@$nomhost="localhost";
@$nomuser="root";
@$nomclave="";


@$nomBD="damdb21";
@$nomhost="localhost";
@$nomuser="damU21";
@$nomclave="Du2198@..";

$conexion=mysql_connect($nomhost, $nomuser, $nomclave) or die('No se pudo conectar su red ha sido bloqueda momentaneamente: ' . mysql_error());
mysql_select_db($nomBD)or die('No se pudo seleccionar la base de datos, su red ha sido bloqueda momentaneamente');

//echo "Local:".$conexion; 

//$conexion=mysql_pconnect($nomhost, $nomuser, $nomclave) or tigger_error(mysql_error(),E_USER_ERROR);




mysql_query("set names 'UTF8'");
//echo '*'.(int)$conexion;




// Conectando, seleccionando la base de datos
*/


$conexion = new mysqli($nomhost, $nomuser, $nomclave, $nomBD);
mysqli_query($conexion,"SET NAMES 'utf8'");
mysqli_set_charset($conexion,'utf8');
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}else{
	//echo"Si fue";
	}
//echo $conexion->host_info . "\n";

?>
