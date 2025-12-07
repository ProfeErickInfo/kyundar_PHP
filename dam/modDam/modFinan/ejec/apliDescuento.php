<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
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
$idDep=$_GET['idDep'];
$valor=$_GET['vali'];
$minicio=$_GET['ini'];
$mfin=$_GET['fin'];
if($valor<=0){
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
   
   
   <div> Valor cero, no se puede continuar!</div>
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   
 </div>
 <?
  echo"Sin Descuento!";
    exit();
   
 }
 if($idDep<=0){
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
   
   <strong>Alerta!</strong> No existe asociado, no se puede continuar!
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   
 </div>
 <?
 echo"Sin Descuento!";
    exit();
    
 }

//echo "valDto= ".$valor.", inicio= ".$minicio.", fin= ".$mfin." deportista:".$idDep;
$Query = "select id from tcx_descuentox where  id_Dep=".$idDep;
$sqlDto = mysqli_query($conexion, $Query);
	
$CantDto = mysqli_num_rows($sqlDto);
//echo "select id from tcx_descuentox where  id_Dep=".$idDep;
if($CantDto!=0){
///Editar
$editar ="UPDATE tcx_descuentox SET  valor=".$valor.", Minicio=".$minicio.", Mfin=".$mfin." where id_Dep=".$idDep;
 //echo "UPDATE tcx_descuentox SET  valor=".$valor.", Mincio=".$minicio.", Mfin=".$mfin." where id_Dep=".$idDep;
   
 mysqli_query($conexion,$editar);
 ?>
<div class="alert alert-success" role="alert">
    <div>
  Proceso realizado, Datos Actualizados!.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
 <?
   echo"Descuento Aplicado!";
}else{
///Nuevo
$sqlIn=mysqli_query($conexion,"INSERT into tcx_descuentox(id_Dep,id_club,valor,Minicio,Mfin)values(".$idDep.",".$id_usu.",".$valor.",".$minicio.",".$mfin.")");	
if($sqlIn!=0){
    /////////////////////////////////////////////////////////7
    //echo"Entro o no: ".$sqlIn;
    
    ?>
<div class="alert alert-success" role="alert">
    <div>
   Datos Nuevos Registrados!.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
 <?
   echo"Descuento Aplicado!";
}	

}


}
?>