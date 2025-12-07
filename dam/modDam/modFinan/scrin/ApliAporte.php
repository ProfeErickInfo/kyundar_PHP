<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idClub=$id_usu;
//echo"Club: ".$id_usu;
$idAsoc=(int)$_GET['idAsoc'];

?>

<script>
function comprobar(obj) {
	//alert('EPA!');
  if (obj.checked) {
    document.getElementById("txtSaldo").value = "1";
  } else {
    document.getElementById("txtSaldo").value = "0";
  }
}


</script>


 <?


 ob_end_clean();
 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
  ////////////////////////////////////////Consulta de datos base y descuentos//////////////////////////

  $sQlCOnfig=mysqli_query($conexion,"select * from tcx_config where id_club=".$idClub);
	$sQlDto=mysqli_query($conexion,"select * from tcx_descuentox where id_club=".$idClub);
  $filaConf=mysqli_fetch_array($sQlCOnfig, MYSQLI_ASSOC);
  $filaDto=mysqli_fetch_array($sQlDto, MYSQLI_ASSOC);
  $valmes=$filaConf['valmes'];
  $valclase=$filaConf['valclase'];
  $valextra=$filaC['valmas'];
  $xdias=$filaC['maxdias'];
  //cho"Valor del mes: ".$idClub;
  ////////////////////////////////////////////////////////////////////////////////////////////////////
  $buscarAsoc=mysqli_query($conexion,"select * from tbx_deportistas where id=".$idAsoc);
	$buscarClub=mysqli_query($conexion,"select * from tbx_club where id=".$idClub);
  $fila=mysqli_fetch_array($buscarAsoc, MYSQLI_ASSOC);
  $filaC=mysqli_fetch_array($buscarClub, MYSQLI_ASSOC);
  $Nombres=$fila['nombres'];
  $Apellidos=$fila['apellidos'];
  $valMes=$filaC['valmes'];
  $periodo=2023;
////////////////////////////del edit////////////////////////////
$mesActual=(int)date("m");
$buscarD=mysqli_query($conexion,"select * from tcx_descuentox where id_club=".$idClub." and id_Dep=".$idAsoc." and ".$mesActual." BETWEEN Minicio AND Mfin");
$filaD=mysqli_fetch_array($buscarD, MYSQLI_ASSOC);
$valAplica=$filaD['valor'];
///////////////////////////////////////////////

$valPago=$valmes-$valAplica;
 //$nMeses=array("Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
 /////////////CONSULTAS/////////////////////
 $buscarId=mysqli_query($conexion,"select max(id) as idm from tbx_reg_pago where id_socio=".$idAsoc."  and periodo=".$periodo);
 
	$filaId=mysqli_fetch_array($buscarId, MYSQLI_ASSOC);
	$Idm=(int)$filaId['idm'];

if($Idm>0){
	$buscarMpago=mysqli_query($conexion,"select *  from tbx_reg_pago where id=".$Idm);
 
$filaP=mysqli_fetch_array($buscarMpago, MYSQLI_ASSOC);
$NmesP=(int)$filaP['mes'];
}

/////////////////////////////////////////

$buscarIdA=mysqli_query($conexion,"select max(id) as idA from tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo);

$filaA=mysqli_fetch_array($buscarIdA, MYSQLI_ASSOC);
$IdA=(int)$filaA['idA'];

if($IdA>0){
	$buscarMabono=mysqli_query($conexion,"select *  from tbx_reg_abono where id=".$IdA);
 
$filaAb=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC);
$NmesA=(int)$filaAb['mes'];
}

/////////////////////////////////////////



if($NmesP>=$NmesA){
	
	$saldo="0";
	$Nmes=(int)$filaP['mes'];
	
}else{
	//$valMes=$valMes;
	$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from  tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$NmesA);
$filaSUM=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);
$subTot=(int)$filaSUM['subtotal'];
$saldo=$valMes-$subTot;
$Nmes=(int)$filaAb['mes'];


$valmes=0;
$saldo=0;





}
//$ValPay = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY );
//$valmes=$ValPay->formatCurrency($valmes, "COP");
///////////////////////////////////////////////


$nMeses=["Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];

?>
<html>
 <body >
 


 <form id="frmPago" name="frmPago"  method="post" action="Javascript:enviarFormulario('modDam/modFinan/ejec/add_pago.php?idusu=<?=$id_usu?>&idAsoc=<?=$idAsoc?>','frmPago',1,'modDam/modFinan/scrin/ApliAporte.php?idusu=<?= $id_usu ?>&idAsoc=<?= $idAsoc ?>','carga','DvPago','');">

 <div class="container" >
 <!----------------------->
 <div class="row">
  <div class="col-8 text-secondary" > <?php echo $Nombres.' '.$Apellidos;?> </div>
  <div class="col-4 text-success" ><b> Ultimo Mes: </b><? echo $nMeses[$Nmes]; ?></div>
 

  <br>
  <hr>
  </div>
 <!----------------------->

  <div class="row">
    
  <!-------COL 1----------->
    <div class="col-md-8"><label>  Tipo de Pago</label> 

      <select class="custom-select mr-sm-2" name="optPago" id="optPago" onchange="cargarB('modDam/modFinan/ejec/modPay.php?opbusca='+this.value+'&idAsoc=<?=$idAsoc?>'+'&idMes=<?=$Nmes?>','dVPay');"   required >
        <option value="0">Forma de pago</option> 
        <option value="1">Normal</option>
        <option value="2">Parcial</option>
        <option value="3">Por Clase</option>
        
			</select>            
    </div>  
    
    <!-------COL 2----------->
    <div class="col-md-4"><label>  Fecha de Pago</label>       
        <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaPago" class="form-control"  id="txtFechaPago" onKeyPress="return focusNext(this.form,'',event);" required >           
    </div>

  </div>

  <br>
 <!----------------------->
 <i>Escriba el pago sin puntos segun sea el caso.</i>
 <div  id="dVPay" style="height:60px;">
  <!------------------------------------------------------------------------->
  <fieldset disabled>
  <div class="form-row" >
        
  <!-------COL 1----------->
 <div class="form-group col-3" >
    <label> Seleccione el mes</label>  
    <select class="custom-select mr-sm-2" name="nMes" id="nMes"  onKeyPress="return focusNext(this.form,'txtVpago',event);" required >
     <?php 
     $Nmes=$Nmes+1;
         for ($i=1; $i<sizeof($nMeses); $i++){
          if($i==$Nmes){
            echo "<option selected  value=".$i.">".$nMeses[$i]."</option>";
          }else{  
           echo "<option  value=".$i.">".$nMeses[$i]."</option>";
          }
         }
     ?>
   </select>            
</div> 
<!---------COL 2---------->
<div class="form-group col-3">
      <label>Descuento </label>
      <input type="number" name="txtDto" value="<?= $valAplica?>" placeholder="$000.000" id="txtDto" class="form-control text-end" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  disabled />
    </div>
 <!---------COL 3---------->
    <div class="form-group col-3">
      <label>Aporte </label>
      <input type="number" name="txtValMes" value="<?= $valmes?>" placeholder="$000.000" id="txtValMes" class="form-control text-end" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  disabled />
    </div>
 <!---------COL 4---------->
     <div class="form-group col-3">
      <label>Saldo</label>
      <input type="number" disabled name="txtVpago" placeholder="$000.000" id="txtVpago" class="form-control text-end" value="<?= $valPago ?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  />
     </div>
 <!------------------->   
</div>


  <!------------------------------------------------------------------------->
  </fieldset>
 </div>
<br>
   <!------------QUINTA FILA- BOTON------------->        
<div class="form-row"  > 
 <div class="col-12 " >   
    <button class="btn btn-success" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="valid_PagoMes(this.form);" >Registrar</button>
 </div>
</div> 

<br>  
<hr>



<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <b> Información de Pagos</b>
      </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
<!-------------CONTENIDO DEL AREA 1---------------------->



 <?
 /////////////////////////////////////////

$buscarIdA=mysqli_query($conexion,"select max(id) as idA from tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo);

$filaA=mysqli_fetch_array($buscarIdA, MYSQLI_ASSOC);
$IdA=(int)$filaA['idA'];

if($IdA>0){
	$buscarMabono=mysqli_query($conexion,"select *  from tbx_reg_abono where id=".$IdA);
 
$filaAb=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC);
$NmesA=(int)$filaAb['mes'];
}

/////////////////////////////////////////
/////////////////////////////////////////



if($NmesP>=$NmesA){
	
	$saldo="0";
	$Nmes=(int)$filaP['mes'];
	
}else{
	//$valMes=$valMes;
	$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from  tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$NmesA);
$filaSUM=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);
$subTot=(int)$filaSUM['subtotal'];
$saldo=$valMes-$subTot;
$Nmes=(int)$filaAb['mes'];

}

///////////////////////////////////////////////
$nMeses[$Nmes];
setlocale(LC_MONETARY,"es_CO");
//$subTot= money_format("%.0n",$subTot);

$subT = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY );

?>
 <div class="row" style="color:#000; font-weight:bolder">
 
 <label class="text-success"><b> Ultimo Mes Registrado: </b><? echo $nMeses[$Nmes]; ?></label>
 
 <div class="col-sm-4" >
 <b class="text-secondary"> Abonos </b>
 </div>
 <div class="col-sm-4" >
 <i class="text-danger"> <? echo $subT->formatCurrency($subTot, "COP")."\n"; ?></i>
 </div>
 </div>
<br>
 
 <?
 
//setlocale(LC_MONETARY,"es_CO");
//$saldo= money_format("%.0n",$saldo);
$salD = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY );

 
  while ($filaABS=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC)){
  ?>
  <b> <? echo $filaABS['fecha']." - ".$filaABS['valor'] ?>    </b>
  <?
  }
  ?>
  <hr>
<div class="row">
 <div class="col-sm-4" >
 <b class="text-secondary"> Saldo Actual </b>
 </div>
 <div class="col-sm-4" >
 <i class="text-danger"><? echo $salD->formatCurrency($saldo, "COP")."\n"; ?></i>
 </div>
 </div>
  <!------------------FIN CONTENIDO AREA 1----------------------->


  </div>
  </div>
  </div>
  </div>





 
 
 </div>


 </form>
  

 
 
 </body>
 </html>