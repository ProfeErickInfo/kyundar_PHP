<?php
@session_start();
///////////registro de finalizar//////////////
//connexion 
 include("../enlace/conexion.php");

$myId=@$_SESSION['id_usuario'];
$ipc=$_SERVER['REMOTE_ADDR'];
ini_set('date.timezone', 'America/Bogota');
$Hra = date('H:i:s', time()); // 10:00:00
$Fec= date('Y-m-d');

//$sqlUA = mysql_query("select * from tbx_ringresos where idusuario=".$myId."  and horaout=0",$conexion);	
//$cantu=mysql_num_rows($sqlUA);
/*if($cantu>0){
   $UpdateR = mysql_query("update tbx_ringresos set fechaout='".$Fec."', horaout='".$Hra."' , control=1 where id=".mysql_result($sqlUA,0,"id"),$conexion);
}
*/

///////////////////////////////////
$url="/siraplus.net/dam21/"; 

session_unset();
session_destroy();
?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME'] ?>/index.html" />
     <?php
?>