<?php  
session_start();
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
} else{  

    include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}



	$idDep =(int)$_GET['idDep'];
	$eVent=$_GET['eVent'];
	$idGen=$_GET['idGen'];
	$idCat=$_GET['idCat'];
	$idTipo=$_GET['idTipo'];
	$idNivel=$_GET['idNivel'];
	$peso=$_GET['peso'];
	$estatura=$_GET['esta'];
	$actual= 2019;
    $limite=2003;
	$fec_actual=date('Y-m-d');	
	
	//echo "Depo: ".$idDep." Event: ".$eVent." Gen: ".$idGen." Cate: ".$idCat." Tipo: ".$idTipo." Nivel: ".$idNivel." Peso: ".$peso." Estatura: ".$estatura;
	$ValGen=mysqli_query($conexion,"select * from tbx_deportistas where id=".$idDep);
	$filaGen=mysqli_fetch_array($ValGen, MYSQLI_ASSOC);
	$idGene=$filaGen['sexo'];
	$Lim=date("Y",strtotime($filaGen['fecha_nac']));
	$SqlCat1=mysqli_query($conexion,"select * from tbx_categoria where id=".$idCat);
	$filaCat=mysqli_fetch_array($SqlCat1, MYSQLI_ASSOC);
	$limite=$filaCat['limite'];
	//echo $idLim;
	
	if($idGen!=$idGene){
		echo"Intentas asignarlo en otro genero.";
		$Hrefx = "JavaScript:cargarFocus('nucleo/consultas/scrin/info_reg.php?xctrl=1&idDep=".$idDep."','".$idDep."','carga','');"
		?>
        <a style="cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-weight:bolder"  href="<?= $Hrefx ?>" >Recargar Datos</a>
        
        <?php
		exit(); 
		}
		
		if($Lim<$limite){
		echo"Intentas asignarlo en a una categoría menor.";
		$Hrefx = "JavaScript:cargarFocus('nucleo/consultas/scrin/info_reg.php?xctrl=1&idDep=".$idDep."','".$idDep."','carga','');"
		?>
        <a style="cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-weight:bolder"  href="<?= $Hrefx ?>" >Recargar Datos</a>
        
        <?php
		exit(); 
		}
	
	//"select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac,(select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas a where a.id_Club=".$id_usu." order by ".$OrderBy;
	
	
	$siEsta=mysqli_query($conexion,"select * from tbx_reg_dep where id_dep=".$idDep." and id_evento=".$eVent." and id_tipo=1 and id_gen=".$idGen." and id_cat=".$idCat);
    $Cantsi = mysqli_num_rows($siEsta);
	$sqlIn=0;
  if($Cantsi>0){
	   /////////////uno/////////////////
	  
		echo"Debes Eliminar antes de re-asignar";
		$Hrefx = "JavaScript:cargarFocus('nucleo/consultas/scrin/info_reg.php?xctrl=1&idDep=".$idDep."','".$idDep."','carga','');"
		?>
        <a style="cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-weight:bolder"  href="<?= $Hrefx ?>" >Recargar Datos</a>
        
        <?php
		
	  //$info=$filaC['contenido']." ".$filaT['nombre']." ".$filaG['Nombre']." ".$filaN['peso']." Kg";
	//  echo $info;
	  
	  }else{
		$sqlIn=mysqli_query($conexion,"INSERT into tbx_reg_dep(id_dep,id_club,id_evento,id_cat,id_gen,peso,id_tipo,id_nivel,estatura,fecha)values(".$idDep.",".$id_usu.",".$eVent.",".$idCat.",".$idGen.", ".$peso.", ".$idTipo.", ".$idNivel.",".$estatura.", curdate())");	
		/////////////////////////////////////////////////////////////////////////////////7
	}//fin sqlin
				//$SqlDatos=mysqli_query($conexion,"select * from tbx_reg_dep where id_dep=".$idDep." and id_evento=".$eVent." and id_tipo=2");
				
				if($sqlIn!=0){
					/////////////////////////////////////////////////////////7
					//echo"Entro o no: ".$sqlIn;
					?>
<table>
<?php
         $SqlDatosZ=mysqli_query($conexion,"select * from tbx_reg_dep where id_dep=".$idDep." and id_evento=".$eVent." and id_tipo=1");
		// echo "select * from tbx_reg_dep where id_dep=".$idDep." and id_evento=".$eVent." and id_tipo=1";
		  while ($filaZ=mysqli_fetch_array($SqlDatosZ, MYSQLI_ASSOC)){
/////////////uno/////////////////
	   $SqlCat=mysqli_query($conexion,"select * from tbx_categoria where id=".$filaZ['id_cat']);
	 //  echo "select * from tbx_categoria where id=".$filaZ['id_cat']; 
	     //////////////dos//////////////////
	   $SqlNivel=mysqli_query($conexion,"select * from tbx_tipo where id=".$filaZ['id_tipo']);
	   //////////////tres////////////////
	    $SqlGen=mysqli_query($conexion,"select * from tbx_sexo where id=".$filaZ['id_gen']);
		//////////////////////////////////////////////////
		
		$SqlPeso=mysqli_query($conexion,"select * from tbx_pesos where id=".$filaZ['peso']);
				
		////////////////////////////////////////////////
$filaC=mysqli_fetch_array($SqlCat, MYSQLI_ASSOC);
$filaT=mysqli_fetch_array($SqlNivel, MYSQLI_ASSOC);
$filaG=mysqli_fetch_array($SqlGen, MYSQLI_ASSOC);
$filaP=mysqli_fetch_array($SqlPeso, MYSQLI_ASSOC);
//////////////////////////////////////////////////////////////////////
$ImgEditZ = "imag/cancel.png";
$HrefZ = "JavaScript:cargarFocus('nucleo/consultas/scrin/borrar.php?idReg=".$idDep."','".$idDep."','carga','');";
$ComentaZ = "Clic aqui para retirar la asignaci&oacute;n del deportista.";			 //  $info=$filaC['contenido']." ".$filaT['nombre']." ".$filaG['nombre']." ".$filaP['contenido'];
///////////////////////////////////////////////////////////////////////////////////// 
$infoZ=$filaC['contenido']." ".$filaT['nombre']." ".$filaG['nombre']." ".$filaP['contenido'];
//echo $filaC['contenido']." ".$filaT['nombre']." ".$filaG['nombre']." ".$filaP['contenido'];
?>
    <tr>
    <td width="94%"><div id="DvInfo" class="headerLista"><?php echo $infoZ; ?></div></td>
    <td  width="1%"></td>
    <td width="5%" align="center" ><a href="<?= $HrefZ ?>"  title="<?= $ComentaZ ?>"><img src="<?= $ImgEditZ ?>" alt="" width="30" height="30" border="0" /></a></td>
    </tr>
    <?php
}
?>
</table>
<?php
					
					
					
					
					
/////////////////////////////////////////////////////////
 }else{
   echo"No pudo registrar";
   $Hrefx = "JavaScript:cargarFocus('nucleo/consultas/scrin/info_reg.php?xctrl=1&idDep=".$idDep."','".$idDep."','carga','');"
		?>
        <a style="cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-weight:bolder"  href="<?= $Hrefx ?>" >Recargar Datos</a>
        
        <?php
}
				
}
?>
