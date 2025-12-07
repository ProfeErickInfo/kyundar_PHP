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



	$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2019;
    $abierto=2003;
	$eVent=$_GET['eVent'];
	$idGen=$_GET['idGen'];
	$idCat=$_GET['idCat'];
	$idNivel=$_GET['idNivel'];
	$peso=$_GET['peso'];
	$idTipo=$_GET['idTipo'];
	$esta=$_GET['esta'];
	$fec_actual=date('Y-m-d');	
		//echo"evento:".$eVent;
		//echo " Event: ".$eVent." Gen: ".$idGen." Cate: ".$idCat." Tipo: ".$idTipo." Nivel: ".$idNivel." Peso: ".$peso." Estatura: ".$esta;
	if($vBusca!=" " && $opbusca==1){
		

		$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac,(select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas a where a.id_Club=".$id_usu." order by ".$OrderBy;

		


	}elseif($vBusca!=" " && $opbusca==3){

		

		$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas a where a.documento =".$vBusca."  and a.id_Club=".$id_usu."  order by ".$OrderBy;

		

	}elseif($vBusca!=" " && $opbusca==2){

		

		
$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.documento, a.sexo from tbx_deportistas a where  a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'";
		

	}elseif($vBusca==0 && $opbusca!=1){
	$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by ".$OrderBy;
	
	
	
}
	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

	//BVERIFICAR EL ERROR DEL GENERO

	if($CantAth!=0){

		//$row=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC);
		//echo"Print: ".$row['genero'];
		

?>






  <table width="100%" class="table">

    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		$c=1;

		
 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
	$Anac=$fila['fecha_nac'];
	$Annac=date("Y",strtotime($Anac));
	@$Genero=$fila['genero'];
	$edad=(strtotime($fec_actual)-strtotime($Anac));
	$edad=(($edad/360)/60/60)/24;
	$edad=(int)$edad;
	
				

				$ImgEdit = "imag/ir.png";
                $idD=(int)$fila['id'];
				$Href = "JavaScript:cargarFocus('nucleo/consultas/ejec/asig_deportista.php?idDep=".$fila['id']."&eVent=".$eVent."&idGen=".$idGen."&idCat=".$idCat."&idNivel=".$idNivel."&peso=".$peso."&idTipo=".$idTipo."&esta=".$esta."','".$idD."','carga','');";


				$Comenta = "Clic aqui para proceder con la asignaci&oacute;n del deportista.";
				
 
  $siEsta=mysqli_query($conexion,"select * from tbx_reg_dep where id_dep=".$fila['id']." and id_evento=".$eVent." and id_tipo=".$idTipo);
  $Cantsi = mysqli_num_rows($siEsta);
  if($Cantsi>0){
	   $filaN=mysqli_fetch_array($siEsta, MYSQLI_ASSOC);
	   $filaN['id_cat'];
	   $filaN['id_tipo'];
	   $filaN['id_nivel'];
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
		
	//$eVent=$_GET['eVent'];
	//$idGen=$filaN['id_gen'];
	//$idCat=$filaN['id_cat'];
	//$idNivel=$filaN['id_nivel'];
	//$peso=$filaN['peso'];
	//$idTipo=$filaN['id_tipo'];
	//$esta=100;
		
	  $info=$filaC['contenido']." ".$filaT['nombre']." ".$filaG['nombre']." ".$filaP['contenido'];
	  
	  }else{
		$info="No Registra";  
		  
	  }

 /////////////////////////////////////////////////////////////////////
 
			/*	$ImgEdit = "imag/ir.png";

				$Href = "JavaScript:cargarFocus('nucleo/consultas/ejec/asig_deportista.php?idDep=".$fila['id']."&eVent=".$eVent."&idGen=".$idGen."&idCat=".$idCat."&idNivel=".$idNivel."&peso=".$peso."&idTipo=".$idTipo."&esta=".$esta."','DvInfo','carga','');";

				$Comenta = "Clic aqui para proceder con la asignaci&oacute;n del deportista.";
				*/
 
 
 ////////////////////////////////////////////////////////////////////7
  ?>
     <tr  style="height:30px"  >
     <td width="5%" align="center"><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="30" height="30" border="0" /></a></td>
      <td width="20%"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></td>
      <td width="1%"></td>
      <td width="10%"><?php echo $Genero; ?></td>
      <td width="1%"></td>
      <td width="10%"><?php echo $Annac; ?></td>
      <td  width="1%"></td>
      <td width="52%"><div id="<?=$idD?>"><?php include('../scrin/info_reg.php'); ?></div></td>
    </tr>
    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

    <tr class="headerLista">
       <td>Total Atletas:<?php echo $CantAth; ?></td>
       <td></td>
        <td></td>
       <td></td>
       <td></td>
       <td>&nbsp;</td>
       <td></td>
       <td>&nbsp;</td>     
    </tr>

  
  </table>

  

  

<?php



	}else{

		

		echo "No presenta coincidencia";

	

	}

}

?>