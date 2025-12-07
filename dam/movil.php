<?PHP
session_start();
$url=@$_SESSION['direction'];
$Xrefer = getenv('HTTP_REFERER'); 

$id_usu=(int)@$_SESSION['id_usuario'];
$idUxer=(int)$_SESSION['idUxer'];
$idEvent=$_SESSION['idEvent'];
//echo"Estoy".$id_usu."  UXER:".$idUxer;
//if (($Xrefer)){
    // if ((!$Xrefer) || ($id_usu==0)){
      
if ($id_usu==0){
   if($idUxer==0){

  
?> 
<script languaje="JavaScript">
location.href='../sesionOut.html';
</script>

<?php
   }else{
   // echo"Ruta: ".$url;
   // $id_usu=$idUxer;
    include($url);
   }
}else{
  //  echo"Ruta: ".$url;
include($url);
}
?>