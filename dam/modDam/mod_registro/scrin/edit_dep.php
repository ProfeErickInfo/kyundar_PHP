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
		
		
//	$sqlV=mysqli_query($conexion,"select * from trn_regdep_evento  where id_dep=".$idDep." and id_evento=".$idEvent);

//	$CantV = mysqli_num_rows($sqlV);
	
////////////////////////////////////////////////
//echo "select d.id, d.nombres, d.film, d.apellidos, (select t.descripcion from tbx_tipo_documento t where d.tipo_doc=t.id) as tipoDoc, d.documento, d.fecha_nac, d.lugar_nac, (SELECT g.nombre FROM tbx_genero as g WHERE d.sexo=g.id) genero, d.barrio, d.direccion, d.nombreEps, d.celular, d.email, (SELECT s.nombre FROM tbx_genero as s WHERE d.servsalud=s.id) serviSalud, d.cod_int  from tbx_deportistas a where id=".$idDep;
$sqlDep = mysqli_query($conexion,"select d.id, d.docRes, d.tipoDoc, d.responsable, d.celular, d.email, d.nombres, d.film, d.apellidos, d.tipo_doc, d.tipo_lugar, d.tipo_socio, d.servsalud,  d.sexo,(select t.descripcion from tbx_tipo_documento t where d.tipo_doc=t.id) as tipoDocu, d.documento, d.fecha_nac, d.lugar_nac, (SELECT g.nombre FROM tbx_genero as g WHERE d.sexo=g.id) genero, d.barrio, d.direccion, d.nombreEps,  (SELECT s.nombre FROM tbx_ssalud as s WHERE d.servsalud=s.id) serviSalud, d.cod_int  from tbx_deportistas d where d.id=".$idDep);
$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);
$resultados["documento"];
$resultados["tipoDocu"];
$resultados["nombres"];
$resultados["apellidos"];
$resultados["fecha_nac"];
$resultados["lugar_nac"];
$resultados["genero"];
$resultados["barrio"];
$resultados["direccion"];
$resultados["nombreEps"];
$resultados["tipo_lugar"];
$resultados["tipo_socio"];
///**************************** -->
$resultados["docRes"];
$resultados["tipoDoc"];
$resultados["responsable"];
$resultados["docRes"];
$resultados["celular"];
$resultados["email"];

 @$pic=$resultados["film"];
 

////////////////////////////////////////////////

$sqlTD=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");
$sqlTD2=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");

$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");

$sqlLugar=mysqli_query($conexion,"select * from tbx_municipios order by nombre");

$sqlSexo=mysqli_query($conexion,"select * from tbx_genero where id<3");

$sqlSalud=mysqli_query($conexion,"select * from tbx_ssalud");

$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");
//echo "id:".$id_usu;
$sqlClub=mysqli_query($conexion,"select * from tbx_club order by nombre");

$sqlClub2=mysqli_query($conexion,"select * from tbx_club where id=".$id_usu." order by nombre");
$reg2=mysqli_fetch_array($sqlClub2, MYSQLI_NUM);

		//VERIFICO EL METODO DE ASIGNACION DE ID_ALUMNO [AUTO] [MANUAL]

		//$sqlConfig = mysqli_query($conexion,"select auto_id_alumno from tbx_config_valores");

		


?>


<!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<!-- Bootstrap ya est� cargado en el men� principal - Comentado para evitar conflictos
-->

		</head>
		<!-- <body> comentado para evitar conflictos con el contenedor principal -->
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
	<div class="container" style="margin-bottom: 10%;overflow:visible; height: 500px;">
  <form id="formME" name="formME" method="POST"  action="Javascript:SendFormSocio('modDam/mod_registro/ejec/m_deportistas.php?idDep=<?= $idDep?>','formME',1,'modDam/mod_registro/scrin/edit_dep.php?idDep=<?= $idDep?>','carga','modal1dv','');" >  
  
   <div class="row">
   <div class="col-12" > 
    <h2>Editando información de socios.</h2>
   </div>
  <!--------------------------------------------------->
<!--FILA DEL CLUB-->
<div class="form-row">
 <div class="form-group col-md-4"><label>
 Club al cual pertenece:</label>
      <select autofocus class="custom-select mr-sm-2"  name="nomClub" id="nomClub"  onKeyPress="return focusNext(this.form,'txtNombres',event);">
                        <?php 						
if($_SESSION['tipo_U']!=1){
						while ($reg=mysqli_fetch_array($sqlClub, MYSQLI_NUM)){
                 		echo "<option value=".$reg[0].">".$reg[1]."</option>";
				}
 }else{
	echo "<option value=".$reg2[0].">".$reg2[1]."</option>";
}
?>
</select>
</div>
</div>
 

  <!------------SEGUNDA FILA-------------->  
    <div class="form-row">
              
  <div class="form-group col-md-3"><label> Tipo de Documento</label>  <select class="custom-select mr-sm-2" name="TipoDocumento" id="TipoDocumento"  onKeyPress="return focusNext(this.form,'txtDocumento',event);" required >
                   <?php 				
                   
					 while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){
           
            if($resultados["tipo_doc"]==$reg[0]){

              echo "<option  value=".$reg[0]." selected >".$reg[1]."</option>";
            }else{
              echo "<option  value=".$reg[0].">".$reg[1]."</option>";
            }
				
				}
				?>
                 </select>            
  </div>              
  <div class="form-group col-md-3"><label>Documento</label>
   <input type="number" name="txtDocumento" placeholder="Documento" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" value="<?=$resultados["documento"]?>" required /></div>  
        <div class="form-group col-md-3">
     <label>
	 Nombre (s)</label>
     <input type="text" autofocus name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')" onKeyPress="return focusNext(this.form,'txtApellidos',event);" value="<?=$resultados["nombres"];?>"/>
     
     
   </div>
    
    <div class="form-group col-md-3">     
     
     <label> Apellido (s)</label>
<input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control" onkeydown="return sololetras(event,'txtApellidos')"  onKeyPress="return focusNext(this.form,'TipoDocumento',event);" value="<?=$resultados["apellidos"];?>"/>
   </div>
</div>
      <!------------TERCERA FILA-------------->  
      
  <div class="form-row">              
          <div class="form-group col-md-3"><label>  Fecha de Nacimiento</label>       
                
    <input size="12" placeholder="00/00/0000" type="date"   value="<?=$resultados["fecha_nac"];?>"    name="txtFechaNac" class="form-control"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'LugarNac',event);" required >           
                
                
         </div>
            


       
          
 <div class="form-group col-md-3">    <label> Lugar de Nacimiento</label> 

<select name="LugarNac" id="LugarNac" class="form-control" onKeyPress="return focusNext(this.form,'Sexo',event);" required>

                    

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlLugar)){

             if($resultados["lugar_nac"]==$reg['id']){

              echo "<option  value=".$reg['id']." selected >".$reg['nombre']."</option>";
              }else{

              }

				      	echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";

			    	}

					?>

                  

                  	</select>
                    </div>
                    <div class="form-group col-md-3">
 <label>
 Genero</label>

                  

                  <select name="Sexo" id="Sexo"  class="form-control" onKeyPress="return focusNext(this.form,'Barrio',event);" required>

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){

					  if($resultados["sexo"]==$reg[0]){

              echo "<option  value=".$reg[0]." selected >".$reg[1]."</option>";
            }else{

              echo "<option value=".$reg[0].">".$reg[1]."</option>";
            }
					

				}

					?>

                  </select>

                  </div>
                  
                  
                  <div class="form-group col-md-3">
<?
if($resultados["tipo_lugar"]==1){
    $estado1="checked";
    $estado2="";

}else{
  $estado1="";
  $estado2="checked";
}
if($resultados["tipo_socio"]==1){
  $estadoS1="checked";
  $estadoS2="";

}else{
$estadoS1="";
$estadoS2="checked";
}

?>
<div style="font-weight:bolder">Lugar de residencia</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" value="1" <?echo $estado1;?>  name="OpLugar" onClick="cargarFocus('modDam/mod_registro/scrin/PhpLugar.php?tipo='+this.value,'Dvlugar','carga','Barrio');" required>
 <label class="form-check-label" for="flexRadioDefault1">Municipal</label>
 </div>
 
 <div class="form-check form-check-inline">
        <input type="radio" value="2" class="form-check-input" <?echo $estado2;?> name="OpLugar" onClick="cargarFocus('modDam/mod_registro/scrin/PhpLugar.php?tipo='+this.value,'Dvlugar','carga','Barrio');" required>
<label class="form-check-label" for="flexRadioDefault1">Distrital</label>
 </div>
 
 </div>
         
</div>     
 <!------------TERCERA FILA-------------->   

     
<div class="form-row">     
  <div class="form-group col-md-3">
          <label>Barrio.</label>
                 <div id="Dvlugar" >
                  <select name="Barrio" id="Barrio" class="form-control"  disabled onKeyPress="return focusNext(this.form,'txtDireccion',event);" required>
                 <?
                  while ($reg=mysqli_fetch_array($sqlBarrio, MYSQLI_NUM)){
           
           if($resultados["barrio"]==$reg[0]){

             echo "<option  value=".$reg[0]." selected >".$reg[1]."</option>";
           }else{
             echo "<option  value=".$reg[0].">".$reg[1]."</option>";
           }
       
       }
                 ?>
                  </select></div>

                  </div>

 <div class="form-group col-md-3"><label>Digite la Direcci&oacute;n.</label>
                  <input type="text" name="txtDireccion" placeholder="Dirección" id="txtDireccion" class="form-control" onKeyPress="return focusNext(this.form,'Tpsalud',event);" required value="<?=$resultados["direccion"];?>" />
             
    </div>          
          <div class="form-group col-md-3">     
    <label>Tipo. Serv</label>
    <select name="Tpsalud" id="Tpsalud" class="form-control" onKeyPress="return focusNext(this.form,'txtSalud',event);" required>
                    <?php 					
                  
						while ($regSalud=mysqli_fetch_array($sqlSalud, MYSQLI_NUM)){
              if($resultados["servsalud"]==$regSalud[0]){

                echo "<option  value=".$regSalud[0]." selected >".$regSalud[1]."</option>";
              }else{
                echo "<option  value=".$regSalud[0].">".$regSalud[1]."</option>";
              }
				}
					?>
                      </select>
 </div>
  <div class="form-group col-md-3">                   
      <label>Serv. de salud</label>
       
                      <input type="text" name="txtSalud" placeholder="Escribe tu EPS " id="txtSalud" class="form-control" onKeyPress="return focusNext(this.form,'txtCelular',event);" required value="<?=$resultados["nombreEps"];?>"/>
                                   </div>    
            </div>       
      <!--------------CUARTA FILA---------------->
      <div class="form-row">
<div class="form-group col-md-3">
<div style="font-weight:bolder">Tipo de Socio Registrado</div>
<div class="form-check form-check-inline">
 <input class="form-check-input" type="radio" value="1" <?echo $estadoS1;?>   name="OpSocio" onClick="javascript:nohabilita()" required><label class="form-check-label" for="flexRadioDefault1">Adulto</label>
 </div>
 <div class="form-check form-check-inline">
        <input type="radio" value="2" class="form-check-input" <?echo $estadoS2;?>  name="OpSocio" onClick="javascript:habilita()" required>
<label class="form-check-label" for="flexRadioDefault1">Menor</label>
 </div>
 </div>
 
     <div class="form-group col-md-9"></div>  
    </div>
     <!--------------FILA 4.1---------------->
      <div class="form-row">
      
      <div class="form-group col-md-3">
 <label>Acudiente</label>
                  <input type="text" disabled name="txtAcudiente" placeholder="Nombre Completo" id="txtAcudiente" class="form-control" onKeyPress="return focusNext(this.form,'TipoDocumento2',event);" required  value="<?=$resultados["responsable"]?>"/>
 
    </div>
   





    
    <div class="form-group col-md-2"><label>Tipo de Documento</label>
    <select class="custom-select mr-sm-2" name="TipoDocumento2" disabled id="TipoDocumento2"  onKeyPress="return focusNext(this.form,'txtDocumento2',event);" required >
             <?php 				
                   
                   while ($regDoc=mysqli_fetch_array($sqlTD2, MYSQLI_NUM)){
                   
                    if($resultados["tipoDoc"]==$regDoc[0]){
        
                      echo "<option  value=".$regDoc[0]." selected >".$regDoc[1]."</option>";
                    }else{
                      echo "<option  value=".$regDoc[0].">".$regDoc[1]."</option>";
                    }
                
                }
                ?>
                 </select> 
                 </div>
                 
                 
                 <div class="form-group col-md-2"><label>Documento</label> 
   <input type="number" disabled name="txtDocumento2" placeholder="Documento" id="txtDocumento2" class="form-control" onKeyPress="return focusNextNum(this.form,'txtCelular',event);" required  value="<?=  $resultados["docRes"];?>"/></div>  
   
   
   
    <div class="form-group col-md-2"> 
                    <label>Celular.</label>
                    <input type="text" name="txtCelular" placeholder="Telefono Movil" id="txtCelular" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtEmail',event);" required  value="<?=$resultados["celular"];?>"/>
                    </div>
                    
                    
                    
             
                    
     <div class="form-group col-md-3"> 
                 
                    <label>Email.</label>

                 <input type="text" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar2',event);" required value="<?=$resultados["email"];?>"/></div>
  
                  </div> 
    



<!------------------------------------------------------->
<hr>
     <!------------ULTIMA FILA- (BOTONES)------------->    
     
   

      <div class="col-auto"  style="align-content: end;"> <label></label>
        <div id="carga" style="visibility:hidden; position:relative; ">
           <img style="vertical-align:middle" src="imag/loadw.gif" alt="" width="40" height="40" />
        </div>
      </div>
     
	
      <div class="col-auto"  style="align-content: end;"> <button class="btn btn-success" type="button" name="btnRegistrar" value="Actualizar" id="btnRegistrar"  onClick="valid_athlet_m(this.form);"   >Actualizar</button>
      </div>
	  
                                                                                                                                                                    
    
      <div class="col-auto"  style="align-content: end;" ><button class="btn btn-danger" type="button" name="btndarBaja" value="Baja" id="btndarBaja"  onclick="JavaScript:cargarFocus('modDam/mod_registro/ejec/bajar.php?idAtleta=<?= $idDep ?>','dvBotones','carga','');">Dar de Baja</button>
      </div>
    



    </div>
    </form>
    </div>
		</body>
</html>
<?
  }


