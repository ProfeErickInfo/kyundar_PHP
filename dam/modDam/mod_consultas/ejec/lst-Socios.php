<?PHP
@session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$eVent=$_GET['eVent'];
$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  

// Función para calcular edad correctamente
function calcularEdad($fechaNacimiento) {
    $nacimiento = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}
//------------------------------------  

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
//	echo"vbu: ".$vBusca;
	$fec_actual=date('Y-m-d');	
  $Query = "select a.id,a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac,(select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from trn25_socios a where a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'  order by ".$OrderBy;
		/*
        if($vBusca!="" && $opbusca==1){
		  $Query = "select a.id,a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac,(select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from trn25_socios a where a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'  order by ".$OrderBy;
        	}elseif($vBusca!=" " && $opbusca==3){
   	    	$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from trn25_socios a where a.documento =".$vBusca."  and a.id_Club=".$id_usu."  order by ".$OrderBy;
			}elseif($vBusca!=" " && $opbusca==2){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.documento, a.sexo, (select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  from trn25_socios a where  a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'";
			}elseif($vBusca=="" && $opbusca!=1){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from trn25_socios  a  where  a.id_Club=".$id_usu." order by ".$OrderBy;
			}elseif($opbusca==4){
			$Query = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, (select g.nombre from trn25_genero g where g.id=a.sexo) AS genero  , a.documento, a.sexo from trn25_socios  a  where  a.id_Club=".$id_usu." and a.sexo=".$idGen." order by ".$OrderBy;
		}
      */
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
 //-----------------------------nuevo-------------------------
                   $edad = calcularEdad($fila['fecha_nac']);
                    $anoNacimiento = date("Y", strtotime($fila['fecha_nac']));
                    $genero = $fila['genero'] ?? 'No especificado';
                    
                    // Manejar imagen del socio
                    $rutaImagen = "sub_img/uploads/{$id_usu}/{$fila['film']}";
                    if (!empty($fila['film']) && $fila['film'] !== '0.png' && file_exists($rutaImagen)) {
                        $imagenSocio = $rutaImagen;
                    } else {
                        $imagenSocio = "sub_img/uploads/0.png";
                    }
  //------------------------FIN nuevo------------------------                  
			//	$ImgEdit = "imag/usu_dep.png";
				//	$ImgEdit = "imag/usu_dep.png";
							
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
  $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
  $ImgEdit = "sub_img/uploads/0.png";
}
				
				$ImgEdit2 = "imag/editar.png";
		  // Enlaces de acción
                    $hrefEditar = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_afiliado.php?idDep={$fila['id']}','modal-fdv','carga','txtNombres');";
                    $hrefBeneficiarios = "JavaScript:cargarFocus('modDam/mod_registro/scrin/reg_beneficiario.php?idSocio={$fila['id']}','modal-fdv','carga','');";
                    $hrefImagen = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep={$fila['id']}','{$fila['id']}','carga','');";
                    $hrefFinanciera = "JavaScript:cargarFocus('modDam/mod_registro/scrin/grados.php?idDep={$fila['id']}','modal-fdv','carga','');";
                    $hrefSeguridad = "JavaScript:cargarFocus('modDam/mod_registro/scrin/peso.php?idDep={$fila['id']}','modal-fdv','carga','');";
       
 ?>

 <!--------------------CODIGO NUEVO--------------------------------------->


 
 <ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start">
      <div   id="<?=(int)$fila['id'] ?>"  > <img src="<?= $ImgEdit ?>" alt="" width="40" height="50" onclick="<?= $hrefImagen ?>"  /></div><!----------Abro y Cierro Div #17--------->
      <div class="ms-2 me-auto"><!----------Div #18--------->
     
        <div class="fw-bold"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div><!----------Abro y Cierro Div #19--------->
         <div class="text-muted small">
                            <span class="me-3"><?php echo htmlspecialchars($genero); ?></span>
                            <span class="me-3">Año: <?php echo $anoNacimiento; ?></span>
                            <span class="me-3">Edad: <?php echo $edad; ?> años</span>
                            <span>Doc: <?php echo htmlspecialchars($fila['documento']); ?></span>
                        </div>
      </div><!----------Cierro Div #18--------->
       <div class="d-flex flex-wrap gap-1">
                        <span class="badge bg-primary" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefEditar; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Datos Personales</span>
                        
                        <span class="badge bg-warning" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefBeneficiarios; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Beneficiarios</span>
                        
                        <span class="badge bg-info" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefFinanciera; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Ver Información Financiera</span>
                        
                        <span class="badge bg-secondary" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefSeguridad; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Seguridad</span>
                    </div>
      </li>
    </ol>
   
<!------------------------------------------------------------------>

    <?php 

  

		}

  

  ?>


<hr class="new1">
    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
	<div class="row"><!----------Div #21--------->
  <div class="col-8" align="left">Total Socios:</div><!----------Abro y Cierro Div #22--------->
  <div class="col-4" align="right"><?php echo $CantAth; ?></div><!----------Abro y Cierro Div #23--------->
  </div><!----------Cierro Div #21--------->

  <?
}else{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
   <div>
   <strong>Alerta!</strong> Socio no encontrado.
   
   </div>
 </div>
 <?
    exit();
 }
 if($idCat==0){

}
  }
?>