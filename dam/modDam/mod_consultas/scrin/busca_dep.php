<?php  
session_start();
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

@session_start();

// obtenemos los datos del formulario.

	$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");
	
	$sqlEvento=mysqli_query($conexion,"select * from tbx_evento where curdate()  BETWEEN fec_ini AND fec_fin");

$sqlCat=mysqli_query($conexion,"select * from tbx_categoria");


$sqlGen=mysqli_query($conexion,"select * from tbx_sexo");

$sqlNivel=mysqli_query($conexion,"select * from tbx_nivel");


	//echo"consultax: ".$conexion;

	//$CantGr = mysql_num_rows($sqlGrados);

$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";

?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">






<table width="100%" class="">



  <tr>

    <td class="headerForm">Consulta de atletas y registralos al evento correspondiente (Cadete, Junior y Senior), selecciona en el orden en el que esta cada lista para activar la lista de atletas.</td>
    

  </tr>

  

  <tr>

    <td style="height:5px;"></td>

  </tr>

  

 </table>
 <div style="display:inline-block; width:30%; float:left; background-color:#069; color:#FFF; font-weight:bolder; font-family:Tahoma, Geneva, sans-serif; margin-right:10px">Evento: 
<select name="nEvento" id="nEvento" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlEvento, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>

</div>

<div style="display:inline-block; width:15%; float:left; background-color:#069; color:#FFF; font-weight:bolder; font-family:Tahoma, Geneva, sans-serif; margin-right:10px">Genero: 
  <select name="Ngen" onchange="cargarFocus('nucleo/consultas/ejec/lista_cat.php?idGen='+this.value,'DvCategoria','carga','');" id="Ngen" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <option value="0">Selecciona uno</option>
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlGen, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>
</div>


<div id="DvCategoria" style="display:inline-block; width:15%; float:left; background-color:#069; color:#FFF; font-weight:bolder; font-family:Tahoma, Geneva, sans-serif; margin-right:10px">Categoria: 
  <select name="Ncat" disabled="disabled" onchange="cargarFocus('nucleo/consultas/ejec/lista_peso.php?idCat='+this.value,'DvPeso','carga','');" id="Ncat" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <option value="0">Selecciona una</option>
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlCat, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>
</div>
<div id="DvPeso" style="display:inline-block; width:15%; float:left; background-color:#069; color:#FFF; font-weight:bolder; font-family:Tahoma, Geneva, sans-serif; margin-right:10px">Peso Kg: 
  <select name="xPeso" disabled="disabled" id="xPeso" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlEvento, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>
</div>
<div id="DvNivel" style="display:inline-block; width:15%; float:left; background-color:#069; color:#FFF; font-weight:bolder; font-family:Tahoma, Geneva, sans-serif; margin-right:10px">Nivel: 
  <select name="nNivel"  id="nNivel" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
 <option value="0">Selecciona uno</option>
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlNivel, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>
</div>

<p>&nbsp;</p>

 
    <table width="100%" class="fondo">

      <tr>

      <td width="15%" style="" class="headerCampo">Buscar x Nombre </td>

        <td width="1%">&nbsp;</td>

        <td width="20%"  ><input type="text" name="txtBuscar" id="txtBuscar" onKeyPress="cargarB('nucleo/consultas/ejec/asig_est.php?opbusca=2&oby=&vbusca='+this.value+'&eVent='+document.getElementById('nEvento').value+'&idGen='+document.getElementById('Ngen').value+'&idCat='+document.getElementById('Ncat').value+'&idNivel='+document.getElementById('nNivel').value+'&peso='+document.getElementById('xPeso').value+'&idTipo=1&esta=1','apDivListaValAsp');" class="inputTxt" /></td>

        <td width="10%" style="cursor:pointer" onclick="cargarB('nucleo/consultas/ejec/asig_est.php?opbusca=2&oby=&vbusca='+document.getElementById('txtBuscar').value+'&eVent='+document.getElementById('nEvento').value+'&idGen='+document.getElementById('Ngen').value+'&idCat='+document.getElementById('Ncat').value+'&idNivel='+document.getElementById('nNivel').value+'&peso='+document.getElementById('xPeso').value+'&idTipo=1&esta=1','apDivListaValAsp');"><img src="imag/busca.png"  id="btnbusca" style="width:40px; height:40px"/></td>

        <td colspan="4" width="54%" style="" >&lt;--Clic Sobre la lupa si desea mostrar todos sus atletas.</td>
		
      </tr>

    </table>





   <table width="100%" class="table">
<thead>
    <tr  style="text-align:center">

      <th  width="25%" align="center"  >Atleta</th>
      <th width="1%" ></th>
      <th width="10%" align="center" >Genero</th>
      <th width="1%" ></th>
      <th width="10%" align="center" >Año</th>
      <th width="1%" ></th>
     
      <th width="52%" align="center" >Asignación</th>

    </tr>
</thead>

  

  

</table>
 <div id="apDivListaValAsp" style="font-size:10px; color:#069; width:100%"></div>


<?php
}
?>

