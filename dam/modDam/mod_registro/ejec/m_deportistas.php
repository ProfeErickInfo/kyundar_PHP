<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
//echo"entrando";
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	

	$idDep=$_GET['idDep'];

	$nombre = $_POST['txtNombres'];

	$apellido = $_POST['txtApellidos'];

	$tipodoc = $_POST['TipoDocumento'];

	$docu = $_POST['txtDocumento'];

	$fechaN = $_POST['txtFechaNac'];

	$lugarN = $_POST['LugarNac'];

	$sexo = $_POST['Sexo'];

	$barrio = $_POST['Barrio'];

	$direccion = $_POST['txtDireccion'];

	$txtSalud = $_POST['txtSalud'];

	$celular = $_POST['txtCelular'];

	$email = $_POST['txtEmail'];

	$Tpsalud = $_POST['Tpsalud'];

	$OpLugar=$_POST['OpLugar'];
	
	$OpSocio=$_POST['OpSocio'];

	$doc2=$_POST['txtDocumento2'];
	$tpdoc2=$_POST['TipoDocumento2'];
	$Nacu=$_POST['txtAcudiente'];
	//$idusu = $_GET['idusu'];

	//echo "Spcio: ".$OpSocio;
    $anoHoy=date("Y");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//echo "update tbx_deportistas set cod_int=".$cod.", nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento=".$docu.", servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', id_usuario=".$idusu.", fecha_edit=curdate(),  fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio=".$barrio.", direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio.",responsable='".$Nacu."',tipoDoc=".$tpdoc2.",docRes='".$doc2."',estado=0,id_usuario=".$id_usu.",fecha_edit=curdate(),nombreEps='".$txtSalud."' where id=".$idDep;
$SqlExisteC = mysqli_query($conexion,"select * from tbx_deportistas where id=".$idDep);
@$CantC =(int)mysqli_num_rows($SqlExisteC);
//echo"Canc ".$CantC;
if($CantC!=0)
	{
		$c++;
			//echo "El codigo que intenta asignar ya existe para otro estudiante, por favor verifiquelo.";
			$SqlUpdateAsp = mysqli_query($conexion,"update tbx_deportistas set  nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento='".$docu."', servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio=".$barrio.", direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio." ,tipo_lugar=".$OpLugar.",responsable='".$Nacu."',tipoDoc=".$tpdoc2.",docRes='".$doc2."',estado=0,fecha_edit=curdate() where id=".$idDep);

	 }	 


 

	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
 if($SqlUpdateAsp!=0){
       echo "Se Actualizo el Deportista Satisfactoriamente.";
      }else{	
			echo "imposible editar los datos del  deportista, por favor verifiquelo.";
	}	

}
?>
