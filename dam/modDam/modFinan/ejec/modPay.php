<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idClub=$id_usu;
$idMes=$_GET['idMes'];
//echo"mes: ".$idMes;
include("../../../../enlace/conexion.php");
if (!$conexion) {

    echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

    exit;

}
$idAsoc=$_GET['idAsoc'];
$sQlCOnfig=mysqli_query($conexion,"select * from tcx_config where id_club=".$idClub);
$sQlDto=mysqli_query($conexion,"select * from tcx_descuentox where id_club=".$idClub);
$filaConf=mysqli_fetch_array($sQlCOnfig, MYSQLI_ASSOC);
$filaDto=mysqli_fetch_array($sQlDto, MYSQLI_ASSOC);
$valmes=$filaConf['valmes'];
$valclase=$filaConf['valclase'];
$valextra=$filaConf['valmas'];
$xdias=$filaConf['maxdias'];
$valDto=$filaDto['valor'];
$periodo=date("Y");
///////////////////////////LLENANDO VECTOR DE MESES//////////////////////////////////////
$nMeses=["Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
/////////////CAPTURANDO OPCION DE PAGO/////////////////////////////
$opbusca = $_GET['opbusca'];
$mesActual=(int)date("m");
 /////////////CONSULTAS//////////////////////////////////////////////////////
//////////////////BUSCAR DESCUENTOS PARA EL ASOCIADO Y EL MES//////////////////////


$buscarD=mysqli_query($conexion,"select * from tcx_descuentox where id_club=".$idClub." and id_Dep=".$idAsoc." and ".$idMes." BETWEEN Minicio AND Mfin");
	
$filaD=mysqli_fetch_array($buscarD, MYSQLI_ASSOC);
$valAplica=$filaD['valor'];
	
/////////////////APLICANDO EL DESCUENTO SOBRE LE VALOR DEL MES/////////////////////
$valmes=$valmes-$valAplica;

////////////////////////CONSULTANDO ABONOS /////10 DE AGOSTO 2023////////////////////////
$saldo=$valMes-$subTot;




/////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////ULTIMO MES PAGADO/ COMPLETAMENTE///////////////////////////
 $buscarId=mysqli_query($conexion,"select max(id) as idm from tbx_reg_pago where id_socio=".$idAsoc."  and periodo=".$periodo);
 
	$filaId=mysqli_fetch_array($buscarId, MYSQLI_ASSOC);
	$Idm=(int)$filaId['idm'];

if($Idm>0){
	$buscarMpago=mysqli_query($conexion,"select *  from tbx_reg_pago where id=".$Idm);
 
$filaP=mysqli_fetch_array($buscarMpago, MYSQLI_ASSOC);
$Nmes=(int)$filaP['mes'];
$NmesP=$Nmes;
}

////////////////////BUSCANDO EL ULTIMO MES EN TABLA ABONOS//////////////////////

$buscarIdA=mysqli_query($conexion,"select max(id) as idA from tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and estado=1");

$filaA=mysqli_fetch_array($buscarIdA, MYSQLI_ASSOC);
$IdA=(int)$filaA['idA'];

if($IdA>0){
	$buscarMabono=mysqli_query($conexion,"select *  from tbx_reg_abono where id=".$IdA);
 
$filaAb=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC);

$Nmes=(int)$filaAb['mes'];
$NmesA=$Nmes;
}

/////////////////////////////////////////

if($NmesP>=$NmesA){
	
	$saldo=0;
	//$Nmes=(int)$filaP['mes'];
	$Nmes=$Nmes+1;
}else{
	//$valMes=$valMes;
	$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from  tbx_reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$NmesA);
$filaSUM=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);
$subTot=(int)$filaSUM['subtotal'];
$saldo=$valMes-$subTot;
$Nmes=(int)$filaAb['mes'];


//$valmes=0;
//$saldo=0;





}




?>


<?
if($opbusca==1){
    ?>
    
    <div class="form-row" >
  
       
  <!-------COL 1----------->
 <div class="form-group col-3" >
    <label> Seleccione el mes</label>  
    <select class="custom-select mr-sm-2" name="nMes" id="nMes"  onKeyPress="return focusNext(this.form,'txtVpago',event);" required >
    <?php 
     
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
      <input type="number" disabled name="txtVpago" placeholder="$000.000" id="txtVpago" class="form-control text-end" value="<?= $saldo ?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  />
     </div>
 <!------------------->   
</div>
    <?
}elseif($opbusca==2){
    ?>
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
      <label>Pago Parcial</label>
      <input type="number" name="txtVpago"    placeholder="$000.000" id="txtVpago" class="form-control text-end" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"   />
    </div>
 <!---------COL 3---------->
     <div class="form-group col-3">
      <label>Saldo Anterior</label>
      <input type="number" disabled name="txtParcial" placeholder="0" id="txtParcial" class="form-control text-end" value="<?= $subTot?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  />
     </div>
<!---------COL 4---------->
      <div class="form-group col-3">
      <label>Saldo Total</label>
      <input type="number" disabled name="txtSaldo" placeholder="$000.000" id="txtSaldo" class="form-control text-end" value="<?= $valmes?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  />
     </div>
 <!------------------->   
</div>
    <?

}elseif($opbusca==3){
    ?>
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
      <label>Valor Clase </label>
      <input type="number" name="txtVclase" value="<?= $valclase?>" placeholder="$000.000" id="txtVclase" class="form-control text-end" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  disabled />
    </div>
 <!---------COL 3---------->
     <div class="form-group col-3">
      <label># de Clases</label>
      <input type="number"  name="txtNclase"  placeholder="0" id="txtNclase" onchange="calcular_pago();" onkeyup="calcular_pago();" class="form-control text-end" value="0" required   />
     </div>
<!---------COL 4---------->
      <div class="form-group col-3">
      <label>Total</label>
      <input type="number" disabled  name="txtVpago" placeholder="$000.000" id="txtVpago" class="form-control text-end" value="<?= $saldo ?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  />
     </div>
 <!------------------->   
</div>
    <?
   

}


?>