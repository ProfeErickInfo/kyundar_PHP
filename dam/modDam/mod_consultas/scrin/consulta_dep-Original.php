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

	$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");

	
$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";

?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">






<p class="h5" >Consulta de Atletas Activos</p>

<div class="p-2 flex-fill bd-highlight" style="color:#333">
<!------------PRIMERA FILA-------------->  
 <div class="form-row">
 <!------------COL #1 -------------->  
  <div class="form-group col-md-2">
   
     <select name="Grados" id="Grados" onChange="cargarFocus('modDam/mod_consultas/ejec/lista_est.php?opbusca=1&oby=&vbusca='+this.value,'apDivListaValAsp','carga','Grados');" class="form-control">
      <?php
         echo "<option value='-1'>Seleccione el grado</option>";
		 echo "<option value='0'>Todos los grados</option>";
    		while ($reg=mysqli_fetch_array($sqlGrados, MYSQLI_NUM)){
					echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
			?>
      </select>
    </div>
  <!------------COL #2 -------------->   
  <div class="form-group col-md-4">   
    
    <input type="text" name="txtBuscar" id="txtBuscar" onKeyPress="cargarB('modDam/mod_consultas/ejec/lista_est.php?opbusca=2&oby=&vbusca='+this.value,'apDivListaValAsp');" class="form-control" placeholder="Buscar x Nombre" />
    </div>
  <!------------COL #3 -------------->   
    <div class="form-group col-md-1">   
    
 <img src="imag/busca.png" onclick="cargarB('modDam/mod_consultas/ejec/lista_est.php?opbusca=2&oby=&vbusca='+document.getElementById('txtBuscar').value,'apDivListaValAsp');"  id="btnbusca" style="width:40px; height:40px; cursor:pointer"/>   
    </div>
 <!------------COL #4 -------------->    
 <div class="form-group col-md-4">
 <input type="text" name="txtBuscarDoc" id="txtBuscarDoc" placeholder="Buscar x Documento" onKeyPress="cargarB('modDam/mod_consultas/ejec/lista_est.php?opbusca=3&oby=&vbusca='+this.value,'apDivListaValAsp');" class="form-control" />
 
 </div>
 <!------------COL #5 --------------> 
   
  <div class="form-group col-md-">
 <img src="imag/busca.png"  onclick="cargarB('modDam/mod_consultas/ejec/lista_est.php?opbusca=3&oby=&vbusca='+document.getElementById('txtBuscarDoc').value,'apDivListaValAsp');" id="btnbusca" style="width:40px; height:40px; cursor:pointer"/>
 
 </div>  
 
    
  </div>
   <!------------FIN FILA #1 -------------->   
</div>



<div id="categorias" class="dvCont">
  <div class="table-responsive">
  <table class="table">
  <thead>
    <tr  style="text-align:center">

      <th  >Nombre</th>
      <th   >Apellidos</th>
      <th  >Grado</th>
      <th  >RegUni</th>
      <th  >Acciones</th>

    </tr>
</thead>
</table></div>
</div>
 <div id="apDivListaValAsp" style="font-size:10px; color:#069"></div>


<?php
}
?>

