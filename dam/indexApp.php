<?php
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
@session_start(); 
$id_usu=(int)@$_SESSION['id_usuario'];
ob_end_clean();
header('Cache-Control: no-store, no-cache, must-revalidate'); header('Pragma: no-cache');
//$id_usu=4;
if($id_usu==0){
?> 
<script languaje="JavaScript">
location.href='../index.html';
</script>

<?php
}
    // Se ejecuta el ajax normalmente  
 
?>  
<?php 




	 include("../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
/////////////////////////////////////////////////////
$mifoto=@$_SESSION['img_foto'];
$minombre2=$_SESSION['nombre_usu'];
  $CantMSG=19;
?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="es">
  <head>
    <title>Bestuur</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--------------------------
    Favicons
    ============================================= ----->
    <link rel="icon" href="../images/sj-icono144x144.png" type="image/x-icon">
   
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic%7CLato:300,300italic,400,400italic,700,900%7CMerriweather:700italic">
    
	<link rel="stylesheet" href="../css/fonts.css">
	
    <link rel="stylesheet" href="../css/style.css">
	
    <link rel="stylesheet" href="ccss/font-awesome-4.7/css/font-awesome.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
	
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!----------------------------------------------------------------->
<!---------------Librerias-------------------------------->
<script src='libros/libDam.js' type='text/javascript'></script>
<script src='libros/validDam.js' type='text/javascript'></script>

<script type="text/javascript" src="libros/jquery.js"></script>

<!----Lib Finana----->
<!-------->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!----------------------------------------------------------------->
<link rel="stylesheet" href="ccss/css/main.css" />
		<noscript><link rel="stylesheet" href="ccss/css/noscript.css" /></noscript>
        
         <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/floating-labels/">

   <link href="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
<!-----------------aviso------------------->
<style>

body
{
font-family:arial;
}
.preview
{
width:200px;
border:solid 1px #dedede;
padding:10px;
}
#preview
{
color:#cc0000;
font-size:12px
}
/* Background colors */

.bg-aqua
{
  color: #fff !important;
  cursor: pointer;
}
.bg-aqua,
.callout.callout-info,
.alert-info,
.label-info,
.modal-info .modal-body {
  background-color:#005e88 !important;
}
.bg-aqua-active,
.modal-info .modal-header,
.modal-info .modal-footer {
  background-color: #00a7d0 !important;
}
.text-aqua {
  color:azure !important;
  font-size: small;
}
</style>

 <!---------------foto-------------------->
  <!----------------------------------------------------------------->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

 <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script></body>
 <script src="sub_img/scripts/new/jquery-1.9.0.min.js"></script>
<script src="sub_img/scripts/new/capture.js"></script>
<link href="sub_img/scripts/new/main.css" rel="stylesheet" type="text/css"/>
<script>

function previewFile() {
	
  const preview = document.querySelector(".rounded");
   $("#preview").html('<img src="sub_img/loader.gif" alt="Cargando..."/>');
  const file = document.querySelector("input[type=file]").files[0];
  const reader = new FileReader();

  reader.addEventListener(
    "load",
    () => {
      // convert image file to base64 string
      
      preview.src = reader.result;
    },
    false,
  );

  if (file) {
    reader.readAsDataURL(file);
     // Enviar el formulario de forma asíncrona
     $("#imageform").ajaxForm({
                    target: '#preview'
                }).submit();
  }
  
}


$("#txtBuscar").keypress(function(e) { 
        var code = (e.keyCode ? e.keyCode : e.which); 
        if(code == 13 && $(this).val()!=""){
            alert("detectar");
            $("#txtBuscar").focus().select();
        }
    });

</script>




<!--------------fin foto------------------->
<script> 
function ejecutaEventoOnclick(idUsu){ 

   //alert('si fue'+idUsu);
    if((idUsu==0)){
     location.href='../sesionOut.html';

    }
     
} 
</script>
<!----------------------------------------------------------------->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!--------------------------------------------------->
<script> 
function ejecutaEventoOnclick(idUsu){ 

   //alert('si fue'+idUsu);
    if((idUsu==0)){
     location.href='../sesionOut.html';

    }
     
} 

function validar(e) {
  let tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) alert ('Has pulsado enter');
}
</script>

<!---------------Librerias-------------------------------->
<script src='libros/libDam.js' type='text/javascript'></script>
<script src='libros/validDam.js' type='text/javascript'></script>
<script type="text/javascript" src="libros/js/jquery.js"></script>
<script type="text/javascript" src="libros/jquery.js"></script>
<script type="text/javascript" src="libros/jquery.watermarkinput.js"></script>
<!----Lib Finana----->
<script type="text/javascript" src="libros/libFinan/FunFinan.js"></script>
<!-------->
<script type="text/javascript" src="libros/jfind.js"></script>
<script type="text/javascript" src="libros/jlock.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!----------------------------------------------------------------->
 
<script>
    
    function calcular_pago() {
    //alert('es');
    var nClase = document.getElementById("txtNclase");
    var vPago = document.getElementById("txtVclase");
    var vSaldo = document.getElementById("txtVpago");
   
    vSaldo.value = nClase.value*vPago.value;
    
}

function calcular_pago_parcial() {
    //alert('es');
    var vPago = document.getElementById("txtVpago");
    var vParcial = document.getElementById("txtParcial");
    var vSaldo = document.getElementById("txtSaldo");
    var vPagoN=parseFloat(vPago.value);
    var vParcialN=parseFloat(vParcial.value);
    var vSaldoN=parseFloat(vSaldo.value);
    if(vParcial==0){
      vParcial.value=vPagoN;
    }else{
      vParcial.value=(vParcialN + vPagoN);
    }
    

    vSaldo.value = vSaldoN-vPagoN;
    
}
</script>

<!----------------------fecha------------------------------->


<link rel="stylesheet" type="text/css" href="faces/datedropper.css"> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="libros/datedropper.js"></script>
<script>
$(document).ready(function(){
    $("#from").dateDropper();
});
</script>
<!-----------------------------------HOJAS DE ESTILO-------------------------------->

<link href="ccss/apariencia2.css" rel="stylesheet" type="text/css"/>
<link href="ccss/estilo2.css" rel="stylesheet" type="text/css" />


 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!----------------------------------------------------------------------------------->

  </head>
  <body onclick="ejecutaEventoOnclick(<?php echo $id_usu;?>" >
    
    <div class="page">
      <header class="page-head">
        <div class="rd-navbar-wrap">

          <nav class="rd-navbar rd-navbar-default" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="53px" data-xl-stick-up-offset="53px" data-xxl-stick-up-offset="53px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-inner">
              <div class="rd-navbar-aside-wrap">
                <div class="rd-navbar-aside">
                  <div class="rd-navbar-aside-toggle" data-rd-navbar-toggle=".rd-navbar-aside"><span></span></div>
                   <div class="rd-navbar-aside-content">
                    <ul class="rd-navbar-aside-group list-units">
					            	<li><a class="dropdown-item" onClick="cargarFocus('modDam/mod_registro/scrin/m_invitado.php?idClub=<?=$id_usu?>','DivContenido','carga','txtNomclub');">Mi Club</a></li>
     					          <li><hr class="dropdown-divider"></li>
      			        		<li><a class="dropdown-item" onClick="if(confirm('Deseas cerrar la sesión actual?')){window.location='cerrarsesion.php';}"  >Salir</a></li>
   
                    </ul>
                    
                   </div>
                </div>
              </div>
              <div class="rd-navbar-group">
                <div class="rd-navbar-panel">
                  <button   class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button><a class="rd-navbar-brand brand" onclick="location.reload();" ><img src="../biblio10/images/SIKER2.png" alt="" width="143" height="27"/></a>
                </div>
                <!--------------------------------------->
			  	    <div class="rd-navbar-nav-wrap">
                  <div class="rd-navbar-nav-inner " style="padding-left: 5%; padding-top: 5%;">
                     <div class="rd-navbar-btn-wrap">
					            	<a type="button" class="btn btn-info" onClick="cargarFocus('modDam/mod_registro/scrin/r_socio_corto.php','DivContenido','carga','');">Registro Rapido</a>
					           </div>
			            		<ul class="rd-navbar-nav fa-ul" style="padding-left: 15px;">
 				              	 <li   class="dropdown-item " onClick="cargarFocus('modDam/mod_registro/scrin/reg_socios.php','DivContenido','carga','TipoDocumento');"><i class="fa-li fa fa-address-card fa-2x pull-left"></i>REGISTRAR SOCIOS</li>
 				              	 <li><hr class="dropdown-divider-ligth"></li>
                         <li class="dropdown-item"  onClick="cargarFocus('modDam/mod_consultas/scrin/LestApp.php','DivContenido','carga','');"><i class="fa-li  fa fa-camera-retro fa-2x pull-left"></i>SUBIR FOTO</li>
                         <li><hr class="dropdown-divider-ligth"></li>
                         <li class="dropdown-item"  onClick="cargarFocus('modDam/mod_consultas/scrin/ListApp.php','DivContenido','carga','');"><i class="fa-li fa fa-book fa-2x pull-left"></i>REGISTRAR PAGOS</li>
                         <li><hr class="dropdown-divider-ligth"></li>
                         <li class="dropdown-item" ><i class="fa-li fa fa-barcode fa-2x pull-left"></i>VENDER PRODUCTO</li>
            					</ul>
              
              					<a class="btn btn-lg btn-success" >
  						            <i class="fa fa-flag fa-2x pull-left"></i> BESTUUR<br>Version 2.3.0
                        </a>

                  </div>
				        </div>
				<!---------------------------------------->
              
              </div>
             </div>
          </nav>
        </div>
      </header>
	 
 
	<div  class="container"  id="DivContenido" style="  width:100%; margin-top: 10px; vertical-align: bottom; margin-bottom:10%; overflow: auto;  " >
   <?PHP include('fondo.html'); ?> 
  </div>


	 
	 


<div id="carga"></div>
<div class="btn-toolbar fixed-bottom card-footer text-muted d-flex justify-content-center " role="toolbar"  style="position: fixed; justify-content: center; bottom: 0vw; background-color:#F5F6FB; font-weight: bold; width:100%; height:20vw;    color:black ">
  
 <h5><? echo $minombre2;?></h5> 
</div>

   

    </div>
    <div class="snackbars" id="form-output-global"></div>
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
  </body>
</html>

<!-- Ventana Modal para ver Procesar el TYA -->
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal1dv">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
       
      </div>
    </div>
  </div>
</div>
 
<!-- Ventana Modal para ver Procesar Foto-->
<div class="modal fade" id="modal-f" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-fdv">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
       
      </div>
    </div>
  </div>
</div>
 