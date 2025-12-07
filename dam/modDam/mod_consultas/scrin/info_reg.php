<?php  
//session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
//echo "*".$id_usu;
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



	//$opbusca = $_GET['opbusca'];
	//$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    //$vBusca = $_GET['vbusca'];
    $actual= 2019;
    $abierto=2019;
	$idDep=0;
	$xctrl=0;
	@$xctrl=$_GET['xctrl'];
	if($xctrl==1){
		$idDep=(int)$_GET['idDep'];
		
	}else{
		$idDep=(int)$fila['id'];
		
	}
	//
	
	//echo "ID: ".$idDep;
	/*
	$eVent=$_GET['eVent'];
	$idGen=$_GET['idGen'];
	$idCat=$_GET['idCat'];
	$idNivel=$_GET['idNivel'];
	$peso=$_GET['peso'];
	$idTipo=$_GET['idTipo'];
	$esta=$_GET['esta'];
	*/
	$fec_actual=date('Y-m-d');	
		//echo"evento:".$eVent;
		//echo " Event: ".$eVent." Gen: ".$idGen." Cate: ".$idCat." Tipo: ".$idTipo." Nivel: ".$idNivel." Peso: ".$peso." Estatura: ".$esta;
   $siEsta=mysqli_query($conexion,"select * from tbx_reg_dep where id_dep=".$idDep);
   $CantD = mysqli_num_rows($siEsta);

	//BVERIFICAR EL ERROR DEL GENERO

	if($CantD!=0){

		//$row=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC);
		//echo"Print: ".$row['genero'];
		

?>





  <table >

    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		

		
 while ($filaN=mysqli_fetch_array($siEsta, MYSQLI_ASSOC)){
	////////////////////////////////////////////////
	$filaN['id'];
	$filaN['id_cat'];
	$filaN['id_tipo'];
	$filaN['id_nivel'];
	$idD=(int)$idDep;
	
	///////////////////////////////////////////////   
	 /////////////uno/////////////////
	   $SqlCat=mysqli_query($conexion,"select * from tbx_categoria where id=".$filaN['id_cat']); 
	     //////////////dos//////////////////
	   $SqlNivel=mysqli_query($conexion,"select * from tbx_tipo where id=".$filaN['id_tipo']);
	   //////////////tres////////////////
	    $SqlGen=mysqli_query($conexion,"select * from tbx_sexo where id=".$filaN['id_gen']);
		//////////////////////////////////////////////////
		
		$SqlPeso=mysqli_query($conexion,"select * from tbx_pesos where id=".$filaN['peso']);
				
		////////////////////////////////////////////////
		$filaC=mysqli_fetch_array($SqlCat, MYSQLI_ASSOC);
		$filaT=mysqli_fetch_array($SqlNivel, MYSQLI_ASSOC);
		$filaG=mysqli_fetch_array($SqlGen, MYSQLI_ASSOC);
		$filaP=mysqli_fetch_array($SqlPeso, MYSQLI_ASSOC);
		//////////////////////////////////////////////////////////////////////
		
$ImgEdit2 = "imag/cancel.png";

				$Href2 = "JavaScript:cargarFocus('nucleo/consultas/scrin/borrar.php?idReg=".$filaN['id']."','".$idD."','carga','');";

				$Comenta2 = "Clic aqui para retirar la asignaci&oacute;n del deportista.";				

	   $info=$filaC['contenido']." ".$filaT['nombre']." ".$filaG['nombre']." ".$filaP['contenido'];
		
		
	 
  ?>

    <tr   >
    <td width="94%"><div id="<?=$idD?>" class="headerLista"><?php echo $info; ?></div></td>
    <td  width="1%"></td>
    <td width="5%" align="center" ><a href="<?= $Href2 ?>"  title="<?= $Comenta2 ?>"><img src="<?= $ImgEdit2 ?>" alt="" width="30" height="30" border="0" /></a></td>

    </tr>

    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

   

   
  </table>

  

<?php



	}else{

		

		echo "No presenta coincidencia";

	

	}

}

?>
