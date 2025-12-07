<?PHP 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
session_start();

$id_usu=(int)@$_SESSION['id_usuario'];
ob_end_clean();

//echo "*".$id_usu;
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



	$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2021;
    $abierto=2021;
		
		
	

		

		

	$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) AS grado, a.documento from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by a.fecha_edit DESC ";
	
	
	

	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

	

	if($CantAth!=0){

		

?>
<style>
.estilo-x { font-size: calc(1em + 1vw) }
</style>


<div class="">    
<h4>Registro Fotografico</h4>
<hr>
<div class="row">
  <div class="col-8 justify-content-start" >
    <b class="estilo-x" style="color:#333">T. Atletas:</b>
    <span class="badge badge-primary badge-pill" style="font-size:large"><?php echo $CantAth; ?></span>
  </div>

   <div class="col-4 justify-content-end" >   
              
    <button class="btn btn-danger" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="javascript:location.reload()" >Regresar</button>

   </div>
</div>

<hr>

<!------------------CODIGOS BUSCAR----------------------->

<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Buscar
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
        
      <nav class="navbar navbar-light bg-light">
        
           <a class="navbar-brand">Escribe parte del nombre</a>
             <form class="d-flex" id="frmBuscar">
	              <input type="text" class="form-control" name="txtBuscar" id="txtBuscar" onkeydown="cargarB('modDam/mod_consultas/ejec/buscaListApp.php?opbusca=1&oby=&vbusca='+this.value,'dvLista');">
             </form>
       
      </nav>
    
    </div>
    </div>
  </div>
  </div>

<!---------------------------------------------------------->





<div  id="dvLista" style="color:#333; height: 400px; overflow: visible;"  >

<ul class="list-group">
 
 



    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		$c=1;

		//echo"ID_CLub".$id_usu;
 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
					//echo "".$fila['nombres']."-".$fila['apellidos']."";
clearstatcache();
				//}
  		//for($i=0;$i<$CantAth;$i++){
//echo "sub_img/uploads/".$id_usu."/".$fila['film'];
			
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
    $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
    $ImgEdit = "sub_img/uploads/0.png";
}
		//	echo $ImgEdit;

				
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/fotoApp.php?docuAsp=".$fila['id']."','modal-fdv','carga','');";
        $HrefImg = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep=".(int)$fila['id']."','".(int)$fila['id']."','carga','');";
       
				$Comenta = "Clic aqui para acceder a la informaci&oacute;n del deportista.";

			

			//}
//$fila = $resultado->fetch_assoc();
//$result=mysqli_query($mysqli,$sql);
  //$resul = $sqlAsp->fetch_assoc();
 
  ?>
  
  

<!--------------------CODIGO NUEVO--------------------------------------->


 
<ol class="list-group ">
      <li class="list-group-item d-flex justify-content-between align-items-start" >
      <div  id="<?=(int)$fila['id'] ?>"  >   <img src="<?= $ImgEdit ?>" alt="" width="40" height="50" onclick="<?= $HrefImg ?>"  /></div><!----------Abro y Cierro Div #17--------->
     
      <div class="ms-2 me-auto" onclick="<?= $Href ?>"  data-bs-toggle="modal" data-bs-target="#modal-f"><!----------Div #18--------->
     
        <div class="fw-bold"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div><!----------Abro y Cierro Div #19--------->
       
      </div><!----------Cierro Div #18--------->
      
      </li>
    </ol>
   
<!------------------------------------------------------------------>
    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
 
</ul>
    
      <div class="form-footer">
            <!-- form footer, let say for submit button -->
            <hr>
            <div class="row">
              <div class="col-8 justify-content-start" >
               <b class="estilo-x" style="color:#333">T. Atletas:</b>
                <span class="badge badge-primary badge-pill" style="font-size:large"><?php echo $CantAth; ?></span>
              </div>

              <div class="col-4 justify-content-end" >   
              
                <button class="btn btn-danger" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="javascript:location.reload()" >Regresar</button>

              </div>
           </div>  
       </div>         
  
</div>
 

<?php



	}else{

		
	?>
		
</div>


	<?

	}
?>
</div>
<?
}

?>
