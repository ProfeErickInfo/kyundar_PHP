<?PHP
session_start();
$Xrefer = getenv('HTTP_REFERER');  
$idEvent=$_SESSION['idEvent'];
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

	//$sqlClubes=mysqli_query($conexion,"select * from tbx_clubes");
//echo "select t.id, t.idclub, (select c.nombre from tbx_club as c where c.id=t.idclub  ) as nomclub from trn_rel_evento as t where t.idevento=".$idEvent;
  $sqlClubes=mysqli_query($conexion,"select t.id, t.idclub, (select c.nombre from tbx_club as c where c.id=t.idclub  ) as nomclub from trn_rel_evento as t where t.idevento=".$idEvent);

	//echo"consultax: ".$conexion;

	//$CantGr = mysql_num_rows($sqlGrados);

//$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";

?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">






<h5>Seleccionar de una lista</h5>
<select class="form-control me-2" name="clubes" id="clubes" onChange="cargarFocus('modDam/mod_consultas/ejec/lstEscarapelas.php?','apDivListaValAsp','carga','');">
<?php
                echo "<option value='-1'>Seleccione el club</option>";
				echo "<option value='0'>Todos los Clubes</option>";

				

				while ($reg=mysqli_fetch_array($sqlClubes, MYSQLI_NUM)){

					

					echo "<option value=".$reg[1].">".$reg[2]."</option>";

				}

			?>

        </select>
   
        <div id="apDivListaValAsp" >
Este es el Div


 </div>


<?
}
?>






