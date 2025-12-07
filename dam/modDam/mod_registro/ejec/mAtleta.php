<?PHP 
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
	}else{
    // Se ejecuta el ajax normalmente  
 
?>  
<?php 

	include("../../../../enlace/conexion.php");


	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


//connexion 



// obtenemos los datos del formulario.



	$nombre = $_POST['txtNombres'];

	$apellido = $_POST['txtApellidos'];

	$tipodoc = $_POST['TipoDocumento'];

	$docu = $_POST['txtDocumento'];

	$fechaN = $_POST['txtFechaNac'];
	$fechaINT = strtotime($fechaN);
	//$lugarN = 1;
	$anio = date("Y", $fechaINT);
	$actual=date("Y");
	if($anio >= $actual){
		echo"El año de nacimiento es mayor o igual al actual, no se puede continuar.";
		exit;


	}
	$sexo = $_POST['Sexo'];

	//$barrio = $_POST['Barrio'];

	//$direccion = $_POST['txtDireccion'];

	//$txtSalud = "No Aplica";

	//$celular = $_POST['txtCelular'];

	//$email = $_POST['txtEmail'];

	//$Tpsalud = 1;

	//$photoimg=$_GET['docuAsp'];
	
	//$idusu = $_GET['idusu'];
$id_usu=(int)@$_SESSION['id_usuario'];

	$idDep = $_GET['idDep'];

	//$cod=$_GET['codE'];

$SqlExisteC = mysqli_query($conexion,"select id from tbx_deportistas where id=".$idDep);
@$CantC =(int)mysqli_num_rows($SqlExisteC);
//echo"Canc ".$CantC;
if($CantC!=0){
	
 $SqlUpdateAt = mysqli_query($conexion,"update tbx_deportistas set nombres=upper('".($nombre)."'), apellidos=upper('".($apellido)."'), tipo_doc=".$tipodoc.", documento='".$docu."',id_usuario=".$id_usu.", fecha_edit=curdate(), fecha_nac='".$fechaN."', sexo=".$sexo." where id=".$idDep);
 

}else{	
    
	}
	
 if($SqlUpdateAt!=0){
       echo "Se Actualizo el Deportista Satisfactoriamente.";
      }else{	
			echo "imposible editar los datos del  deportista, por favor verifiquelo.";
	}	

}
?>
