<?PHP
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
session_start();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap ya está cargado en el menú principal - Comentado para evitar conflictos

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
$id_usu=(int)@$_SESSION['id_usuario'];
$idClub=$id_usu;
$idAsoc=(int)$_GET['idAsoc'];
$periodo=date("Y");

 ob_end_clean();
 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
  $buscarAsoc=mysqli_query($conexion,"select * from tbx_deportistas where id=".$idAsoc);
	$buscarClub=mysqli_query($conexion,"select * from tbx_club where id=".$idClub);
  $fila=mysqli_fetch_array($buscarAsoc, MYSQLI_ASSOC);
  $filaC=mysqli_fetch_array($buscarClub, MYSQLI_ASSOC);
  $Nombres=$fila['nombres'];
  $Apellidos=$fila['apellidos'];
  $valMes=$filaC['valmes'];
  
////////////////////////////del edit////////////////////////////

 $nMeses=array("Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
 /////////////CONSULTAS/////////////////////
 $buscarId=mysqli_query($conexion,"select max(id) as idm from reg_pago where id_socio=".$idAsoc."  and periodo=".$periodo);
 
	$filaId=mysqli_fetch_array($buscarId, MYSQLI_ASSOC);
	$Idm=(int)$filaId['idm'];

if($Idm>0){
	$buscarMpago=mysqli_query($conexion,"select *  from reg_pago where id=".$Idm);
 
$filaP=mysqli_fetch_array($buscarMpago, MYSQLI_ASSOC);
$NmesP=(int)$filaP['mes'];
}

/////////////////////////////////////////

$buscarIdA=mysqli_query($conexion,"select max(id) as idA from reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo);

$filaA=mysqli_fetch_array($buscarIdA, MYSQLI_ASSOC);
$IdA=(int)$filaA['idA'];

if($IdA>0){
	$buscarMabono=mysqli_query($conexion,"select *  from reg_abono where id=".$IdA);
 
$filaAb=mysqli_fetch_array($buscarMabono, MYSQLI_ASSOC);
$NmesA=(int)$filaAb['mes'];
}

/////////////////////////////////////////



if($NmesP>=$NmesA){
	
	$saldo="0";
	$Nmes=(int)$filaP['mes'];
	
}else{
	$valMes=$valMes;
	$SumaAbono=mysqli_query($conexion,"select SUM(valor) as subtotal from  reg_abono where id_socio=".$idAsoc."  and periodo=".$periodo." and mes=".$NmesA);
$filaSUM=mysqli_fetch_array($SumaAbono, MYSQLI_ASSOC);
$subTot=(int)$filaSUM['subtotal'];
$saldo=$valMes-$subTot;
$Nmes=(int)$filaAb['mes'];

}

///////////////////////////////////////////////




$nMeses[$Nmes]
 
 
 ?>
 <!-- <body> comentado para evitar conflictos con el contenedor principal -->
  
 
 <form id="frmPago" name="frmPago" style="color:#000; font-weight:bolder"  method="post" action="Javascript:enviarFormulario('modDam/mod_registro/ejec/add_pago.php?idusu=<?=$id_usu?>&idAsoc=<?=$idAsoc?>','frmPago',1,'modDam/mod_registro/scrin/facturApp.php?idusu=<?= $id_usu ?>&idAsoc=<?= $idAsoc ?>','carga','DivContenido','txtNombres');">
 <div class="container" style="color:#000; font-weight:bolder">
  <div class="row">
  <div class="col" style="color:#ffff; font-size:large; font-family:Tahoma, Geneva, sans-serif ;background-color:#09C; padding:3%; border-color:#666"> Recibo <?php echo $Nombres.' '.$Apellidos;?></div>
  </div>
  <div class="row">
  <div style="font-weight:bolder">Tipo de Pago </div>
  <div class="btn-group col-md-4 ">

<select class="custom-select mr-sm-2" name="optAbono" id="optAbono"   required >
<option value="1">Normal</option>
<option value="2">Abono</option>
<option value="3">Saldo Final</option>
<option value="4">Por Clase</option>
			
        </select>            
 




         
</div>     
  
  
  </div>
  <div class="form-row">
  
  
  <div class="form-group col-md-3"><label>  Fecha de Pago</label>       
                
    <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaPago" class="form-control"  id="txtFechaPago" onKeyPress="return focusNext(this.form,'',event);" required >           
                
                
         </div>
  
             
  <div class="form-group col-md-3" ><label>
 
 </label>
  <label> Seleccione el mes</label>  <select class="custom-select mr-sm-2" name="nMes" id="nMes"  onKeyPress="return focusNext(this.form,'txtVpago',event);" required ><?php 
			for ($i=1; $i<sizeof($nMeses); $i++){
			echo "<option value=".$i.">".$nMeses[$i]."</option>";
			}
			?>
        </select>            
  </div>              
  <div class="form-group col-md-3">
   <label>Escriba el pago sin puntos</label>
   <input type="number" name="txtVpago" value=<?= $valMes?> placeholder="$000.000" id="txtVpago" class="form-control" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  /></div> 
   </div>
   <div class="row">
   <div class="form-group col-md-3">
   <label>Saldo</label>
   <input type="number" disabled name="txtSaldo" placeholder="$000.000" id="txtSaldo" class="form-control" value="<?= $saldo ?>" required onKeyPress="return focusNextNum(this.form,'txtFechaPago',event);"  /></div> 
 
 
 
 
 
 </div>
 
   <!------------QUINTA FILA-------------->        
<div class="form-row"  align="right"> 
<div class="col" > 

 <div id="carga" style="visibility:hidden; "><img src="imag/loadw.gif" alt="" width="50" height="50" /></div>

  
</div>
 <div class="col-4" align="right">   
              
    <button class="btn btn-success" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="valid_PagoMes(this.form);" >Registrar</button>
                                
            
        
   
</div>
     <div class="col-4" align="right">   
           
    <button class="btn btn-danger" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="JavaScript:cargarFocus('modDam/mod_consultas/scrin/ListApp.php','DivContenido','carga','');" >Regresar</button>

</div>

</div>            
 <?
 
setlocale(LC_MONETARY,"es_CO");
$subTot= money_format("%.0n",$subTot);
?>
 <div class="row" style="color:#000; font-weight:bolder">
 
 <h5 style="color:#ffff; background-color:#666; border-color:#666"> Ultimo Mes: <? echo $nMeses[$Nmes]; ?></h5>
 <div class="row">
 <div class="col" style="border-color:#666">
 <h4 style="color:#666"> Abonos </h4>
 <h4 style="color:#666"> <? echo $subTot; ?></h4>
 </div>
   
 
 <?
 
setlocale(LC_MONETARY,"es_CO");
$saldo= money_format("%.0n",$saldo);
 
  while ($filaABS=mysqli_fetch_array($buscarAbono, MYSQLI_ASSOC)){
  ?>
  <b> <? echo $filaABS['fecha']." - ".$filaABS['valor'] ?>    </b>
  <?
  }
  ?>
   <div class="col" style="border-color:#666">
 <h3 style="color:#666" >Saldo Actual </h3>
 <h3 style="color:#666" ><? echo $saldo; ?></h3>

 </div>
 
 
 
 </div>
  
 
 
 </div>

 
 </form>
  

 
 
 </body>

