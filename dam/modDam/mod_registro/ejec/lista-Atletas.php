<?PHP
@session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$eVent=$_GET['eVent'];
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
 
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
/////////////////////////////////////////////////
$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2023;
    $abierto=2023;
	$idGen=$_GET['idGen'];
	$idCat=$_GET['idCat'];
	$idNivel=$_GET['idNivel'];
	$peso=$_GET['peso'];
	$idTipo=$_GET['idTipo'];
	$eVent=$_GET['eVent'];
	////////////////////////////////////////////////////
	

	////////////////////////////////////////////////////
	//echo"opb: ".$opbusca;
	//echo"vbu: ".$vBusca;
	$fec_actual=date('Y-m-d');	
		if($vBusca!="" && $opbusca==1){
		  $Query = "select a.id,a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac,(select g.nombre from tbx_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas a where a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'  order by ".$OrderBy;
        	}elseif($vBusca!=" " && $opbusca==3){
   	    	$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from tbx_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas a where a.documento =".$vBusca."  and a.id_Club=".$id_usu."  order by ".$OrderBy;
			}elseif($vBusca!=" " && $opbusca==2){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.documento, a.sexo, (select g.nombre from tbx_genero g where g.id=a.sexo) AS genero  from tbx_deportistas a where  a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'";
			}elseif($vBusca=="" && $opbusca!=1){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from tbx_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by ".$OrderBy;
			}elseif($opbusca==4){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from tbx_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." and a.sexo=".$idGen." order by ".$OrderBy;
		}
//echo"cons: ".$Query;
	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

if($CantAth!=0){



//////////////////////////////////////////////
while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
    $Anac=$fila['fecha_nac'];
    $Annac=date("Y",strtotime($Anac));
    $Genero=$fila['genero'];
    //echo"Genero".$Genero;
    $edad=(strtotime($fec_actual)-strtotime($Anac));
    $edad=(($edad/360)/60/60)/24;
    $edad=(int)$edad;
 
			//	$ImgEdit = "imag/usu_dep.png";
				//	$ImgEdit = "imag/usu_dep.png";
							
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
  $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
  $ImgEdit = "sub_img/uploads/0.png";
}
				
				$ImgEdit2 = "imag/editar.png";
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_dep.php?idDep=".$fila['id']."','modal1dv','carga','txtNombres');";
				$Comenta = "Clic sobre la imagen para acceder a la edicion del Atleta.";
        $Href2 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/editApp.php?docuAsp=".$fila['id']."','modal-fdv','carga','');";
        $HrefImg = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep=".(int)$fila['id']."','".(int)$fila['id']."','carga','');";
        $Href3 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/grados.php?idDep=".$fila['id']."','modal1dv','carga','');";
        $Href4 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/peso.php?idDep=".$fila['id']."','modal1dv','carga','');";
       
 ?>

 <!--------------------CODIGO NUEVO--------------------------------------->


 
 <ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start">
      <div   id="<?=(int)$fila['id'] ?>"  > <img src="<?= $ImgEdit ?>" alt="" width="40" height="50" onclick="<?= $HrefImg ?>"  /></div><!----------Abro y Cierro Div #17--------->
      <div class="ms-2 me-auto"><!----------Div #18--------->
     
        <div class="fw-bold"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div><!----------Abro y Cierro Div #19--------->
        <div class="fw"><?php echo $Genero; ?><?php echo " - ".$Annac; ?></div><!----------Abro y Cierro Div #20--------->
       
      </div><!----------Cierro Div #18--------->
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href ?>" class="badge bg-primary "  data-bs-toggle="modal" data-bs-target="#modal1">Editar</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href2 ?>" class="badge bg-warning "  data-bs-toggle="modal" data-bs-target="#modal-f" >Fotografia</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href3 ?>" class="badge bg-info "  data-bs-toggle="modal" data-bs-target="#modal1" >Actualizar Grados</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href4 ?>" class="badge bg-info "  data-bs-toggle="modal" data-bs-target="#modal1" >Actualizar Peso</span>
     
      </li>
    </ol>
   
<!------------------------------------------------------------------>

    <?php 

  

		}

  

  ?>


<hr class="new1">
    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
	<div class="row"><!----------Div #21--------->
  <div class="col-8" align="left">Total Atletas:</div><!----------Abro y Cierro Div #22--------->
  <div class="col-4" align="right"><?php echo $CantAth; ?></div><!----------Abro y Cierro Div #23--------->
  </div><!----------Cierro Div #21--------->

  <?
}else{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <div>
   <strong>Alerta!</strong> Atleta no encontrado.
   
   </div>
 </div>
 <?
    exit();
 }
 if($idCat==0){

}
  }
?>