<?PHP 
session_start(); 
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');


$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  
if ((!$Xrefer) || ($id_usu==0)){
	?> 
	<script languaje="JavaScript">
	location.href='../index.html';
	</script>
	
	<?php
	}else{
    // Se ejecuta el ajax normalmente  
 
?>  

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script> 
   function recargar(id,club,fichero){
	var id=id;
	var club= club;
	var fichero= fichero;
    alert('recragnado');
    $("#"+id).attr("src", " sub_img/uploads/"+club+"/"+fichero);
   }
       
       
   
      
       
   
</script>

<?php 

	include("../../../../enlace/conexion.php");
	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

	
	
	//$idusu=4 ;
	//$sqlMax = mysqli_query($conexion,"select MAX(id) as mxim from tbx_deportistas a where id_Club=".$idusu);
//$resultadosx=mysqli_fetch_array($sqlMax, MYSQLI_ASSOC);

//$docu = $resultadosx['mxim'];
	$docu = (int)@$_GET['docuAsp'] or exit("El documento no se ha definido, consulte con el administrador del sistema.");

	
	//CONSULTO AL ASPIRANTE

		$sqlDep = mysqli_query($conexion,"select id, nombres, film, apellidos, tipo_doc, documento, fecha_nac, lugar_nac, sexo, barrio, direccion, nombreEps, celular, email, servsalud, cod_int  from tbx_deportistas a where id=".$docu);
$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);

 @$pic=$resultados["film"];
 

 
 /////////////////////////////////////////////////////////////////
 $Crpa=0;
 /*
 $sqlRPA=mysqli_query($conexion,"select * from tbx_est_padres_rel where id_estudiante=".$docu );
 
 @$Crpa=mysqli_num_rows($sqlRPA);
// echo $Crpa;
 */

$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");




	

	/*	

	@$CantTD = mysqli_num_rows($sqlTD);

	@$CantSalud = mysqli_num_rows($sqlSalud);

	@$CantLug = mysqli_num_rows($sqlLugar);

	@$CantSexo = mysqli_num_rows($sqlSexo);

	@$CantBarrio = mysqli_num_rows($sqlBarrio);
	*/
 ////////////////////////////////////////////////////////////////
		
/*
		$cantAsp = 0;

		@$cantAsp = mysqli_num_rows($sqlAsp);

		

		if($cantAsp != 0){

		

	

		
		}
*/

		//echo"En foto".$docu." - Foto: ".$pic ;
?>

<script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>

<style>
input[type="file"] {
    display: none;
}
.custom-photoimg {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
	color:#006;
	font-size:large;
	font-weight:bold;
}
#menu * { list-style:none;  color:#EEE; font-weight:bolder; font-size:14px; font:Verdana, Geneva, sans-serif}
#menu li{ line-height:180%;  background-color:#464646; width:220px; text-align:left }

#menu li a{color:#FFF; text-decoration:none; }
#menu li a:before{ content:"\025b8"; color:#ddd; margin-right:20px;}
#menu li a:hover{ color:#FF3}
#menu input[name="list"] {
	position: absolute;
	left: -500em;
	}
	
#menu label:before{ content:"\025b8"; margin-right:4px;}
#menu input:checked ~ label:before{ content:"\025be";}
#menu .interior{display: none; color:#D00}
#menu input:checked ~ ul{display:block;}
</style>
<!-- <body> comentado para evitar conflictos con el contenedor principal -->




<div class="container-fluid text-center">


<h3 >Cargar Foto del Estudiante</h3>
<small><? echo $resultados["nombres"];?> <?=$resultados["apellidos"];?></small>
 <? 
  //@$pic=$resultados["film"];
  $idAtleta=(int)$docu;
  $Href = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep=$idAtleta','$idAtleta','carga','');";
 
// echo "sub_img/uploads/".$id_usu."/".$pic;
 if (file_exists("../../../sub_img/uploads/".$id_usu."/".$pic)) {
	// echo"si";
    $ImgU = "sub_img/uploads/".$id_usu."/".$pic;
} else {
    $ImgU = "sub_img/uploads/0.png";
}
 
 
 ?>



<div id="nombreF"  >
<input type='text' name='nomFile' id='nomFile' value='<?=$pic?>' style="visibility:hidden"  >
</div>
<div   id="DVsub" class="text-center" >


 

<div id="preview" class="mx-auto"  style=" background:#FFFFFF ;  overflow:auto" >
	
	<img src="<?=$ImgU?>" class="rounded"   id="FotoPerfil" style="width:200px; height:250px"/>
	
</div>

<form style="font-size:9" id="imageform" method="post" enctype="multipart/form-data" action='sub_img/newimagen.php?rudp=<?=$docu?>&idClub=<?=$idusu?>'>
	<br>
<div class="container-fluid">
  <div class="row">
    <div class="col">
    <label for="photoimg" class="custom-photoimg">
   			 <i >Subir Foto</i> 
		</label>
		<input  type="file"  class="form-control-file"   style="width:auto;" name="photoimg" accept="image/*"  id="photoimg"   value=<?=$pic?> />
		
    </div>
   
    <div class="col">
	<button type="button" class="btn btn-dark" onclick="<?= $Href ?>">Actualizar en Lista</button>
    </div>
  </div>
</div>

</form>

<div style="background-color:#CCC; width:100%">
<span  style="color:#900; width:100%; text-align:center; "> <? //echo (int)$resultados["cod_int"];?></span></div>
</div>


</div><!-------CIERRE DE CONTAINER FLUID---------->


</body>

<? 
//echo "sub_img/uploads/".$id_usu."/".$pic;
 }
  ?>



	

