<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
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

	//echo"consultax: ".$conexion;

	//$CantGr = mysql_num_rows($sqlGrados);

$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";

?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">






<table width="100%" class="fondo">



  <tr>

    <td class="headerForm">Seleccionar de una lista</td>
    

  </tr>

  

  <tr>

    <td style="height:5px;"></td>

  </tr>

  

</table>
    <table width="100%" class="fondo">

      <tr>

        <td width="15%" ><select name="Grados" id="Grados" onChange="cargarFocus('nucleo/consultas/ejec/lista_k.php?opbusca=1&oby=&vbusca='+this.value,'apDivListaValAsp','carga','Grados');" class="inputTxt">
        
      

          <?php
                echo "<option value='-1'>Seleccione el grado</option>";
				echo "<option value='0'>Todos los grados</option>";

				

				while ($reg=mysqli_fetch_array($sqlGrados, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

			?>

        </select>
</td>

        <td width="1%" >&nbsp;</td>

        <td width="15%" style="padding-left:30px;" class="headerCampo">Buscar x Nombre </td>

        <td width="1%">&nbsp;</td>

        <td width="20%"  ><input type="text" name="txtBuscar" id="txtBuscar" onKeyPress="cargarB('nucleo/consultas/ejec/lista_k.php?opbusca=2&oby=&vbusca='+this.value,'apDivListaValAsp');" class="inputTxt" /></td>

        <td width="5%" style="cursor:pointer" onclick="cargarB('nucleo/consultas/ejec/lista_k.php?opbusca=2&oby=&vbusca='+document.getElementById('txtBuscar').value,'apDivListaValAsp');"><img src="imag/busca.png"  id="btnbusca" style="width:40px; height:40px"/></td>

        <td width="15%" style="padding-left:30px;" class="headerCampo">Buscar x Documento </td>
		<td width="20%" style="padding-left:1px;"><input type="text" name="txtBuscarDoc" id="txtBuscarDoc" onKeyPress="cargarB('nucleo/consultas/ejec/lista_k.php?opbusca=3&oby=&vbusca='+this.value,'apDivListaValAsp');" class="inputTxt" /></td>
        <td width="5%" style="cursor:pointer" onclick="cargarB('nucleo/consultas/ejec/lista_k.php?opbusca=3&oby=&vbusca='+document.getElementById('txtBuscarDoc').value,'apDivListaValAsp');"><img src="imag/busca.png"  id="btnbusca" style="width:40px; height:40px"/></td>
 <td width="5%">&nbsp;</td>
      </tr>

    </table>

   <table width="100%" class="table">
<thead>
    <tr  style="text-align:center">

      <th width="10%" align="center"  >Todo        <input type="checkbox" name="todo" onclick="if(this.checked==1){seleccionar_todo('myform');}else{deseleccionar_todo('myform');}" /></th>

      <th width="1%" ></th>

      <th width="30%" align="center" >Nombres</th>

      <th width="1%" ></th>

      <th width="30%" align="center" >Apellidos</th>

      <th width="1%" ></th>

      <th width="10%" align="center" >Rudep</th>

      <th width="1%" ></th>

      <th width="16%" align="center"  style=" text-align:center;background-color:#333; color:#FFF; cursor:pointer; font:Tahoma, Geneva, sans-serif; font-size:12px" onclick="JavaScript:cargarFocusReporteChk('lockers/b_reportes/iframe.php?idPer=<?=mysql_result($sqlPeriodo,$i,"id")?>&h=500&url=lockers/b_reportes/prgs/'+document.getElementById('idBoletin').value+'.php?', 'apDivListaValAsp','carga', '');" >Generar</th>

    </tr>
</thead>

  

  

</table>
 <div id="apDivListaValAsp" style="font-size:10px; color:#069"></div>


<?
}
?>






</body>

</html>