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



	$opbusca = 1;
	$tpc = $_GET['tpc'];
	$dto = $_GET['dto'];
    //$cat = $_GET['cat'];
	
	$orden1 = "nombre";
	
	 
	   
	$OrderBy = $orden1;
//caso 1
if(($tpc=='id_barrio')&&($dto>0)){
	$Query = "select * from tbx_club where ".$tpc."=".$dto." order by ".$OrderBy;
}
//Caso 2
if(($tpc=='nombre')&&($dto!='')){
	$Query = "select * from tbx_club where ".$tpc."  like '%$dto%'  order by ".$OrderBy;
}
//Caso 3
if(($tpc=='documento')&&($dto!='')){
	
	$Query = "select * from tbx_deportistas where ".$tpc."  like '$dto%'  order by ".$tpc;
}
//Caso 4
if(($tpc=='localidad')&&($dto!='')){
	
	$Query = "SELECT * FROM tbx_club as d where d.id_barrio IN(select l.id from tbx_lista_barrios as l where l.".$tpc."=".$dto.")";

}
//caso 5
if(($tpc=='tipo_lugar')&&($dto!='')){
	
	$Query = "select * from tbx_club where ".$tpc."=".$dto." order by ".$OrderBy;
	
	
	
}
/////////////////////////////////////////////////////////

//echo "Consulta: ".$Query;
	$sqlClub=mysqli_query($conexion,$Query);  

	

	@$CantClub = mysqli_num_rows($sqlClub);

	

	

	if($CantClub!=0){

		

?>

<style>

table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  background: #D0E4F5;
  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  border-top: 2px solid #444444;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
 

<div   style="height:30px;  vertical-align:middle; font:'Arial Black', Gadget, sans-serif; color: #000; font-size:16px; font-weight:bolder; padding-left:30px; border-color:#666; ">
 Información de Clubes</div>
  <table class="blueTable" width="100%"  >
    
 <thead>
<tr>
 
  
  <th width="20%">Nombre del Club</th>
  <th width="15%">Barrio</th>
  <th width="20%">Dirección</th>
  <th width="15%">Entrenador</th>
  <th width="5%">Contacto</th>
  <th width="15%">Presidente</th>
  <th width="5%">Contacto</th>
  <th width="10%">Correo Electronico </th>
  
</tr>
  </thead>
  
  <tfoot>
<tr>
<td colspan="8">
<div class="links"><a href="#">&laquo;</a> <a class="active" href="#">1</a> <a href="#">&raquo;</a></div>
</td>
</tr>
</tfoot>
  
<tbody>

    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->


    <?php 

  

  		$c=1;
//$row = mysqli_fetch_assoc($result)
		
 while ($fila=mysqli_fetch_assoc($sqlClub)){
  		//for($i=0;$i<$CantAsp;$i++){

			

							$ImgEdit = "imag/editar.png";

				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_deportista.php?docuAsp=".$fila['id']."','DivContenido','carga','txtNombres');";

				$Comenta = "Clic aqui para acceder a la edici&oacute;n del deportista.";

			


			//}

  if($c==2){

			

				$color=' class="trColor1"';

				

				$c--;

			

			}else{

			

				$color=' class="trColor2"';

				

				$c++;

			

			}
			
if(file_exists($fila['id_club'])){
$ruta1="../../../sub_img/uploads/".$fila['id_club'].'/'.$fila['film'];
}else{
//$ruta1="sub_img/uploads/0.png";
	$ruta1="../../../sub_img/uploads/0.png";
}
  ?>


    <tr class="headerCampo"    >
	
      <td ><?php echo $fila['nombre']; ?></td>
      <td><?php  $sqlBarrio = mysqli_query($conexion, "select * from tbx_lista_barrios where id=".$fila['id_barrio']);
	    $reg_B=mysqli_fetch_array($sqlBarrio, MYSQLI_NUM);
	  
	  echo $reg_B[1]; ?></td>
     <td> <?php echo $fila['direccion']; ?></td>
       <td width="20%"><?php echo $fila['entrenador']; ?> </td>
      
   <td><?php echo $fila['telefono']; ?> </td>   
    <td><?php echo $fila['representante']; ?> </td>
      
      <td><?php echo $fila['cel']; ?> </td>
       <td width="20%"><?php echo $fila['email']; ?></td>
      
   
  
    </tr>
   
    

    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
    
<tr class="headerCampo">
 <td colspan="8">Total Clubes Encontrados:<?php echo $CantClub; ?></td>
 
</tr>

</tbody>  </table>

 
 

  

<?php



	}else{

		

		echo "Datos no coinciden";

	

	}

}

?>
