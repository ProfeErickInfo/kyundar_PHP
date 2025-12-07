<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
	}else{
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
    ////////////////////////////del edit////////////////////////////


 $nMeses=["Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
 /////////////CONSULTAS/////////////////////
 $Query = "select * from tcx_config where id_club=".$id_usu;
 $sqlInfo = mysqli_query($conexion, $Query);
 $fila=mysqli_fetch_array($sqlInfo, MYSQLI_ASSOC);
 $Cant = mysqli_num_rows($sqlInfo);

if($Cant!=0){   
    $Vmes=$fila['valmes'];
    $Vclase=$fila['valclase'];
    $Mdias=$fila['maxdias'];
    $Vextra=$fila['valmas'];
    $idClub=$fila['id_club'];
    
}
	
    ?>
<i>Configurar aportes mensuales</i>
<p></p>

<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <b> Configuración de Aportes Mensuales</b>
      </button>
      </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
<!-------------CONTENIDO DEL AREA 1---------------------->


<form id="frmMes" name="frmMes" method="post" action="Javascript:enviarFormulario('modDam/modFinan/ejec/Mconfig.php?idClub=<?=$idClub?>','frmMes',1,'modDam/modFinan/scrin/configMes.php?idClub=<?=$idClub?>','carga','DivContenido','');">
   
  <fieldset>
    <legend></legend>
    <i>Escriba las cifras sin puntos o comas.</i>
    <p></p>
    <div class="row">
    <div class="col-sm-3">
      <label for="valmes" class="form-label">Valor Mensual</label>
      <input  type="number"    value="<?= $Vmes ?>"  id="valmes" name="valmes" class="form-control text-end" placeholder="" required="required">
    </div>
    <div class="col-sm-3">
      <label for="valclase" class="form-label">Valor Clase</label>
      <input type="number" id="valclase" name="valclase" class="form-control text-end" value="<?= $Vclase ?>"  placeholder="" required="required">
    </div>
    <div class="col-sm-3">
      <label for="maximo" class="form-label">Maximo de Días</label>
      <input type="number" id="maximo" name="maximo" class="form-control text-end" value="<?= $Mdias ?>" placeholder="" required="required">
    </div>
    <div class="col-sm-3">
      <label for="valextra" class="form-label">Valor Extra</label>
      <input type="number" id="valextra" name="valextra"  class="form-control text-end" value="<?= $Vextra ?>" placeholder="" required="required">
    </div>
    </div>
    <br>
    <button type="button" name="btnSend" id="btnSend" onclick="val_Cmes(frmMes)" class="btn btn-success">Acualizar</button>
    </fieldset>
    
    </form>
<!------------------FIN CONTENIDO AREA 1----------------------->


        </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <b>Descuento a Socios</b>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">


    <!-------------CONTENIDO DEL AREA 2---------------------->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand">Lista de Socios</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-success" aria-current="page" href="#"  onclick="cargarB('modDam/modFinan/ejec/lista-Socios.php?opbusca=2&oby=&vbusca','dvLista');">Mostrar Descuentos Aplicados</a>
        </li>
      </ul>
    </div>
    <form class="d-flex">
      <input type="search" placeholder="Escribe el nombre..." aria-label="Search" class="form-control me-2" name="txtBuscar" id="txtBuscar" onkeyup="cargarB('modDam/modFinan/ejec/lista-Socios.php?opbusca=1&oby=&vbusca='+this.value+'&idTipo=1&esta=1','dvLista');">
      <button style="cursor: pointer;" class="btn btn-outline-success" type="button" onclick="cargarB('modDam/modFinan/ejec/lista-Socios.php?opbusca=1&oby=&vbusca='+document.getElementById('txtBuscar').value+'&idTipo=1&esta=1','dvLista');">Buscar</button>
      
    </form>
  </div>
</nav>










<form id="frmDto" name="frmDto">
   
  <fieldset>
  <i>Escriba las cifras sin puntos o comas.</i>
    <p></p>
<!----------------------------------------------------------------------------------------->








<!-------------------------------------------------------->

<div class="row">
<div class="form-group col-md-12" id="DvListaDcto" >



<div class="row"><!----------Div #12--------->
<div class="col-12" ><!----------Div #13--------->


 
    
    
    <?php
  
	$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac,(select g.nombre from trn25_genero g where g.id=a.sexo) AS genero from trn25_socios  a  where  a.id_Club=".$id_usu." order by a.id limit 3 ";	
     $sqlAth = mysqli_query($conexion, $Query);
	 $CantAth = mysqli_num_rows($sqlAth);
	 ?>
 <div id="dvLista"  style=" overflow:200px; text-align: left;"> <!----------Div #14--------->

<?
	 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
    $Anac=$fila['fecha_nac'];
    $Annac=date("Y",strtotime($Anac));
    $Genero=$fila['genero'];
    clearstatcache();
    //}
//for($i=0;$i<$CantAth;$i++){
//echo "sub_img/uploads/".$id_usu."/".$fila['film'];

if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
$ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
    $ImgEdit = "imag/usu_dep.png";
}
    $edad=(strtotime($fec_actual)-strtotime($Anac));
    $edad=(($edad/360)/60/60)/24;
    $edad=(int)$edad;
 
				//$ImgEdit = "imag/usu_dep.png";
				
				
				$ImgEdit2 = "imag/editar.png";
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_dep_invitado.php?idDep=".$fila['id']."','DivContenido','carga','txtNombres');";
				$Comenta = "Clic sobre la imagen para acceder a la edicion del Atleta.";

  ?>

 <!--------------------CODIGO NUEVO--------------------------------------->


   
<!------------------------------------------------------------------>


    <?php 

  

		}

  

  ?>

</div><!----------Cierro Div #14--------->
</div><!----------Cierro Div #13--------->
</div><!----------Cierro Div #12--------->
<br>

</div>
 <!----------Cierro Div #15------Div de codigo nuevo--->




   
  </fieldset>
</form>
  
</div>
<!-------------------------------------------------------->    
      
    
    
</div>
    </div>
  </div>
</div>
<?

    }
    ?>
    