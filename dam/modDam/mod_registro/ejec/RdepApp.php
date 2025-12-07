<?php  
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



//connexion 




	

//séleccion de la base de datos




// obtenemos los datos del formulario.



	$nombre = $_POST['txtNombres'];

	$apellido = $_POST['txtApellidos'];

	$tipodoc = $_POST['TipoDocumento'];

	$docu = $_POST['txtDocumento'];

	$fechaN = $_POST['txtFechaNac'];

	$lugarN = 1;

	$sexo = $_POST['Sexo'];

	$barrio =1;

	$direccion ="No Presento";

	$txtSalud = "No Presento";

	$celular = 1;

	$email = "nopresento@servidor.com";;

	$Tpsalud = 1;

	

	$id_usu = $_GET['idusu'];

	
    $anoHoy=2019;
//CONSULTO EL AÑO ABIERTO

	//$sqlAnoAb = mysql_query("select ano_abierto from tbx_anos_lectivos",$conexion);	

	

// consultar si el aspirante existe [Tabla Aspirantes].



	$SqlExiste = mysqli_query($conexion,"select documento from tbx_deportistas where documento='".$docu."'");

	$CantDep = 0;

	@$CantDep = mysqli_num_rows($SqlExiste);
   // $CantDep=$SqlExiste->num_rows;
	
//echo"Candep: ".$CantDep;
	
	if($CantDep==0 )

	{

		

//echo $_POST['txtNombres'].",".$_POST['txtApellidos'].",".$_POST['TipoDocumento'].",".$_POST['txtDocumento'].",".$_POST['txtTelefono'].",".$_POST['txtEmail'].",".$_POST['Grados'].",".$_GET['idusu'].",".$RValor.",".$_POST['FechaNac']."=".$fechaN."+".$fechaN."\n\n";	

	

	$Rrecibo = 0;

 //Ejemplo aprenderaprogramar.com, archivo escribir.php





$SqlInsertDep = mysqli_query($conexion, "INSERT INTO tbx_deportistas(nombres, apellidos, tipo_doc, documento, servsalud, email, nombreEps, ano_lectivo, id_usuario, fecha_edit, fecha_nac, lugar_nac, sexo, barrio, direccion, celular, cod_int, id_club) VALUES(upper('".$nombre."'),upper('".$apellido."'),".$tipodoc.",'".$docu."',".$Tpsalud.",'".$email."','".$txtSalud."', ".$anoHoy.",".$id_usu.", curdate(),'".$fechaN."',".$lugarN.",".$sexo.",".$barrio.",upper('".$direccion."'),".$celular.",0, ".$id_usu.")");
			
			
			
			
				$SqlExiste = mysqli_query($conexion,"select documento, id from tbx_deportistas where documento='".$docu."'");

	

	//$CantAsp = mysql_num_rows($SqlExiste);
	@$CantDep = mysqli_num_rows($SqlExiste);


	if($CantDep==0)

	{

		echo "No pudo registrarse el deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  

			

			echo "Se Registro el deportista Satisfactoriamente.";
			$fila=mysqli_fetch_array($SqlExiste, MYSQLI_NUM);
			$id_estu=$fila[1];
			//echo "ID: ".$id_estu;
			$anio=date("Y");
			$id_fin=$anio.(int)$id_estu;
			$id_fin=(int)$id_fin;
			echo" RUDEP: ".$id_fin;
			$editarE =mysqli_query($conexion,"UPDATE tbx_deportistas SET cod_int=".$id_fin." where id=".$id_estu);
			
			//echo "UPDATE tbx_deportistas SET cod_int=".$id_fin." where id=".$id_estu;
	       // mysqli_query($conexion,$editarE);
			/////////seguridad
			
			
			        $Id_Asignado = $id_fin;
					$Id_llave = $id_estu;

					

			//**************************** AGREGO AL ESTUDIANTE A LA TABLA USUARIOS ***********************************************//

				/*	

					$IdClav = number_format($Id_Asignado,0,'','');
					$IdClavS=(string)$IdClav;
					$cplus = "QwHj75.."; //example of random salt
                    $Llave = sha1($cplus.md5($IdClavS));
					
			$insertUsuario = mysql_query("insert into tbx_usuarios(nombres, apellidos, usuario, password, llave, tipo, id_roll, id_usuario, fecha_edit, estado, id_tema, identificador, mail) values(upper('".$nombre."'),upper('".$apellido."'), '".$IdClav."', '".$Llave."', '".$Llave."', 3, 6, ".$idusu.", curdate(), 1, 1,".$Id_llave.", '".$email."')",$conexion);
			
			//////////////////////*/
	
		}

	}else{	

			echo "El deportista ya existe.";

		}
}
?>