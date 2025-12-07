<?PHP
session_start();
//if (!$ref || $ref != 'una_url.php')  
$id_usu=(int)@$_SESSION['id_usuario'];
if (($id_usu==0)){
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
$fec_actual=date('Y-m-d');	

//////////////////////////////////////////////    
if(!empty($vBusca) && $opbusca==1){
  $Query ="select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.film, (select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." and concat(a.nombres,' ',a.apellidos) like '%".$vBusca."%'  order by ".$OrderBy;
  }elseif(empty($vBusca) && $opbusca==2){
  $Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.film, (select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by nombres";
}elseif(empty($vBusca) && empty($opbusca)){
	
  $Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.film, (select g.nombre from tbx_sexo g where g.id=a.sexo) AS genero  , a.documento, a.sexo from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by nombres limit 10";
}
//echo"cons: ".$Query;
	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

if($CantAth!=0){



//////////////////////////////////////////////
while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
    
  if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
    $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
  } else {
      $ImgEdit = "imag/usu_dep.png";
}
 
				$Href = "JavaScript:cargarFocus('modDam/modFinan/scrin/ApliAporte.php?idAsoc=".$fila['id']."','DvPago','carga','');";
				

  ?>

 <!--------------------CODIGO NUEVO--------------------------------------->


 
    <ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start">
      <div><img src="<?= $ImgEdit ?>" alt="" width="40" height="50"  /></div><!----------Abro y Cierro Div #17--------->
      <div class="ms-2 me-auto text-capitalize"><!----------Div #18--------->
     
        <div class="fw  "><small><?php echo strtolower($fila['nombres'])." ".strtolower($fila['apellidos']); ?></small></div><!----------Abro y Cierro Div #19--------->
        <span onclick="<?= $Href ?>" style="cursor: pointer;" class="badge bg-primary rounded-pill">Aplicar Pago</span>
     
      </div><!----------Cierro Div #18--------->
     
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