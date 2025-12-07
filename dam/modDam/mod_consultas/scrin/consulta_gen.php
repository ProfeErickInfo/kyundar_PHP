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
	
	$sqlCat=mysqli_query($conexion,"select * from tbx_categoria");
	
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

<div class="contenedor"><img src="imag/busca.png"  id="btnbusca" style="width:30px; height:30px"/>Busqueda de Deportistas</div>


<div style="width:40%; display:inline-block; vertical-align:top; ">
<form id="frmbusca1" name="frmbusca1">
<div class="dvContP">Deportistas por Categorias [Filtros Agrupados]</div>
<div id="categorias" class="dvCont">    
    <!--INICIO TABLA VALIDACION ASPIRANTES -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr  height="30px">
        <td width="33%" align="center" style="padding-left:10px;" class="headerCampo">Seleccione Categoria</td>
        <td width="1%" >&nbsp;</td>
        <td width="32%" align="center" class="headerCampo">Seleccione Peso</td>
         <td width="1%" >&nbsp;</td>
        <td width="32%" align="center" class="headerCampo">Seleccione Nivel</td>
   		
       
      </tr>
      
      
    <tr  height="50px">
       
        <td  align="center" >
        
       	
		<select onChange="grupoFocus('modDam/mod_consultas/scrin/xpeso.php?xcat='+this.value,'DvPeso','carga','','modDam/mod_consultas/ejec/BtnPdf1.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value,'dvPdf1');"  name="categoria" id="categoria" class="TxtNew" >
		
          <?php
		  echo "<option value='-1'>Seleccione la categoria</option>";
		   echo "<option value='0'>Todas Las Categorias</option>";
				while ($reg=mysqli_fetch_array($sqlCat, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}
			?>
        </select>       </td>
        <td width="1%">&nbsp;</td>
        <td align="center" class="headerCampo"><div id="DvPeso"><select name="peso" id="peso" disabled="disabled" class="TxtNew" >
		
          <?php
		  echo "<option value='-1'>Seleccione el peso</option>";
				echo "<option value='0'>Todos Los Pesos</option>";
				while ($reg=mysqli_fetch_array($sqlPes)){
					
					echo "<option value=".$reg['id'].">".$reg['contenido']."</option>";
				}
			?>
        </select> </td>
		
		 <td width="1%">&nbsp;</td>
        <td  align="center" class="headerCampo"><div id="DvNivel"><select name="nivel" id="nivel" onchange="cargarFocus('modDam/mod_consultas/ejec/BtnPdf1.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value,'dvPdf1','carga','');"  class="TxtNew" >
		
          <?php
		  echo "<option value='-1'>Seleccione el nivel</option>";
		  
				echo "<option value='0'>Todos Los Niveles</option>";
				
				
				while ($regN=mysqli_fetch_array($sqlNivel)){
					
					echo "<option value=".$regN['id'].">".$regN['nombre']."</option>";
				}
			?>
        </select> </td>
		
		
      </tr>    
      
   <tr height="90px"> 
   <td align="left"> 
  
    <input type="checkbox" id="orden1" name="orden1" onclick="activaChk()"  checked class="ChkNew" value="id_Club" ><span><label class="headerCampo" for="orden1">Odenar por club</label></span>

  </td>
   <td></td>
       <td    align="right" ><a title="Buscar Deportista" style="cursor:pointer" onclick="cargarFocus('modDam/mod_consultas/ejec/lista_xpeso.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value,'Dvisual','carga','');"><img src="imag/buscar1.png"  id="btnbusca" style="width:70px; height:70px"/></a></td>
       <td  ></td>
        <td align="right"   >
        <div id="dvPdf1" ><a title="Descargar lista en excel" class="" href="modDam/mod_consultas/Rpdf/ejec/listaxpeso_xls.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value'"><img src="imag/dis_excel.png"  id="btnbusca" style="width:70px; height:70px"/></a>
        
        <a title="Descargar lista en PDF" class="" href="modDam/mod_consultas/Rpdf/ejec/listaxpeso_pdf.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value'"><img src="imag/pdf_dis.png"  id="btnbusca" style="width:70px; height:70px"/></a>
        </div></td></tr></table>
    </div>
  </form>
    </div>
   
<!--FINAL TABLA VALIDACION ASPIRANTES -->
  
  
  <div style="width:29%; display:inline-block; vertical-align:top;">
<div class="dvContP">Listas Generales [Filtros Agrupados]</div>
<div id="categorias" class="dvCont">    
    <!--INICIO TABLA VALIDACION ASPIRANTES -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr  height="30px">
        
        <td width="48%" align="center" class="headerCampo">Buscar por Club</td>
         <td width="1%" >&nbsp;</td>
        <td width="48%" align="center" class="headerCampo">Buscar por Genero</td>
   		
       
      </tr>
      
      
    <tr  height="50px">
       
       
        <td align="center"  class="headerCampo"><select name="club" id="club" onchange="grupoFocus('modDam/mod_consultas/ejec/BtnPdf2.php?clb='+club.value+'&gen='+genero.value,'dvPdf2','carga','','modDam/mod_consultas/ejec/BtnXls2B.php?clb='+club.value+'&gen='+genero.value,'dvXls2B');"  class="TxtNew" >
		
          <?php
		  echo "<option value='-1'>Seleccione el club</option>";
				echo "<option value='0'>Todos los clubes</option>";
				
				while ($regCl=mysqli_fetch_array($sqlClub)){
					
					echo "<option value=".$regCl['id'].">".$regCl['nombre']."</option>";
				}
			?>
        </select> </td>
		
		 <td width="1%">&nbsp;</td>
        <td  align="center" class="headerCampo" ><select name="genero" id="genero"  onchange="grupoFocus('modDam/mod_consultas/ejec/BtnPdf2.php?clb='+club.value+'&gen='+genero.value,'dvPdf2','carga','','modDam/mod_consultas/ejec/BtnXls2B.php?clb='+club.value+'&gen='+genero.value,'dvXls2B');"   class="TxtNew" >
		
          <?php
		  echo "<option value='-1'>Seleccione el genero</option>";
				echo "<option value='0'>Todos los generos</option>";
				
				while ($regGn=mysqli_fetch_array($sqlGen)){
					
					echo "<option value=".$regGn['id'].">".$regGn['nombre']."</option>";
				}
			?>
        </select> </td>
		
		
      </tr>    
      
   <tr  height="90px"> 
    
     <td    align="right"  >
      <div id="dvPdf2" >
     <a title="Buscar Deportista" style="cursor:pointer" onclick="cargarFocus('modDam/mod_consultas/ejec/listaxgenero.php?clb='+club.value+'&gen='+genero.value,'Dvisual','carga','');"><img src="imag/buscar1.png"  id="btnbusca" style="width:70px; height:70px"/></a> 
    
     <a title="Descargar lista en PDF"  ><img src="imag/pdf_dis.png"    id="btnbusca"  style="width:70px; height:70px"/></a> </div></td>
       <td  ></td>
        <td align="right"   > <div id="dvXls2B" ><a title="Descargar lista en excel" class="" href="modDam/mod_consultas/Rpdf/ejec/listaxgenero_xls.php?cat='+categoria.value+'&pes='+categoria.value+'&niv='+categoria.value+'&orden1='+orden1.value'"><img src="imag/dis_excel.png"  id="btnbusca" style="width:70px; height:70px"/></a></div>
        
      </td></tr></table>
    </div>
  
   </div>
  
<div style="width:30%; display:inline-block; vertical-align:top; float:right;">   
<div class="dvContP">Otras listas [Filtros Individuales]</div>
<div id="categorias" class="dvCont">    
    <table width="100%" class="fondo">

      <tr>

        <td width="15%" style="padding-left:10px;" class="headerCampo" >Por Grado</td>

        <td width="40%%" ><select name="Grados" id="Grados" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZ.php?tpc=id_grado&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv.php?tpc=id_grado&dto='+this.value,'Dv1');" class="TxtNew">
          <?php
                echo "<option value='-1'>Seleccione el grado</option>";
				//echo "<option value='0'>Todos los grados</option>";

				

				while ($reg=mysqli_fetch_array($sqlGrados, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

			?>
        </select></td>
        <td width="1%" >&nbsp;</td>
       <td width="10%" style="cursor:pointer" onkeypress="cargarB('modDam/mod_consultas/ejec/listaZ.php?opbusca=3&oby=&vbusca='+document.getElementById('txtBuscarDoc').value,'Dvisual');">&nbsp;</td>
        <td width="10%" style="cursor:pointer"><div id="Dv1"  ><img src="imag/pdf_dis.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>
</tr>

<tr>
        <td width="15%" style="padding-left:10px" class="headerCampo">Por Nombres o apellidos </td>

        <td ><input type="text"  
          name="txtBuscar" id="txtBuscar" onkeyup="cargarB('modDam/mod_consultas/ejec/listaZ.php?tpc=nombres&dto='+this.value,'Dvisual');" class="TxtNew" /></td>
<td width="1%" >&nbsp;</td>
         <td width="5%" style="cursor:pointer" onclick="cargarB('modDam/mod_consultas/ejec/lista_est.php?tpc=nombres&dto='+document.getElementById('txtBuscar').value,'Dvisual');">&nbsp;</td>
          <td width="10%" style="cursor:pointer" ><div id="Dv2"  ><img src="imag/texto_gris.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>
</tr>

<tr>
        <td  style="padding-left:10px;" class="headerCampo">Por Documento </td>
		<td  style="padding-left:1px;"><input type="text" name="txtBuscarDoc" id="txtBuscarDoc" onkeyup="cargarB('modDam/mod_consultas/ejec/listaZ.php?tpc=documento&dto='+this.value,'Dvisual');" class="TxtNew" /></td>
        <td width="1%" >&nbsp;</td>
         <td style="cursor:pointer" onclick="cargarB('modDam/mod_consultas/ejec/lista_est.php?opbusca=3&oby=&vbusca='+document.getElementById('txtBuscarDoc').value,'Dvisual');">&nbsp;</td>
          <td width="10%" style="cursor:pointer" ><div id="Dv3"  ><img src="imag/texto_gris.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>

      </tr>


    </table>

 <table height="63px" width="100%" cellspacing="0" >
 <tr  class="headerCampo"> 
 <td><select name="localidad" id="localidad" class="TxtNew" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZ.php?tpc=localidad&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv.php?tpc=localidad&dto='+this.value,'Dv4');">
          <?php
                echo "<option value='-1'>Seleccione la localidad</option>";
				//echo "<option value='0'>Todos las localidades</option>";

				

				
					echo "<option value=1>"."Localidad 1"."</option>";
					echo "<option value=2>"."Localidad 2"."</option>";
					echo "<option value=3>"."Localidad 3"."</option>";
					

			

			?>
        </select></td>
 <td width="10%" style="cursor:pointer" ><div id="Dv4"  ><img src="imag/pdf_dis.png"  id="btnbusca" style="width:30px; height:30px"/></div></td>

 
<td><select name="lugar" id="lugar" onchange="grupoFocus('modDam/mod_consultas/ejec/listaZ.php?tpc=tipo_lugar&dto='+this.value,'Dvisual','carga','','modDam/mod_consultas/ejec/BtnPdfv.php?tpc=tipo_lugar&dto='+this.value,'Dv5');" class="TxtNew">
          <?php
                echo "<option value='-1'>Seleccione el lugar</option>";
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

