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

@session_start();
//$sqlGrados=mysqli_query($conexion,"select * from trn25_grados order by id");

	
$Href="JavaScript:cargarFocus('lockers/g_studies/prgs/lista_est.php?opbusca=1&oby=&vbusca='+document.getElementById('Grados').value,'apDivListaValAsp','carga','Grados');";

?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">

<div class="container-fluid" style=" overflow:visible; height: 500px;"><!----------Div contenedor--------->

<div class="row">

<div class="form-group col-md-6">
<div class="input-group">
  <div class="input-group-prepend">
    <span style="cursor: pointer;" class="input-group-text" onclick="cargarB('modDam/mod_registro/ejec/lista-Atletas.php?opbusca=1&oby=&vbusca='+document.getElementById('txtBuscar').value+'&idTipo=1&esta=1','dvLista');" id="">Buscar</span>
  </div>
  <input type="text" required class="form-control" name="txtBuscar" id="txtBuscar" onkeyup="cargarB('modDam/mod_registro/ejec/lista-Atletas.php?opbusca=1&oby=&vbusca='+this.value+'&idTipo=1&esta=1','dvLista');">
  
</div>

</div>
<div class="form-group col-md-6"></div>
</div>



<!-------------------------------------------------------->
<div class="row">
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
<h6>Lista de atletas</h6>
</nav>
</div>
<?php
	$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac,(select g.nombre from trn25_genero g where g.id=a.sexo) AS genero from trn25_socios  a  where  a.id_Club=".$id_usu." order by a.fecha_edit  ";	
     $sqlAth = mysqli_query($conexion, $Query);
	 $CantAth = mysqli_num_rows($sqlAth);
	 ?>
 <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
 <div class="row" style="color: darkslateblue; font-weight: bolder;"><!----------Div #21--------->
  <div class="col-8" align="left">Total Atletas:</div><!----------Abro y Cierro Div #22--------->
  <div class="col-4" align="right"><h6><?php echo $CantAth; ?><h6></div><!----------Abro y Cierro Div #23--------->
  </div><!----------Cierro Div #21--------->
  <br>
  <hr>
<div class="row">
<div class="form-group col-md-12" id="DivListaAtletas" >



<div class="row"><!----------Div #12--------->
<div class="col-12" ><!----------Div #13--------->


 
    
    
   
 <div id="dvLista"  style=" overflow:200px; text-align: left;"> <!----------Div #14--------->

<?
	 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
    $Anac=$fila['fecha_nac'];
    $Annac=date("Y",strtotime($Anac));
    $Genero=$fila['genero'];
    //echo"Genero".$Genero;
    $edad=(strtotime($fec_actual)-strtotime($Anac));
    $edad=(($edad/360)/60/60)/24;
    $edad=(int)$edad;
 
			//	$ImgEdit = "imag/usu_dep.png";
							
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
  $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
  $ImgEdit = "sub_img/uploads/0.png";
}
				
				$ImgEdit2 = "imag/editar.png";
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_dep.php?idDep=".$fila['id']."','modal1dv','carga','txtNombres');";
				$Comenta = "Clic sobre la imagen para acceder a la edicion del Atleta.";
        $Href2 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/editApp.php?docuAsp=".$fila['id']."','modal-fdv','carga','');";
        $HrefImg = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep=".(int)$fila['id']."','".(int)$fila['id']."','carga','');";
        $Href3 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/grados.php?idDep=".$fila['id']."','modal1dv','carga','');";
        $Href4 = "JavaScript:cargarFocus('modDam/mod_registro/scrin/peso.php?idDep=".$fila['id']."','modal1dv','carga','');";
       
  ?>

 <!--------------------CODIGO NUEVO--------------------------------------->


 
    <ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start">
      <div   id="<?=(int)$fila['id'] ?>"  > <img src="<?= $ImgEdit ?>" alt="" width="40" height="50" onclick="<?= $HrefImg ?>"  /></div><!----------Abro y Cierro Div #17--------->
      <div class="ms-2 me-auto"><!----------Div #18--------->
     
        <div class="fw-bold"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div><!----------Abro y Cierro Div #19--------->
        <div class="fw"><?php echo $Genero; ?><?php echo " - ".$Annac; ?></div><!----------Abro y Cierro Div #20--------->
       
      </div><!----------Cierro Div #18--------->
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href ?>" class="badge bg-primary "  data-bs-toggle="modal" data-bs-target="#modal1">Editar</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href2 ?>" class="badge bg-warning "  data-bs-toggle="modal" data-bs-target="#modal-f" >Fotografia</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href3 ?>" class="badge bg-info "  data-bs-toggle="modal" data-bs-target="#modal1" >Actualizar Grados</span>
      <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href4 ?>" class="badge bg-info "  data-bs-toggle="modal" data-bs-target="#modal1" >Actualizar Peso</span>
     
      </li>
    </ol>
   
<!------------------------------------------------------------------>


    <?php 

  

		}

  

  ?>
<br>
<hr class="new1">
    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
	<div class="row" style="color: darkslateblue; font-weight: bolder;"><!----------Div #21--------->
  <div class="col-8" align="left">Total Atletas:</div><!----------Abro y Cierro Div #22--------->
  <div class="col-4" align="right"><?php echo $CantAth; ?></div><!----------Abro y Cierro Div #23--------->
  </div><!----------Cierro Div #21--------->

</div><!----------Cierro Div #14--------->
</div><!----------Cierro Div #13--------->
</div><!----------Cierro Div #12--------->
</div>
<?php
}
?>

