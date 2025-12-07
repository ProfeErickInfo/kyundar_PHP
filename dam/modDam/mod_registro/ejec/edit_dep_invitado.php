<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idEvent=$_SESSION['idEvent'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
	}else{
    // Se ejecuta el ajax normalmente  
 
?>  

<?php 

	include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


//connexion 

		$idDep = (int)@$_GET['idDep'] or exit("El documento no se ha definido, consulte con el administrador del sistema.");
		
		
	$sqlV=mysqli_query($conexion,"select * from trn_regdep_evento  where id_dep=".$idDep." and id_evento=".$idEvent);

	$CantV = mysqli_num_rows($sqlV);
	
////////////////////////////////////////////////
$sqlDep = mysqli_query($conexion,"select id, nombres, film, apellidos, tipo_doc, documento, fecha_nac, lugar_nac, sexo, barrio, direccion, nombreEps, celular, email, servsalud, cod_int  from tbx_deportistas a where id=".$idDep);
$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);

 @$pic=$resultados["film"];
 

////////////////////////////////////////////////

	$sqlTD=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");
	$Ldoc=mysqli_fetch_array($sqlTD, MYSQLI_ASSOC);
    $CantD = mysqli_num_rows($sqlTD);

	$sqlSexo=mysqli_query($conexion,"select * from tbx_genero limit 2");
	
	//$sqlSalud=mysqli_query($conexion,"select * from tbx_ssalud");

	$sqlgen= mysqli_query($conexion,"select id, nombre from tbx_genero where id=".$resultados['sexo']);
$resG=mysqli_fetch_array($sqlgen, MYSQLI_ASSOC);


	

		//VERIFICO EL METODO DE ASIGNACION DE ID_ALUMNO [AUTO] [MANUAL]

		//$sqlConfig = mysqli_query($conexion,"select auto_id_alumno from tbx_config_valores");

		


?>


<!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

		</head>
		<body>
		<script>
function permite(elEvento, permitidos) {
  // Variables que definen los caracteres permitidos
  var numeros = "0123456789";
  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
  var numeros_caracteres = numeros + caracteres;
  var teclas_especiales = [8, 37, 39, 46];
  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha


  // Seleccionar los caracteres a partir del parámetro de la función
  switch(permitidos) {
    case 'num':
		alert('sue');
      permitidos = numeros;
      break;
    case 'car':
      permitidos = caracteres;
      break;
    case 'num_car':
      permitidos = numeros_caracteres;
      break;
  }

  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);

  // Comprobar si la tecla pulsada es alguna de las teclas especiales
  // (teclas de borrado y flechas horizontales)
  var tecla_especial = false;
  for(var i in teclas_especiales) {
    if(codigoCaracter == teclas_especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
</script>

    <!--INICIO FORM DEL REGISTRO DE FORMULARIO ASPIRANTES -->
	<div class="container" style="margin-bottom: 10%;">
   
   <div class="row">
   <div class="col-12" > 
    <h2>Editando información.</h2>
   </div> </div>

<form id="formRE" name="formRE" method="post"  action="Javascript:enviarFormulario('modDam/mod_registro/ejec/mAtleta.php?idDep=<?= $idDep ?>','formRE',1,'modDam/mod_registro/scrin/edit_dep_invitado.php?idDep=<?= $idDep ?>','carga','DivContenido','txtNombres');">      
 
<div class="row">

<div class="form-group col-md-3"><label>Tipo de Documento</label>

<select name="TipoDocumento" required id="TipoDocumento" class="form-control" onKeyPress="return focusNext(this.form,'txtDocumento',event);">

                  	

                    <?php 

$sqlTDA = mysqli_query($conexion,"select id, descripcion from tbx_tipo_documento where id=".$resultados['tipo_doc']);
$resT=mysqli_fetch_array($sqlTDA, MYSQLI_ASSOC);
					?>

                    

                  	<option value="<?=$resT['id']?>"><?=$resT['descripcion']?></option>

                    

                    <?php 						
 while ($Ldoc=mysqli_fetch_array($sqlTD, MYSQLI_ASSOC)){
							//for($i=0;$i<$CantD;$i++){					

					?>

                    			<option value="<?=$Ldoc['id']?>"><?=$Ldoc['descripcion']?></option>

                    <?php 

							}

					?>

                  </select>        
                  
                     </div>



<div class="form-group col-md-6"><label>Nº de Documento</label>
<input type="number" required name="txtDocumento" placeholder="Documentos" id="txtDocumento" value="<?=$resultados["documento"];?>" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtNombres',event);" />
</div>  
<!--------------------------------------------->
<?
if($CantV==0){
?>
<div class="form-group col-md-3"><label>Genero</label>
<select    name="Sexo" required  id="Sexo" class="form-control" onkeypress="return focusNext(this.form,'btnRegistrar2',event);">
 
                <?php		

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_ASSOC)){

					if($resG['id']==$reg['id']){

					echo "<option selected='selected' value=".$reg['id'].">".$reg['nombre']."</option>";
					
					}else{
						
					echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";
					}

				}

					?>
</select>
</div>


<?php
}else{
?>



<div class="form-group col-md-3"><label>Genero</label>

<select    name="Sexo" required disabled="disabled"   id="Sexo" class="form-control" onkeypress="return focusNext(this.form,'btnRegistrar2',event);">
 
                <?php		

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_ASSOC)){

					if($resG['id']==$reg['id']){

					echo "<option selected='selected' value=".$reg['id'].">".$reg['nombre']."</option>";
					
					}else{
						
					echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";
					}

				}

					?>
</select>
</div>

<?php	
}
?>

<!--------------------------------------------->

</div>
<div class="row">
<div class="form-group col-md-3"><label>Nombres de Deportista</label>

<input class="form-control" required type="text" regexp="[a-z|A-Z]+" aria-describedby="sizing-addon1" value="<?=($resultados["nombres"]);?>" name="txtNombres" id="txtNombres" placeholder="Nombres" onkeydown="return sololetras(event,'txtNombres')"  onKeyPress="return focusNext(this.form,'txtApellidos',event);"/>
</div>

<div class="form-group col-md-3"><label>Apellidos del Deportista</label>
<input class="form-control" required value="<?=($resultados["apellidos"]);?>" type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" regexp="[a-z|A-Z]+" aria-describedby="sizing-addon1" onkeydown="return sololetras(event,'txtApellidos')" onKeyPress="return focusNext(this.form,'txtFechaNac',event);"/>
</div>
<?php 

if($CantV==0){
?>
<div class="form-group col-md-3"><label>Fecha de Nacimiento...</label>
<input  size="12" type="date" required class="form-control"  value="<? echo $resultados['fecha_nac'];?>"     name="txtFechaNac"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'Sexo',event);" >
</div>


<?php
}else{
?>
<div class="form-group col-md-3"><label>Fecha de Nacimiento</label>
<input  size="12" type="date" required class="form-control" disabled="disabled"  value="<? echo $resultados['fecha_nac'];?>"     name="txtFechaNac"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'Sexo',event);" >
</div>




<?php	
}
?>

<hr>
<div class="row">
<div class="form-group col-12 text-justify"><label></label>
<p>Si el atleta se encuentra asignado a un torneo o categoria, se mantendran desactivados el genero y fecha de nacimiento.</p>
</div>
</div>
<?
}
?>

<hr>
     <!------------ULTIMA FILA- (BOTONES)------------->    
     
     <div class="row  alert alert-secondary justify-content-end" id="dvBotones" >

      <div class="col-auto"  style="align-content: end;"> <label></label>
        <div id="carga" style="visibility:hidden; position:relative; ">
           <img style="vertical-align:middle" src="imag/loadw.gif" alt="" width="40" height="40" />
        </div>
      </div>
     
	
      <div class="col-auto"  style="align-content: end;"> <button class="btn btn-success" type="button" name="btnRegistrar" value="Actualizar" id="btnRegistrar"  onClick="valRegApp(this.form);"  >Actualizar</button>
      </div>
	  
      <div class="col-auto"  style="align-content: end;" ><button class="btn btn-info" type="button" name="btnCancelar" value="Cancelar" id="btnCancelar"  onclick="JavaScript:cargarFocus('modDam/mod_registro/scrin/Rdep.php','DivContenido','carga','');">Cancelar</button>
      </div>                                                                                                                                                                 
    
      <div class="col-auto"  style="align-content: end;" ><button class="btn btn-danger" type="button" name="btndarBaja" value="Baja" id="btndarBaja"  onclick="JavaScript:cargarFocus('modDam/mod_registro/ejec/bajar.php?idAtleta=<?= $idDep ?>','dvBotones','carga','');">Dar de Baja</button>
      </div>
    
    </div>






</form>
	</div>
		</body>
</html>

