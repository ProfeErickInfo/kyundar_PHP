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
			include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	} 
	
	$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios");
	
	$sqlPes=mysqli_query($conexion,"select * from tbx_pesos");
	
	//$CantGr = mysql_num_rows($sqlGrados);
	
			$link="lista_general";
			$link2="lista_asistencia";
$ano="1";
$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");
$sqlNivel=mysqli_query($conexion,"select * from tbx_nivel where id >1");

$sqlGen=mysqli_query($conexion,"select * from tbx_sexo");
$sqlClub=mysqli_query($conexion,"select * from tbx_club");

	
$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";
?>



<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>



<style type="text/css">
<!--
.DvEstilo_lista{
	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	font-size: 12px;
	margin-top:15px;
	width:100%;
	position:relative;
	height:400px;
	overflow:auto;
	
}
	
-->
/* The container */
<!-------------------input check------------------------------------->

.demo input[type="checkbox"] {
	display: none;
}
.demo input[type="checkbox"] + label span {
	display: inline-block;
	width: 15px;
	height: 15px;
	margin: -1px 4px 0 0;
	vertical-align: middle;
	background: url(imag/checkbox-uncheck.png);
	background-size: cover;
	cursor: pointer;
}
.demo input[type="checkbox"]:checked + label span {
	background: url(imag/checkbox-check.png);
	background-size: cover;
}
</style>
<script>
document.getElementById("link").addEventListener("click", function(){
    const ventana = window.open("https://google.com.pe","_blank");
    setTimeout(function(){
        ventana.close();
    }, 5000); /* 5 Segundos*/
});
</script>

<div class="contenedor"><img src="imag/busca.png"  id="btnbusca" style="width:30px; height:30px"/>Busqueda de Clubes</div>

<!--FINAL TABLA VALIDACION ASPIRANTES -->

<div style="width:100%;  vertical-align:top; float:none;">   
  <div class="dvContP">Listas de clubes [Filtros Individuales]</div>
<div id="categorias" class="dvCont">  
  
    <table width="100%" class="fondo">

      <tr>

        <td width="5%" style="padding-left:10px;" class="headerCampo" >Barrio: </td>

        <td width="10%" ><select name="Barrio" id="Barrio" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZclub.php?tpc=id_barrio&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv2.php?tpc=id_barrio&dto='+this.value,'Dv1');" class="TxtNew">
          <?php
                echo "<option value='-1'>Seleccione el barrio</option>";
				//echo "<option value='0'>Todos los grados</option>";

				

				while ($reg=mysqli_fetch_array($sqlBarrio)){

					

					echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";

				}

			?>
        </select></td>
        <td width="1%" >&nbsp;</td>
        <td width="5%" style="cursor:pointer"><div id="Dv1"  ><img src="imag/pdf_dis.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>
         <td width="5%" style="padding-left:10px" class="headerCampo">Por Nombre</td>

        <td width="10%"  ><input type="text"  
          name="txtBuscar" id="txtBuscar" onkeyup="cargarB('modDam/mod_consultas/ejec/listaZclub.php?tpc=nombre&dto='+this.value,'Dvisual');" class="TxtNew" /></td>
<td width="1%" >&nbsp;</td>
         <td width="5%" style="cursor:pointer" >&nbsp;</td>
          <td width="10%" style="cursor:pointer" ><div id="Dv2"  ><img src="imag/texto_gris.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>
 <td><select name="localidad" id="localidad" class="TxtNew" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZclub.php?tpc=localidad&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv2.php?tpc=localidad&dto='+this.value,'Dv4');">
          <?php
                echo "<option value='-1'>Seleccione la localidad</option>";
				//echo "<option value='0'>Todos las localidades</option>";

				

				
					echo "<option value=1>"."Localidad 1"."</option>";
					echo "<option value=2>"."Localidad 2"."</option>";
					echo "<option value=3>"."Localidad 3"."</option>";
					

			

			?>
        </select></td>
 <td width="10%" style="cursor:pointer" ><div id="Dv4"  ><img src="imag/pdf_dis.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>

 
<td><select name="lugar" id="lugar" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZclub.php?tpc=tipo_lugar&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv2.php?tpc=tipo_lugar&dto='+this.value,'Dv5');" class="TxtNew">
          <?php
                echo "<option value='-1'>Seleccione el territorio</option>";
				//echo "<option value='0'>Todos los deportistas</option>";
                echo "<option value='1'>Departamento</option>";
				echo "<option value='2'>Distrito</option>";
				


			?>
        </select></td>
<td width="10%" style="cursor:pointer" ><div id="Dv5"  ><img src="imag/pdf_dis.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>
</tr>



    </table>

 
  

  

</div>

</div>
 
 
 <div class="DvEstilo_lista"  id="Dvisual"  ></div>

<?php
}
?>

