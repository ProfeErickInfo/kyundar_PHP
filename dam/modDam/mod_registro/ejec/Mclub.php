<?php  
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
$idClub=$_GET['idClub'];
$Nomclub=$_POST['txtNomclub'];
$idBarrio=$_POST['Barrio'];
$direccion=$_POST['txtdireccion'];
$correo=$_POST['txtCorreo'];
$resp=$_POST['txtresponsable'];
$cel1=$_POST['txtcelular1'];
$entrenador=$_POST['txtEntrenador'];
$cel2=$_POST['txtCelular2'];
 $sqlBuscar = mysqli_query($conexion,"select id from tbx_club where id=".$idClub);
 $sqlSi=mysqli_num_rows($sqlBuscar);
 if ($sqlSi!=0){
   $editar ="UPDATE tbx_club SET  nombre='".$Nomclub."', id_barrio=".$idBarrio.", direccion='".$direccion."', entrenador='".$entrenador."', telefono=".$cel2.", representante='".$resp."', cel=".$cel1.", email='".$correo."',  fec_reg=curdate() where id=".$idClub;
  
   mysqli_query($conexion,$editar);
   echo "Datos Actualizados Satisfactoriamente";
 }else{
echo "Datos NO Actualizados";
 $CantInfo=0;

 }
 
 
}
?>