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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../../../faces/estilo.css">
<title></title>
<style>
.fondo{
	background-color:#ECECEC;
	font-size:12px;
	font-weight:bolder;
	font-family:Tahoma, Geneva, sans-serif;
	color:#000;
	margin:10,10,10,10;
	padding:10,10,10,10;
	
	
	}
</style>


</head>
<?php
$id_estudiante=(int)$_GET['docuAsp'];
//echo "es".$id_estudiante;
if 	($id_estudiante>0){
	$sqlGestu=mysql_query("select * from tbx_deportistas  where id=".$id_estudiante ,$conexion);
	$canE=0;
	$canE=mysql_num_rows($sqlGestu);
	if ($canE!=0){
	//////////////////////////////////////////////////////////////////////
	 @$noms=mysql_result($sqlGestu,0,"nombres");
	  @$apes=mysql_result($sqlGestu,0,"apellidos");
	  @$cel=mysql_result($sqlGestu,0,"celular");
	  @$email=mysql_result($sqlGestu,0,"email");
	  @$pic=mysql_result($sqlGestu,0,"film");
	//echo "foto:".$pic;
	  }
	  }
	  ?>
<!-- <body> comentado para evitar conflictos con el contenedor principal -->

 <div align="left">
        
      <form method='post' name="Cfoto" id="Cfoto" action="modDam/mod_registro/scrin/modifyImagen.php?id_estu=<?=$id_estudiante ?>" target="upload_window" enctype='multipart/form-data' onSubmit="JavaScript:cargarFocus('nucleo/registro/scrin/edit_deportista.php?docuAsp=<?=$id_estudiante ?>','DivContenido','carga','');" >
        
         
		  <table width="100%" border="0">
  <tr>
    <td class="headerForm" align="center" width="5%">1</td>
    <td width="26%" colspan="3"> <input name='im' type='file' id="im" />
          <br ><br></td>
   
    <td width="20%" align="right" valign="top"><input name='limpiar' type='reset' value='Limpiar' /></td>
    <td width="1%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="headerForm">2</td>
    <td> <input name='enviar' type='submit' value='Cargar Imagen' /> </td>
    <td>&nbsp;</td>
    <td align="center" class="headerForm">3</td>
    <td><input name='actua' type='button' value='Actualizar Vista' onClick="JavaScript:cargarFocus('nucleo/registro/scrin/miscript.php?idE=<?=$id_estudiante ?>','preview','carga','');" /></td>
    <td>&nbsp;</td>
    <td align="center" class="headerForm">4</td>
    <td><input name='actua' type='button' value='Actualizar Vista Deportista' onClick="JavaScript:cargarFocus('nucleo/registro/scrin/edit_deportista.php?docuAsp=<?=$id_estudiante ?>','DivContenido','carga','');" /></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>

		 
          
         
          
         
          
        
        
      </form>

<iframe id="upload_window" name="upload_window" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</div>
    

        </td>
        <td width="2%">&nbsp;</td>
<td align="center" width="49%" >
        <div id="preview">
        
<img src="pics/<?=$pic?>"  id="FotoPerfil" style="width:150px; height:200px"/>
</div> 
       <p class="labelNomApe">Recuerde que solo se permiten imagenes en formato jpg, jpeg, gif, bmp y png</p>

</body>
</html>
<?php 

	
	}


?>
