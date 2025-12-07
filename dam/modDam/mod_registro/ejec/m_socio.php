<?php  
session_start();
echo"Entre";
//$id_usu=(int)@$_SESSION['id_usuario'];
$id_usu=1;
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
	
/*
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
	*/
	////////CODIGO NUEVO SE RECIEN LOS DATOS DEL FORMULARIO/////////////////02-SEP-2025
	$idDep=$_GET['idSocio'];

///--------------------------------------------------------------
$tipodoc =mysqli_real_escape_string($conexion,$_POST['TipoDocumento']);
$tipodoc = filter_var($tipodoc, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
$docu=mysqli_real_escape_string($conexion,$_POST['txtDocumento']);
$docu = filter_var($docu, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$nombre=mysqli_real_escape_string($conexion,$_POST['txtNombres']);
$nombre = filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$apellido=mysqli_real_escape_string($conexion,$_POST['txtApellidos']);
$apellido = filter_var($apellido, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$lugarN =mysqli_real_escape_string($conexion,$_POST['LugarNac']);
$lugarN = filter_var($lugarN, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
$fechaN=mysqli_real_escape_string($conexion,$_POST['txtFechaNac']);
$fechaN = filter_var($fechaN, FILTER_SANITIZE_NUMBER_INT);

///--------------------------------------------------------------
$Tpsalud =mysqli_real_escape_string($conexion,$_POST['Tpsalud']);
$Tpsalud = filter_var($Tpsalud, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
$txtSalud=mysqli_real_escape_string($conexion,$_POST['txtSalud']);
$txtSalud = filter_var($txtSalud, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------
$barrio=mysqli_real_escape_string($conexion,$_POST['Barrio']);
$barrio = filter_var($barrio, FILTER_SANITIZE_SPECIAL_CHARS);

///--------------------------------------------------------------
$direccion=mysqli_real_escape_string($conexion,$_POST['txtDireccion']);
$direccion = filter_var($barrio, FILTER_SANITIZE_SPECIAL_CHARS);
///--------------------------------------------------------------

$OpSocio=$_POST['OpSocio'];

//--------------------------------------------------------------
$email=mysqli_real_escape_string($conexion,$_POST['txtEmail']);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
///--------------------------------------------------------------
$sexo=mysqli_real_escape_string($conexion,$_POST['Sexo']);
$sexo = filter_var($sexo, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------
$celular=mysqli_real_escape_string($conexion,$_POST['txtCelular']);
$celular = filter_var($celular, FILTER_SANITIZE_NUMBER_INT);
///--------------------------------------------------------------



$anoHoy=date("Y");	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//echo "update tbx_deportistas set cod_int=".$cod.", nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento=".$docu.", servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', id_usuario=".$idusu.", fecha_edit=curdate(),  fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio=".$barrio.", direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio.",responsable='".$Nacu."',tipoDoc=".$tpdoc2.",docRes='".$doc2."',estado=0,id_usuario=".$id_usu.",fecha_edit=curdate(),nombreEps='".$txtSalud."' where id=".$idDep;
$SqlExisteC = mysqli_query($conexion,"select * from trn25_socios where id=".$idDep);
@$CantC =(int)mysqli_num_rows($SqlExisteC);
//echo"Canc ".$CantC;
//echo "UPDATE trn25_socios set  nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento='".$docu."', servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio=".$barrio.", direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio." ,estado=0,fecha_edit=curdate() where ID=".$idDep;
			//
if($CantC!=0)
	{
		$c++;
		//echo "UPDATE trn25_socios set  nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento='".$docu."', servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio=".$barrio.", direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio." ,estado=0,fecha_edit=curdate() where id=".$idDep;
			//echo "El codigo que intenta asignar ya existe para otro estudiante, por favor verifiquelo.";
			$SqlUpdateSocio = mysqli_query($conexion,"UPDATE trn25_socios set  nombres=upper('".$nombre."'), apellidos=upper('".$apellido."'), tipo_doc=".$tipodoc.", documento='".$docu."', servsalud=".$Tpsalud.", email='".$email."', nombreEps='".$txtSalud."', fecha_nac='".$fechaN."', lugar_nac=".$lugarN.", sexo=".$sexo.", barrio='".$barrio."', direccion=upper('".$direccion."'), celular=".$celular." ,tipo_socio=".$OpSocio." ,estado=0,fecha_edit=curdate() where id=".$idDep);
					//$SqlInsertDep = mysqli_query($conexion, "INSERT INTO trn25_socios(nombres, apellidos, tipo_doc, documento, servsalud, email, nombreEps, ano_lectivo, id_usuario, fecha_edit, fecha_nac, lugar_nac, sexo, barrio, direccion, celular, cod_int, id_club) VALUES(upper('".$nombre."'),upper('".$apellido."'),".$tipodoc.",'".$docu."',".$Tpsalud.",'".$email."','".$txtSalud."', ".$anoHoy.",".$id_usu.", curdate(),'".$fechaN."',".$lugarN.",".$sexo.",".$barrio.",upper('".$direccion."'),".$celular.",0, ".$id_usu.")");
			
			
	 }	 


 

	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
 if($SqlUpdateSocio!=0){
       echo "Se Actualizo el socio satisfactoriamente.";
      }else{	
			echo "imposible editar los datos del  socio, por favor verifiquelo.";
	}	

}
?>
