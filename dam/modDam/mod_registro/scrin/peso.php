<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
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



	$idDep = $_GET['idDep'];
     // echo "D:".$idDep; 
	

		

		$Query = "select id, id_deportista, info, fecha from tbx_infoxpeso  where id_deportista=".$idDep;

		
//echo "select id, id_deportista, info, fecha from tbx_infoxpeso  where id_deportista=".$idDep;

	$sqlDep=mysqli_query($conexion,$Query);

	//$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);
	$CantDep = mysqli_num_rows($sqlDep);
  //echo "CDP: ".$CantDep;
	

	


		
//Codigo nuevo traer datos del atleta;
	
$Query2 = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac  , a.documento, a.sexo from tbx_deportistas  a  where  a.id=".$idDep;
$sqlAth = mysqli_query($conexion, $Query2);
		
$fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC);
?>

<div class="containe-fluidr"></div>


<div class="h4"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div>
<h5>Registro de Peso en Kilogramos </h5>
<form id="formPE" name="formPE" method="get">
  <div class="row">
    <div class="col">
    <input type="text" name="txtPeso" placeholder="0 Kg." id="txtPeso" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" value=""/>
    </div>
    <div class="col">
    <input size="12" placeholder="00/00/0000" type="date" class="form-control"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac"  id="txtFechaNac" >
    </div>
    <div class="col">
    <input type="button" name="btnRegistrar" id="btnRegistrar" onclick="Javascript:grupoFocus('modDam/mod_registro/ejec/add_peso.php?idDep=<?=$idDep?>&txtPeso='+document.getElementById('txtPeso').value+'&txtFechaNac='+document.getElementById('txtFechaNac').value,'mense','carga','','','','');" value="Actualizar" class="btn btn-success" />  
   
  </div>
    <div class="col" id="mense">
   </div>
  </div>
  </form>
<br>
<hr>


  <table width="100%" class="table table-striped">
<thead>
    <tr  style="text-align:center">

      <th  >Peso</th>

      <th ></th>

      <th  >Fecha</th>

      <th  ></th>

      <th  >Retirar</th>

    </tr>
</thead>
<tbody>
    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php
	if($CantDep>0){
	
	/////////////////////////////////////////////
	
	 while ($resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC)){
      // echo "Res: ".$resultados;
$ImgEdit = "imag/cancel.png";
$Href = "JavaScript:cargarFocus('modDam/mod_registro/ejec/del_peso.php?idReg=".$resultados["id"]."&idDep=$idDep','mense','carga','');";
$Comenta = "Clic aqui para eliminar el peso del deportista.";
			

				
	
	 ?>

    <tr   >

      <td><?php echo $resultados["info"]; ?></td>

      <td></td>

      <td><?php echo $resultados["fecha"]; ?></td>

      <td></td>

      <td ><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="30" height="30"  /></a></td>

    </tr>

<?
	 }
	 
	///////////////////////////////////////////// 
?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

    <tr class="headerLista"><td colspan="5">&nbsp;</td>  

    </tr>
   </tbody>
  </table>

  </form>
  </div>
 <? 
}}
 

?>