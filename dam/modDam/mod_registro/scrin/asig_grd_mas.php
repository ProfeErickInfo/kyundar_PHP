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



	//$idDep = $_GET['idDep'];
  //$Back = "JavaScript:cargarFocus('modDam/mod_registro/scrin/consulta_est.php?idDep=".$idDep."','DivContenido','carga','');";

	
$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");
$CantGr = mysqli_num_rows($sqlGrados);
		
$sqlGradosB=mysqli_query($conexion,"select * from tbx_grados order by id");
$CantGr = mysqli_num_rows($sqlGradosB);
		//$Query = "select id, id_deportista, id_info, fecha from tbx_infoxgrado  where id_deportista=".$idDep;

		


	//$sqlDep=mysqli_query($conexion,$Query);

	

//	$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);
//	$CantDep = mysqli_num_rows($sqlDep);
	
//Codigo nuevo traer datos de los atleta;
$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac,(select g.nombre from tbx_genero g where g.id=a.sexo) AS genero from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by a.fecha_edit  ";	
$sqlAth = mysqli_query($conexion, $Query);
$CantAth = mysqli_num_rows($sqlAth);
	

		
?>

<div class="container-fluid">                                                                                                                                                                           
<form id="frmAsigGrd" name="frmAsigGrd" method="post"  action="Javascript:SendListaGrados('modDam/mod_registro/ejec/AsigGradosMas.php?idGrado='+document.getElementById('selGrados').value+'&fec='+document.getElementById('txtFechaNac').value, 'frmAsigGrd','checklist', 'carga',  'modDam/mod_registro/scrin/asig_grd_mas.php', 'DivContenido', '');">      
                                                                             

  <div class="h4"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div>
<h5>Registro de Grados </h5>
  <div class="row">
    <div class="col">
      <select name="selGrados" id="selGrados" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar',event);">
      <?php 
             echo "<option value=0>Seleccione Grado</option>";
          while ($reg=mysqli_fetch_array($sqlGrados, MYSQLI_NUM)){
                echo "<option value=".$reg[0].">".$reg[1]."</option>";
          } ?>

 </select>
    </div>
    <!---------->
    <div class="col">
    <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac"  id="txtFechaNac"  class="form-control">
    </div>
     <!---------->
    <div class="col">
    <input type="button" name="btnRegistrar" id="btnRegistrar" onclick="valLstGrd()" value="Actualizar" class="btn btn-success" /> 
    </div>
     <!---------->
    <div class="col" id="">
   
    <select name="buscaGrds" id="buscaGrds"   class="form-control me-2" onKeyPress="return focusNext(this.form,'btnRegistrar',event);">
      <?php 
             echo "<option value=0>Restaurar Lista</option>";
          while ($regB=mysqli_fetch_array($sqlGradosB, MYSQLI_NUM)){
                echo "<option value=".$regB[0].">".$regB[1]."</option>";
          } ?>

 </select>
       
       
    


   </div>
    <!---------->
    <div class="col"> <button class="btn btn-info" type="button" onclick="cargarB('modDam/mod_registro/ejec/lista-est-grados.php?opbusca=1&oby=&vbusca='+document.getElementById('buscaGrds').value,'dvLista');">Buscar Por Grado</button></div>
  </div>
  <hr>






  <div class="row align-items-center " style="color: darkslateblue; font-weight: bolder;"><!----------Div #21--------->
  
    <div class="col-6 d-flex justify-content-end" >Total Atletas:</div><!----------Abro y Cierro Div #23--------->
    <div class="col-6 d-flex justify-content-start " ><h5> <span class="badge rounded-pill bg-info text-ligth"><?php echo $CantAth; ?></span></h5></div><!----------Abro y Cierro Div #23--------->
  </div><!----------Cierro Div #21--------->

<hr>
<!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
 
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
 //////////////////-----------------Consulta de grados por atleta------------

 $QueryGrd = "select i.id, i.id_deportista, i.id_info, i.fecha,( select g.nombre from tbx_grados as g where g.id=i.id_info) as nGrado from tbx_infoxgrado as i  where i.id_deportista=".$fila['id']." order by i.fecha ASC";
 $sqlGrd=mysqli_query($conexion,$QueryGrd);
 $CantGrd = mysqli_num_rows($sqlGrd);
 //$resultados=mysqli_fetch_array($sqlGrd, MYSQLI_ASSOC);


 //////////////////////////////////////////////////////////////////
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
<!-------------------------------------------->
<div class="input-group">

<div class="input-group-text"  id="<?=(int)$fila['id'] ?>"  >



      <input class="form-check-input" type="checkbox" name="checklist" id="checklist" value="<?=(int)$fila['id'] ?>">   

      <img src="<?= $ImgEdit ?>" alt="" width="40" height="50" onclick="//$HrefImg "  />

</div>




<div class="ms-1 "><!----------Div #18--------->

    <div class="fw-bold"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></div><!----------Abro y Cierro Div #19--------->
    <div class="fw">
                    <!------------------------------------------>
                              
                                <?
                                    $xg=0;
                                    while ($resultados=mysqli_fetch_array($sqlGrd, MYSQLI_ASSOC)){
                                         $xg++;
                                        if ($xg== $CantGrd){
                                ?>

                                     <spam class="fw-bold small" style="font-size: smaller;">   <?  echo  $resultados['nGrado']."    "; ?>   </spam> 
   
                                 <?

                                     }else{
                                 ?>
  
                                      <spam class="ms-2 me-end small text-muted" style="font-size: smaller;">   <?  echo  $resultados['nGrado']."  /  "; ?>   </spam> 
   
                                  <?
                                     }
  
                                    }
                                ?>


                                   <!-------------------------------------------->
                    
                    </div><!----------Abro y Cierro Div #20--------->
</div><!----------Cierro Div #18--------->


</div><!----------Abro y Cierro Div #17--------->
     
<!------------------------------------------->

    <h5>   <span style="margin: 1%; cursor: pointer;" onclick="<?= $Href3 ?>" class="badge bg-info "  data-bs-toggle="modal" data-bs-target="#modal1" >Actualizar Grados</span></h5> 
     
      </li>
    </ol>
   
<!------------------------------------------------------------------>


    <?php 

  

		}

  

  ?>
 
<br>
<hr class="new1">
    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
    <div class="row align-items-center " style="color: darkslateblue; font-weight: bolder;"><!----------Div #21--------->
  
  <div class="col-6 d-flex justify-content-end" >Total Atletas:</div><!----------Abro y Cierro Div #23--------->
  <div class="col-6 d-flex justify-content-start " ><h5> <span class="badge rounded-pill bg-info text-ligth"><?php echo $CantAth; ?></span></h5></div><!----------Abro y Cierro Div #23--------->
</div><!----------Cierro Div #21--------->

</div><!----------Cierro Div #14--------->
</div><!----------Cierro Div #13--------->
</div><!----------Cierro Div #12--------->
</div>
 
  

  
<!------------------------------>
  </div>
  </form>

</div>
    <?php



	
}

