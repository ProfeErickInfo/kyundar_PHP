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
  $Back = "JavaScript:cargarFocus('modDam/mod_registro/scrin/consulta_est.php?idDep=".$idDep."','DivContenido','carga','');";

	
$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");
$CantGr = mysqli_num_rows($sqlGrados);
		

		$Query = "select id, id_deportista, id_info, fecha from tbx_infoxgrado  where id_deportista=".$idDep;

		


	$sqlDep=mysqli_query($conexion,$Query);

	

	$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);
	$CantDep = mysqli_num_rows($sqlDep);
	
//Codigo nuevo traer datos del atleta;
	
$Query2 = "select a.id, a.film, a.nombres, a.apellidos, a.cod_int, a.fecha_nac  , a.documento, a.sexo from tbx_deportistas  a  where  a.id=".$idDep;
$sqlAth = mysqli_query($conexion, $Query2);
		
$fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC);
?>


<div class="containe-fluidr">
  <div class="h4"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div>
<h5>Registro de Grados </h5>
  <div class="row">
    <div class="col">
      <select name="Grados" id="Grados" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar',event);">
      <?php 
             echo "<option value=0>Seleccione Grado</option>";
          while ($reg=mysqli_fetch_array($sqlGrados, MYSQLI_NUM)){
                echo "<option value=".$reg[0].">".$reg[1]."</option>";
          } ?>

 </select>
    </div>
    <div class="col">
    <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac"  id="txtFechaNac"  class="form-control">
    </div>
    <div class="col">
    <input type="button" name="btnRegistrar" id="btnRegistrar" onclick="Javascript:grupoFocus('modDam/mod_registro/ejec/add_grado.php?idDep=<?=$idDep?>&grado='+document.getElementById('Grados').value+'&fecha='+document.getElementById('txtFechaNac').value,'mensa','carga','','','','');" value="Actualizar" class="btn btn-success" /> 
    </div>
    <div class="col" id="mensa">
   </div>
  </div>

<br>
<hr>


  <table width="100%" class="table table-striped">
<thead>
    <tr  style="text-align:center">

      <th  >Grado</th>

      <th  ></th>

      <th   >Fecha</th>

      <th  ></th>

      <th   >Retirar</th>

    </tr>
</thead>
<tbody>
    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php
	if($CantDep>0){
	$ImgEdit = "imag/cancel.png";
$Href = "JavaScript:cargarFocus('modDam/mod_registro/ejec/del_grado.php?idReg=".$resultados["id"]."&idDep=$idDep','mensa','carga','');";
$Comenta = "Clic aqui para eliminar el grado del deportista.";
	
	
	 ?>

			
    <tr  >

      <td><?php 
	  $sqlNgrado=mysqli_query($conexion,"select * from tbx_grados where id=". $resultados["id_info"]);

	 $NombreGr=mysqli_fetch_array($sqlNgrado, MYSQLI_ASSOC);
	  echo $NombreGr["nombre"];
	  
	  
	  
	  ?></td>

      <td></td>

      <td><?php echo $resultados["fecha"]; ?></td>

      <td></td>

      <td align="center"><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="30" height="30" border="0" /></a></td>

    </tr>
    <?
	}
	/////////////////////////////////////////////
	
	 while ($resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC)){
      // echo "Res: ".$resultados;
$ImgEdit = "imag/cancel.png";
$Href = "JavaScript:cargarFocus('modDam/mod_registro/ejec/del_grado.php?idReg=".$resultados["id"]."&idDep=$idDep','mensa','carga','');";
$Comenta = "Clic aqui para eliminar el grado del deportista.";
			

				
	
	 ?>

    <tr   >

      <td><?php 
	  $sqlNgrado=mysqli_query($conexion,"select * from tbx_grados where id=". $resultados["id_info"]);

	 $NombreGr=mysqli_fetch_array($sqlNgrado, MYSQLI_ASSOC);
	  echo $NombreGr["nombre"];
	  
	  
	  
	  ?></td>

      <td></td>

      <td><?php echo $resultados["fecha"]; ?></td>

      <td></td>

      <td align="center"><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="30" height="30" border="0" /></a></td>

    </tr>

<?
	 }
	 
	///////////////////////////////////////////// 
?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

    <tr class="headerLista">
 <td colspan="5">&nbsp;</td>

      

    </tr>

   </tbody>
  </table>

  

  

  </div>
    <?php



	
}

?>