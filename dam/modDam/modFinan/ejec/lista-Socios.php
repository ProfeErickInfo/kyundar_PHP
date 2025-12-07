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
   ////////////////////////////del edit////////////////////////////

 $nMeses=array("Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
 /////////////CONSULTAS/////////////////////
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
  if(!empty($vBusca) && $opbusca==1){
    $Query = "select a.id, a.nombres, a.apellidos, a.film,(select f1.valor from tcx_descuentox as f1 where a.id=f1.id_Dep) as valD,(select f2.Minicio from tcx_descuentox as f2 where a.id=f2.id_Dep) as mInicio,(select f3.Mfin from tcx_descuentox as f3 where a.id=f3.id_Dep) as mFin from tbx_deportistas a where a.id_Club=".$id_usu." and concat(a.nombres,' ',a.apellidos) like '%".$vBusca."%'  order by ".$OrderBy;

   }elseif(empty($vBusca) && $opbusca==2){
      $Query = "select f.id_Dep, f.valor, f.Minicio, f. Mfin, (select a1.nombres from tbx_deportistas as a1 where f.id_Dep=a1.id) as nombres,(select a2.apellidos from tbx_deportistas as a2 where f.id_Dep=a2.id) as apellidos,(select a3.film from tbx_deportistas as a3 where f.id_Dep=a3.id) as film from tcx_descuentox f where f.id_Club=".$id_usu."  order by f.id";

}
//echo"cons: ".$Query;
	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

if($CantAth!=0){



//////////////////////////////////////////////
while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){

        if($opbusca==1){
            $idD=$fila['id'];
             
         }else{
             $idD=$fila['id_Dep'];
             
         }
           clearstatcache();
          
            if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
                $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
              } else {
                  $ImgEdit = "imag/usu_dep.png";
            }
             

     
      
                   $ImgEdit2 = "imag/editar.png";
                   $Href = "JavaScript:cargarFocus('modDam/modFinan/ejec/apliDescuento.php?idDep=".$idD."&vali='+document.getElementById('valDto$idD').value+'&ini='+document.getElementById('minicio$idD').value+'&fin='+document.getElementById('mfin$idD').value,'".$idD."','carga','');";
                   $Comenta = "Clic sobre la imagen para acceder a la edicion del Atleta.";
                   $infoD = ($fila['valor']>0) ? "Descuento Aplicado!" : "Sin Descuento!";
                   $colorD = ($fila['valor']>0) ? "text-secondary" : "text-secondary";
                   $textoD = ($fila['valor']>0) ? "Actualizar" : "Aplicar";
                   $btnD = ($fila['valor']>0) ? "badge bg-warning rounded-pill" : "badge bg-success rounded-pill";

                 



?>

<!--------------------CODIGO NUEVO--------------------------------------->
<div id="DV<?=$idD?>">
 
<ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start">
      <div  aria-rowspan="2"><img src="<?= $ImgEdit ?>" alt="" width="60" height="80"  /></div><!----------Abro y Cierro Div #17--------->
      <div class="ms-2 me-auto"><!----------Div #18--------->
     
        <div class="fw-bold">
        <!---------------------------------------------------------------->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">  <label ><?php echo $fila['nombres']." ".$fila['apellidos']; ?></label>
                <small class="<?=$colorD ?> "><div id="<?=$idD?>"><? echo $infoD?></div></small>
              </div>
                <div class="col-sm-2"> <label for="valmes" class="form-label">Valor Dcto.</label>
                     <input type="text"   value="<?=$fila['valor']?>"id="valDto<?=$idD?>" name="valDto" class="form-control" placeholder="" required="required">
                </div>

                <div class="col-sm-2"><label for="minicio" class="form-label">Desde</label>
                 <select id="minicio<?=$idD?>" class="form-select">
                    <?php 
			            for ($i=1; $i<sizeof($nMeses); $i++){
                    if($fila['Minicio']==$i){

                      echo "<option selected value=".$i.">".$nMeses[$i]."</option>";
                    }else{

                      echo "<option value=".$i.">".$nMeses[$i]."</option>";
                    }
			                
			            }
			        ?>
                 </select>
                </div>
                
      
      
                <div class="col-sm-2"><label for="mfin" class="form-label">Hasta</label>
                       <select id="mfin<?=$idD?>" class="form-select">
                         <?php 
		                	for ($i=1; $i<sizeof($nMeses); $i++){
                        if($fila['Mfin']==$i){

                          echo "<option selected value=".$i.">".$nMeses[$i]."</option>";
                        }else{
    
                          echo "<option value=".$i.">".$nMeses[$i]."</option>";
                        }
                          
			                }
			             ?>
                       </select>
                </div>
            </div>
           
        </div>
        
     
        <!----------------------------------------------------------------->
       
    
    
        </div><!----------Abro y Cierro Div #19--------->
      
       
      </div><!----------Cierro Div #18--------->
      <span onclick="<?= $Href ?>" class="<?=$btnD ?>" style=" cursor: pointer;"><? echo $textoD ?></span>
     
      </li>
    </ol>
</div>
<!------------------------------------------------------------------>


<?
}
?>


<br>
<hr class="new1">
    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
	<div class="row" style="color: darkslateblue; font-weight: bolder;"><!----------Div #21--------->
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