<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER'); 

?>
<!--------------CODIGO HTML---------------->
<!-- Estructura HTML comentada para evitar conflictos con el contenedor principal
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
-->
<!-- Font Awesome 4.7.0 comentado - se usa la versión 6.4.0 del menú principal
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
-->
<!-- Múltiples versiones de jQuery comentadas - se usa la del menú principal
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!----------------------------------------------------------------->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
-->
<!-- Bootstrap ya está cargado en el menú principal - Comentado para evitar conflictos
-->
<!-- Estilos personalizados para el formulario -->
<style>
.registro-form {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 20px !important;
}

.registro-form .row {
    margin-bottom: 15px;
}

.registro-form .form-control,
.registro-form .form-select {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 10px;
}

.registro-form .form-control:focus,
.registro-form .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.registro-form label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 5px;
    display: block;
}

.registro-form h5 {
    color: #1f2937;
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}
</style>
<script src="../../libros/lib25.js"></script>
<script src="../../libros/libValid25.js"></script>
<!--------------------------------------------------->
<!-- Estructura HTML comentada
</head>
-->
<!-----------FIN INICIO HTML--------------->

<?php  
if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <?php
     exit();
} 

include("../../../../enlace/conexion.php");

	if (!$conexion) {		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";
		exit();

	}

  //Consultas de los datos de los select

$url = "https://countriesnow.space/api/v0.1/countries/states";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

foreach ($data['data'] as $pais) {
   // echo "País: {$pais['name']}\n";
    if (!empty($pais['states'])) {
        foreach ($pais['states'] as $estado) {
        //    echo "  - {$estado['name']}\n";
        }
    }
}



foreach ($data['data'] as $pais) {
 //   echo "País: {$pais['name']}\n";
   // 	echo "<option value=".$pais['name'].">".$pais['iso3']."</option>";
    //  echo "INSERT INTO trn25_paises(nombre, codigo_iso3) values ('".$pais['name']."','".$pais['iso3']."')";
    //  $sqlInsLugar=mysqli_query($conexion,"INSERT INTO trn25_paises(nombre, codigo_iso3) values ('".$pais['name']."','".$pais['iso3']."')");
   
}



	$sqlTD=mysqli_query($conexion,"select * from trn25_tipo_documento where tipo=1 order by descripcion");
	$sqlTD2=mysqli_query($conexion,"select * from trn25_tipo_documento order by descripcion");
 	//$sqlGrados=mysqli_query($conexion,"select * from trn25_grados order by id");
	$sqlLugar=mysqli_query($conexion,"select * from trn25_paises order by nombre");
	$sqlSexo=mysqli_query($conexion,"select * from trn25_genero limit 2");
	$sqlSalud=mysqli_query($conexion,"select * from trn25_ssalud");
	$sqlBarrio=mysqli_query($conexion,"select * from trn25_lista_barrios order by nombre");
	$sqlClub=mysqli_query($conexion,"select * from trn25_organizacion order by nombre");
	$sqlClub2=mysqli_query($conexion,"select * from trn25_organizacion where id=".$id_usu." order by nombre");
	$reg2=mysqli_fetch_array($sqlClub2, MYSQLI_NUM);
?>
<!--INICIO FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
<div class="container-fluid registro-form">

<!-- Div para mostrar mensaje de carga -->
<div id="carga" style="display: none; text-align: center; padding: 20px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">
    <i class="fas fa-spinner fa-spin"></i> Procesando registro completo, por favor espere...
</div>

<h5 style="margin-bottom: 20px;">Registro de Socios</h5>
<form id="formRE" name="formRE" method="post" action="Javascript:SendFormSocio('modDam/mod_registro/ejec/SaveSociosFull.php?idusu=<?= $_SESSION['id_usuario'] ?>','formRE',1,'modDam/mod_registro/scrin/reg_socios.php?idusu=<?= $_SESSION['id_usuario'] ?>','carga','DivContenido','nomClub');">
<input type="hidden" name="idusu" value="<?= $_SESSION['id_usuario'] ?>">
<!--FILA DEL CLUB-->
<div class="row">
 <div class="col-md-6"><label>
 Club al cual pertenece y Documento de identidad</label>
      <select autofocus class="form-select" disabled  name="nomClub" id="nomClub"  onKeyPress="return focusNext(this.form,'txtNombres',event);">
                        <?php 						
if($_SESSION['tipo_U']!=1){
						while ($reg=mysqli_fetch_array($sqlClub, MYSQLI_NUM)){
                 		echo "<option value=".$reg[0].">".$reg[4]."</option>";
				}
 }else{
	echo "<option value=".$reg2[0].">".$reg2[4]."</option>";
}
?>
</select>
</div>
<!------------------------>

<div class="col-md-2"><label> Tipo</label>  
<select autofocus class="form-select" name="TipoDocumento" id="TipoDocumento"  onKeyPress="return focusNext(this.form,'txtDocumento',event);" required >
                   <?php 						
					 while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){
				echo "<option value=".$reg[0].">".$reg[3]."</option>";
				}
				?>
                 </select>            
  </div>              
  <div class="col-md-2"><label>Número</label>
   <input type="number" name="txtDocumento" placeholder="Documento" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" required /></div>  
                         <div class="col-md-2">
 <label>
 Genero</label>

                  

                  <select name="Sexo" id="Sexo"  class="form-control" onKeyPress="return focusNext(this.form,'Barrio',event);" required>

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

					?>

                  </select>

                  </div>
<!------------------------->
</div>
 
  <!------------SEGUNDA FILA-------------->  
    <div class="row">
    <div class="col-md-3">
     <label>
	 Nombre (s)</label>
     <input type="text"  name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')" onKeyPress="return focusNext(this.form,'txtApellidos',event);"/>
     
     
   </div>
    
    <div class="col-md-3">     
     
     <label> Apellido (s)</label>
<input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control" onkeydown="return sololetras(event,'txtApellidos')"  onKeyPress="return focusNext(this.form,'TipoDocumento',event);"/>
   </div>
              <div class="col-md-3"><label>  Fecha de Nacimiento</label>       
                
    <input size="12" placeholder="00/00/0000" type="date"   value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac" class="form-control"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'LugarNac',event);" required >           
                
                
         </div>
            
  
          
 <div class="col-md-3">    <label> Lugar de Nacimiento</label> 

<select name="LugarNac" id="LugarNac" class="form-control" onKeyPress="return focusNext(this.form,'Sexo',event);" required>

                    

                    <?php 						
	 while ($lug=mysqli_fetch_array($sqlLugar, MYSQLI_NUM)){

					

					echo "<option value=".$lug[0].">".$lug[1]."</option>";

				}





					?>

                  

                  	</select>
                    </div>        
  
</div>
      <!------------TERCERA FILA-------------->  
      
  <div class="row">              
 
 
                  
                  
                  <div class="col-md-3">


 
                  </div>
         
</div>     
 <!------------TERCERA FILA-------------->   

     
<div class="row">     
  <div class="col-md-3">
          <label>Barrio.</label>
                 <div id="Dvlugar" >
                  <input type="text" name="Barrio" id="Barrio" class="form-control"   onKeyPress="return focusNext(this.form,'txtDireccion',event);" required>

                 
                 </div>

                  </div>

 <div class="col-md-3"><label>Digite la Direcci&oacute;n.</label>
                  <input type="text" name="txtDireccion" placeholder="Dirección" id="txtDireccion" class="form-control" onKeyPress="return focusNext(this.form,'Tpsalud',event);" required />
             
    </div>          
          <div class="col-md-3">     
    <label>Tipo. Serv</label>
    <select name="Tpsalud" id="Tpsalud" class="form-control" onKeyPress="return focusNext(this.form,'txtSalud',event);" required>
                    <?php 						
						while ($reg=mysqli_fetch_array($sqlSalud, MYSQLI_NUM)){
				echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
					?>
                      </select>
 </div>
  <div class="col-md-3">                   
      <label>Serv. de salud</label>
       
                      <input type="text" name="txtSalud" placeholder="Escribe tu EPS " id="txtSalud" class="form-control" onKeyPress="return focusNext(this.form,'txtCelular',event);" required/>
                                   </div>    
            </div>       
      <!--------------CUARTA FILA---------------->
      <div class="row">
<div class="col-md-3">
<div style="font-weight:bolder">Tipo de Socio Registrado</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" value="1"  name="OpSocio" onClick="javascript:nohabilita()" required>
 <label class="form-check-label" for="flexRadioDefault1">Socio Afiliado</label>
 </div>
 <div class="form-check form-check-inline">
        <input type="radio" value="2" class="form-check-input" name="OpSocio" onClick="javascript:habilita()" required>
<label class="form-check-label" for="flexRadioDefault1">Socio Deportista</label>
 </div>
 </div>
 
    
   
    <div class="col-md-3"> 
                    <label>Celular.</label>
                    <input type="text" name="txtCelular" placeholder="Telefono Movil" id="txtCelular" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtEmail',event);" required />
                    </div>
                    
     <div class="col-md-3"> 
                 
                    <label>Email.</label>

                 <input type="text" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar2',event);" required/>
    </div>
    </div>
     <!--------------FILA 4.1---------------->
      <div class="row">
      
    
 


 <div class="col-md-3"  >  
              <label></label>
    <button class="btn btn-success" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="valSocioFull(this.form);" >Registrar</button>
                                
            
           
   
</div>
  
    </div> 
     <!------------QUINTA FILA-------------->        
 
 
  </form>  
<!--FINAL FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
</div>

<!-- Etiqueta HTML comentada para evitar conflictos
</html>
-->

