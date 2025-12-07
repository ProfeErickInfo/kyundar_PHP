ƒ// JavaScript Document
//////////////////////////////////////////////////////
function relocate(page,params)
 {
	  var body = document.body;
	  form=document.createElement('form'); 
	  form.method = 'POST'; 
	  form.action = page;
	  form.name = 'jsform';
	  for (index in params)
	  {
			var input = document.createElement('input');
			input.type='hidden';
			input.name=index;
			input.id=index;
			input.value=params[index];
			form.appendChild(input);
	  }	  		  			  
	  body.appendChild(form);
	  form.submit();
 }

//////////////////////////////////////////////////////



function validarEntero(valor){ 
     	//intento convertir a entero. 
     //si era un entero no le afecta, si no lo era lo intenta convertir 
     valor = parseInt(valor); 

     	//Compruebo si es un valor num�rico 
     	if (isNaN(valor)) { 
           	 //entonces (no es numero) devuelvo el valor cadena vacia 
          	 return "";
     	}else{ 
           	 //En caso contrario (Si era un n�mero) devuelvo el valor 
           	 return valor;
     	} 
}
////////////////////////////////////////////////////////////////////////////
// Validar los campos
function validarEmail(){
    //var hayAlgo = true;
    if(document.regdocente.txtemail.value==""){
       // hayAlgo = false;
        alert("La cuenta de correo no puede estar en blanco.");
        document.regdocente.txtemail.focus();
        return false;
    }
    // validar la cuenta de correo usando una expresi�n regular (RegExp)
	
    if(document.regdocente.txtemail.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
        //hayAlgo = false;
        alert("La cuenta no es v�lida, debes escribirla de forma: nombre@servidor.dominio");
        document.regdocente.txtemail.select();
        document.regdocente.txtemail.focus();
        return false;
    }
}
////////////////////////////////////////////////////////////////////////////
function valida_envia(){ 
//valido el documento. tiene que ser entero largo  
  	docu = document.regdocente.txtdocumento.value; 
  	docu = validarEntero(docu); 
 	document.regdocente.txtdocumento.value=docu ;
   	if (docu==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE DOCUMENTO VALIDO.");
      	 document.regdocente.txtdocumento.focus();
     	 return 0; 
   	}
   	
   	//valido el nombre 
   	if (document.regdocente.txtnombre.value.length==0){ 
     	 alert("TIENE QUE ESCRIBIR SU NOMBRE"); 
     	 document.regdocente.txtnombre.focus(); 
     	 return 0; 
  	} 
   //valido el apellido
   	if (document.regdocente.txtapellido.value.length==0){ 
      	 alert("TIENE QUE ESCRIBIR SUS APELLIDOS"); 
      	 document.regdocente.txtapellido.focus(); 
      	 return 0; 
   	} 
   	
//valido la direccion
   	if (document.regdocente.txtdireccion.value.length==0){ 
    	 alert("TIENE QUE ESCRIBIR SU DIRECCION"); 
      	 document.regdocente.txtdireccion.focus(); 
     	 return 0; 
   	} 
	//valido el telefono. tiene que ser entero largo  
  	tel = document.regdocente.txttelefono.value; 
  	tel = validarEntero(tel); 
 	document.regdocente.txttelefono.value=tel; 
   	if (tel==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE TELEFONO VALIDO.");
      	 document.regdocente.txttelefono.focus(); 
     	 return 0; 
   	}
	
	//valido la direccion de email
   	 if(document.regdocente.txtemail.value==""){
        hayAlgo = false;
        alert("LA CUENTA DE CORREO NO PUEDE ESTAR EN BLANCO.");
        document.regdocente.txtemail.focus();
        return false;
    }
    // validar la cuenta de correo usando una expresi�n regular (RegExp)
    if(document.regdocente.txtemail.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
        hayAlgo = false;
        alert("LA CUENTA NO ES VALIDA, DEBES ESCRIBIRLA EN LA FORMA: nombre@servidor.dominio");
        document.regdocente.txtemail.select();
        document.regdocente.txtemail.focus();
        return false;
    }
		
	
	
	//VERIFICO LA DIRECCION DE EMAIL  
  	//email = document.regdocente.txtemail.value 
   	//if (validarEmail(email)){ 
	//if (document.regdocente.txtemail.value.indexOf('@') == -1){
    // 	 alert("TIENE QUE ESCRIBIR SU DIRECCION DE CORREO VALIDO. ")
    //  	 document.regdocente.txtemail.focus() 
    // 	 return 0; 
   	//}
	
	
	//valido el telefono. tiene que ser entero largo  
  	cel = document.regdocente.txtcelular.value; 
  	cel = validarEntero(cel); 
 	document.regdocente.txtcelular.value=cel ;
   	if (cel==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE CELULAR VALIDO.");
      	 document.regdocente.txtcelular.focus(); 
     	 return 0; 
   	}
	
   	//valido el inter�s 
   	//if (document.fvalida.interes.selectedIndex==0){ 
    //  	 alert("Debe seleccionar un motivo de su contacto.") 
    //  	 document.fvalida.interes.focus() 
    //  	 return 0; 
   	//s} 

   	//el formulario se envia 
   	//alert("MUCHAS GRACIAS POR ACTUALIZAR SUS DATOS"); 
   	document.regdocente.submit(); 
} 


function valida_envia2(){ 

//valido el documento. tiene que ser entero largo
   
   	if(id_usuface=""){
		alert("NO HAY DOCENTE SELECCIONADO"); 
		return 0;
	}
	
      	//valido LA INSTITUCION EDUCATIVA
   	if (document.infoacademia.txteducativa.value.length==0){ 
     	 alert("TIENE QUE ESCRIBIR EL NOMBRE DE LA INSTITUCION EDUCATIVA"); 
     	 document.infoacademia.txteducativa.focus(); 
     	 return 0; 
  	} 
   //valido el TITULO
   	if (document.infoacademia.txttitulo.value.length==0){ 
      	 alert("TIENE QUE ESCRIBIR EL TITULO OBTENIDO"); 
      	 document.infoacademia.txttitulo.focus(); 
      	 return 0; 
   	} 
   	

   	
	//el formulario se envia 
   	alert("MUCHAS GRACIAS POR ACTUALIZAR SUS DATOS ACADEMICOS"); 
   	document.infoacademia.submit(); 
} 


function valida_envia3(){ 
//valido el NUEMRO DE CONTARTO. tiene que ser entero largo  
  	numc = document.regdocfinan.txtnumcontrato.value; 
  	numc = validarEntero(numc); 
 	document.regdocfinan.txtnumcontrato.value=numc ;
   	if (numc==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE CONTRATO VALIDO.");
      	 document.regdocfinan.txtnumcontrato.focus();
     	 return 0; 
   	}
   	
	//valido el VALOR DE CONTRATO. tiene que ser entero largo  
	valc = document.regdocfinan.txtvalcontrato.value; 
  	valc = validarEntero(valc); 
 	document.regdocfinan.txtvalcontrato.value=valc ;
   	if (valc==""){ 
     	 alert("TIENE QUE INTRODUCIR EL VALOR DE CONTRATO VALIDO.");
      	 document.regdocfinan.txtvalcontrato.focus();
     	 return 0; 
   	}
	
   	//valido LA FECHA DE INGRSO 
   	if (document.regdocfinan.txtfecingreso.value.length==0){ 
     	 alert("TIENE QUE ESCRIBIR LA FECHA DE INGRESO"); 
     	 document.regdocfinan.txtfecingreso.focus(); 
     	 return 0; 
  	} 
   //valido LA FECHA DE RETIRO
   //	if (document.regdocfinan.txtfecretiro.value.length==0){ 
   //  	 alert("TIENE QUE ESCRIBIR LA FECHA DE RETIRO"); 
    //  	 document.regdocfinan.txtfecretiro.focus(); 
    //  	 return 0; 
   //	} 
   	
//valido la RAZON DE RETIRO
   //	if (document.regdocfinan.txtrazon.value.length==0){ 
  //  	 alert("TIENE QUE ESCRIBIR LA RAZON DE RETIRO"); 
  //    	 document.regdocfinan.txtrazon.focus(); 
 //    	 return 0; 
  // 	} 
	

   	//el formulario se envia 
   	//alert("PROCESO DE VALIDACION FINALIZADO, SE INICIARA AHORA EL PROCESO DE REGISTRO"); 
   	document.regdocfinan.submit(); 
} 



function valida_envia4(){ 
//valido el NUEMRO DE HORAS. tiene que ser entero largo  
  	numh = document.regcargaaca.txthora.value; 
  	numh = validarEntero(numh); 
 	document.regcargaaca.txthora.value=numh ;
   	if (numh==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE HORAS VALIDO.");
      	 document.regcargaaca.txthora.focus();
     	 return 0; 
   	}
   	

   	//el formulario se envia 
   	//alert("CARGA ASIGNADA SATISFACTORIAMENTE"); 
   	document.regcargaaca.submit(); 
} 

function valida_envia5(){
	//valido LA FECHA DE INGRSO 
   	if (document.regdocAD.txtfecingre.value.length==0){ 
     	 alert("TIENE QUE ESCRIBIR LA FECHA DE INGRESO"); 
     	 document.regdocAD.txtfecingre.focus(); 
     	 return 0; 
  	} 
//valido el POCENTAJE. tiene que ser entero largo  
  	valp = document.regdocAD.txtporcentaje.value; 
  	valp = validarEntero(valp); 
 	document.regdocAD.txtporcentaje.value=valp ;
   	if (valp==""){ 
     	 alert("TIENE QUE INTRODUCIR UN PORCENTAJE VALIDO.");
      	 document.regdocAD.txtporcentaje.focus();
     	 return 0; 
   	}
	
   	//} 
   	

   	//el formulario se envia 
   	alert("MUCHAS GRACIAS POR ACTUALIZAR LOS DATOS ADMINISTRATIVOS"); 
   	document.regdocAD.submit(); 
} 

function valida_envia_carga(){ 
	//alert ('entre');
	numh = document.modcarga.txthora.value; 
  	numh = validarEntero(numh); 
 	document.modcarga.txthora.value=numh ;
	//alert ('llame al doc');
   	if (numh=="" || numh==0){ 
	//alert ('pregunta');
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE HORAS VALIDO.");
      	 document.modcarga.txthora.focus();
     	 return 0; 
   	}
   	

   	//el formulario se envia 
   	//alert("CARGA ASIGNADA SATISFACTORIAMENTE"); 
   	document.modcarga.submit(); 
} 
function activa_retiro(){
	//valido 
	document.regdocfinan.txtrazon.disabled=false;
	document.regdocfinan.txtfecretiro.disabled=false;
	document.regdocfinan.check_act.checked=false;
	document.regdocfinan.txtrazon.focus();
	//document.regdocfinan.btnretirar.disabled=false;
	//document.regdocfinan.btncancelar.disabled=true;
   	
} 

function cancelar_retiro(){
	//valido 
	document.regdocfinan.txtrazon.disabled=true;
	document.regdocfinan.txtfecretiro.disabled=true;
	document.regdocfinan.check_act.checked=true;
	//document.regdocfinan.btncancelar.disabled=false;
	//document.regdocfinan.btnretirar.disabled=true;
   	
} 
function confirmar() {
	
    if (confirm ("�El docente ya existe, desea modificarlo?")) {
        //Env�a el formulario
        return true;
    } else {
        //No env�a el formulario
       return false;
    }
}

function valcheck1(val1,val2){
	
}

function valida_envia6(){ 
//valido el NUEMRO DE CONTARTO. tiene que ser entero largo  
  	numc = document.regfinanfin.txtnumcontrato.value; 
  	numc = validarEntero(numc); 
 	document.regfinanfin.txtnumcontrato.value=numc ;
   	if (numc==""){ 
     	 alert("TIENE QUE INTRODUCIR UN NUMERO DE CONTARTO VALIDO.");
      	 document.regfinanfin.txtnumcontrato.focus();
     	 return 0; 
   	}
   	
	//valido el VALOR DE CONTRATO. tiene que ser entero largo  
	valc = document.regfinanfin.txtvalcontrato.value; 
  	valc = validarEntero(valc); 
 	document.regfinanfin.txtvalcontrato.value=valc ;
   	if (valc==""){ 
     	 alert("TIENE QUE INTRODUCIR EL VALOR DE CONTARTO VALIDO.");
      	 document.regfinanfin.txtvalcontrato.focus();
     	 return 0; 
   	}
	
   	//valido LA FECHA DE INGRSO 
   	if (document.regfinanfin.txtfecingreso.value.length==0){ 
     	 alert("TIENE QUE ESCRIBIR LA FECHA DE INGRESO"); 
     	 document.regfinanfin.txtfecingreso.focus(); 
     	 return 0; 
  	} 
   //valido LA FECHA DE RETIRO
   	if (document.regfinanfin.txtfecretiro.value.length==0){ 
      	 alert("TIENE QUE ESCRIBIR LA FECHA DE RETIRO"); 
      	 document.regfinanfin.txtfecretiro.focus(); 
      	 return 0; 
   	} 
   	
//valido la RAZON DE RETIRO
  	if (document.regfinanfin.txtrazon.value.length==0){ 
    	 alert("TIENE QUE ESCRIBIR LA RAZON DE RETIRO"); 
      	 document.regfinanfin.txtrazon.focus(); 
     	 return 0; 
  	} 
	

   	//el formulario se envia 
   	alert("EL REGISTRO SE PROCESARA AHORA..."); 
   	document.regfinanfin.submit(); 
} 
function pedirDatos(id_p){
  //donde se mostrar� el formulario con los datos
  divFormulario = document.getElementById('formulario');
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod GET
  ajax.open("GET", "modificar_admin.php?id="+id_p);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divFormulario.innerHTML = ajax.responseText;
  //mostrar el formulario
  divFormulario.style.display="block";
  }
  }
  //como hacemos uso del metodo GET
  //colocamos null
  ajax.send(null);
}

// JavaScript Document

//formulario piramide//////////////
function valid_piram(form){
		//alert(form);

		if(confirm("Esta seguro de aplicar la piramide?"))
	
		{
	
		
		//cadenaFormulario= 'siembras='+siembras;
		
	
				form.submit();
				
	
		}
	
		
	}


////////////////////////////////////



// ********************** VALIDACION DE FORMULARIOS ****************************



// ********************** INGRESOS ****************************



//Validar modulo de ingreso por formulario.

	function valid_athlet(form)

	{


		i=0;
		
       var miCampoTexto = document.getElementById('txtDocumento').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el documento del(la) deportista.");
			document.getElementById('txtDocumento').focus();
            return false;
        }else{
		    i=i+1;
           
         }
		 ///////////////////////////////////////////////////////////////
	
			var miCampoTexto = document.getElementById('txtNombres').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el nombre del(la) deportista.");
			document.getElementById('txtNombres').focus();
            return false;
        }else{
		    i=i+1;
           
         }
        ////////////////////////////////////////////////////////////////////
			var miCampoTexto = document.getElementById('txtApellidos').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese los apellidos del(la) deportista.");
			document.getElementById('txtApellidos').focus();
            return false;
        }else{
		    i=i+1;
           
         }

		 ////////////////////////////////////////////////////////////////////	
				var miCampoTexto = document.getElementById('Barrio').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el barrio del(la) deportista.");
			document.getElementById('Barrio').focus();
            return false;
        }else{
		    i=i+1;
           
         }

		 ////////////////////////////////////////////////////////////////////	
						
      var miCampoTexto = document.getElementById('txtDireccion').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese la direcci�n del(la) deportista.");
			document.getElementById('txtDireccion').focus();
            return false;
        }else{
		    i=i+1;
           
         }
	    ////////////////////////////////////////////////////////////////////	
			 var miCampoTexto = document.getElementById('txtCelular').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el telefono del(la) deportista.");
			document.getElementById('txtCelular').focus();
            return false;
        }else{
		    i=i+1;
           
         }
	    ////////////////////////////////////////////////////////////////////
	    var miCampoTexto = document.getElementById('txtSalud').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese la entidad de salud del(la) deportista.");
			document.getElementById('txtSalud').focus();
            return false;
        }else{
		    i=i+1;
           
         }
	    ////////////////////////////////////////////////////////////////////

			 var miCampoTexto = document.getElementById('txtEmail').value;
        //la condici�n
        if(miCampoTexto.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
			alert("Por favor ingrese el correo correctamente del(la) deportista.");
			document.getElementById('txtEmail').focus();
            return false;
        }else{
		    i=i+1;
           
         }
	    ////////////////////////////////////////////////////////////////////
 var miCampoTexto = document.getElementById('txtDocumento2').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el documento del(la) acudiente.");
			document.getElementById('txtDocumento2').focus();
            return false;
        }else{
		    i=i+1;
           
         }
		 ///////////////////////////////////////////////////////////////
	
			var miCampoTexto = document.getElementById('txtAcudiente').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el nombre del(la) acudiente.");
			document.getElementById('txtAcudiente').focus();
            return false;
        }else{
		    i=i+1;
           
         }
        ////////////////////////////////////////////////////////////////////
			

			

			if(i!=0)

			{	

				if(confirm("Esta seguro de registrar el(la) deportista?"))

				{

						form.submit();
						

				}

			}

	}

	


	
//Validar modulo de ingreso por formulario.

function valid_athlet_m(form)

{

//alert('En funcion');
	i=0;
	
   var miCampoTexto = document.getElementById('txtDocumento').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el documento del(la) deportista.");
		document.getElementById('txtDocumento').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	 ///////////////////////////////////////////////////////////////

		var miCampoTexto = document.getElementById('txtNombres').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el nombre del(la) deportista.");
		document.getElementById('txtNombres').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
		var miCampoTexto = document.getElementById('txtApellidos').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese los apellidos del(la) deportista.");
		document.getElementById('txtApellidos').focus();
		return false;
	}else{
		i=i+1;
	   
	 }

	 ////////////////////////////////////////////////////////////////////	
			var miCampoTexto = document.getElementById('Barrio').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el barrio del(la) deportista.");
		document.getElementById('Barrio').focus();
		return false;
	}else{
		i=i+1;
	   
	 }

	 ////////////////////////////////////////////////////////////////////	
					
  var miCampoTexto = document.getElementById('txtDireccion').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese la direcci�n del(la) deportista.");
		document.getElementById('txtDireccion').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////	
		 var miCampoTexto = document.getElementById('txtCelular').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el telefono del(la) deportista.");
		document.getElementById('txtCelular').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
	var miCampoTexto = document.getElementById('txtSalud').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese la entidad de salud del(la) deportista.");
		document.getElementById('txtSalud').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////

		 var miCampoTexto = document.getElementById('txtEmail').value;
	//la condici�n
	if(miCampoTexto.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
		alert("Por favor ingrese el correo correctamente del(la) deportista.");
		document.getElementById('txtEmail').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
var miCampoTexto = document.getElementById('txtDocumento2').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el documento del(la) acudiente.");
		document.getElementById('txtDocumento2').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	 ///////////////////////////////////////////////////////////////

		var miCampoTexto = document.getElementById('txtAcudiente').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el nombre del(la) acudiente.");
		document.getElementById('txtAcudiente').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
		

		

		if(i!=0)

		{	

			if(confirm("Esta seguro de realizar la actualización del registro?"))

			{

					form.submit();
					

			}

		}

}

///////////////////VALIDAR ACTUALIZACION DE SOCIOS///////DATOS PERSONALES//////////
//Validar modulo de ingreso por formulario.

function valid_socio_m(form)

{

//alert('En funcion');
	i=0;
	
   var miCampoTexto = document.getElementById('txtDocumento').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el documento del(la) socio.");
		document.getElementById('txtDocumento').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	 ///////////////////////////////////////////////////////////////

		var miCampoTexto = document.getElementById('txtNombres').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el nombre del(la) socio.");
		document.getElementById('txtNombres').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
		var miCampoTexto = document.getElementById('txtApellidos').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese los apellidos del(la) socio.");
		document.getElementById('txtApellidos').focus();
		return false;
	}else{
		i=i+1;
	   
	 }

	 ////////////////////////////////////////////////////////////////////	
			var miCampoTexto = document.getElementById('Barrio').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el barrio del(la) socio.");
		document.getElementById('Barrio').focus();
		return false;
	}else{
		i=i+1;
	   
	 }

	 ////////////////////////////////////////////////////////////////////	
					
  var miCampoTexto = document.getElementById('txtDireccion').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese la direcci�n del(la) socio.");
		document.getElementById('txtDireccion').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////	
		 var miCampoTexto = document.getElementById('txtCelular').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese el telefono del(la) socio.");
		document.getElementById('txtCelular').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////
	var miCampoTexto = document.getElementById('txtSalud').value;
	//la condici�n
	if(miCampoTexto.length == 0){
		alert("Por favor ingrese la entidad de salud del(la) socio.");
		document.getElementById('txtSalud').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	////////////////////////////////////////////////////////////////////

		 var miCampoTexto = document.getElementById('txtEmail').value;
	//la condici�n
	if(miCampoTexto.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
		alert("Por favor ingrese el correo correctamente del(la) socio.");
		document.getElementById('txtEmail').focus();
		return false;
	}else{
		i=i+1;
	   
	 }
	
	
	////////////////////////////////////////////////////////////////////
		

		

		if(i!=0)

		{	

			if(confirm("Esta seguro de realizar la actualización del registro del socio?"))

			{

					form.submit();
					

			}

		}

}




//////////////////////////////////////////////////////////////////////////////////



	//Validar modulo de ingreso por estudiantes.

	function validardatos_Atleta(form){
		alert('Esta a punto de editar la info del atleta');
var dato;

		i=0;

			if (form.TipoDocumento.value == "")

  			{ 

				alert("Por favor seleccione el tipo de documento del(la) deportista."); form.TipoDocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtDocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del(la) deportista."); form.txtDocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtNombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre del(la) deportista."); form.txtNombres.focus(); return; 

			}

			else i=i+1;

			if (form.txtApellidos.value == "")

  			{ 

				alert("Por favor ingrese el apellido del(la) deportista."); form.txtApellidos.focus(); return; 

			}

			else i=i+1;

			if (form.Tpsalud.value == "")

  			{ 

				alert("Por favor seleccione el servicio de salud del(la) deportista."); form.Tpsalud.focus(); return; 

			}

			else i=i+1;

			if (form.txtSalud.value == "")

  			{ 

				alert("Por favor ingrese el servicio de salud del(la) deportista."); form.txtSalud.focus(); return; 

			}

			else i=i+1;

			if (form.txtEmail.value == "" )

  			{ 

				alert("Por favor ingrese el email del(la) deportista."); form.txtEmail.focus(); return; 

			}

			else i=i+1;

			if (form.txtEmail.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email del(la) deportista en la forma: nombre@servidor.dominio"); form.txtEmail.focus(); return; 

			}

			else i=i+1;

			

			if(i=8)

			{	

				if(confirm("Esta seguro de editar la info del deportista?"))

				{

						form.submit();

				}

			}
		
	}

	

//Validar modulo de ingreso por padres_aspirantes.

	function validardatos_padres_aspirantes(form)

	{


		var dato;

		i=0;

			if (form.txtNombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre del acudiente."); form.txtNombres.focus(); return; 

			}

			else i=i+1;

			if (form.txtApellidos.value == "")

  			{ 

				alert("Por favor ingrese el apellido del acudiente."); form.txtApellidos.focus(); return; 

			}

			else i=i+1;

			if (form.TipoDocumento.value == "")

  			{ 

				alert("Por favor seleccione el tipo de documento del acudiente."); form.TipoAcudiente.focus(); return; 

			}

			else i=i+1;
            
			if ((form.txtDocumento.value == "")||(form.txtDocumento.value <1))

  			{ 

				alert("Por favor ingrese el documento del acudiente."); form.txtDocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtTelefono.value == "")

  			{ 

				alert("Por favor ingrese el numero de telefono del acudiente."); form.txtTelefono.focus(); return; 

			}

			else i=i+1;

			if (form.txtCelular.value == "")

  			{ 

				alert("Por favor ingrese el numero de celular del acudiente."); form.txtCelular.focus(); return; 

			}

			else i=i+1;

			if (form.txtEmail.value == "")

  			{ 

				alert("Por favor ingrese el email del acudiente."); form.txtEmail.focus(); return; 

			}

			else i=i+1;

			if (form.txtEmail.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email del aspirante en la forma: nombre@servidor.dominio"); form.txtEmail.focus(); return; 

			}

			else i=i+1;

			if (form.TipoAcudiente.value == "")

  			{ 

				alert("Por favor seleccione el tipo de acudiente."); form.TipoAcudiente.focus(); return; 

			}

			else i=i+1;

			

			if(i=9)

			{	

				if(confirm("Esta seguro de registrar el acudiente?"))

				{

						form.submit();

				}

			}

	}

	

//Validar modulo de ingreso por colegios_aspirantes.

	function validardatos_colegios_aspirantes(form)

	{

		var dato;

		i=0;

			if (form.txtColegio.value == "")

  			{ 

				alert("Por favor ingrese el nombre del colegio."); form.txtColegio.focus(); return; 

			}

			else i=i+1;

			if (form.txtAnoIngreso.value == "")

  			{ 

				alert("Por favor digite el ano de ingreso."); form.txtAnoIngreso.focus(); return; 

			}

			else i=i+1;

			if (form.txtAnoSalida.value == "")

  			{ 

				alert("Por favor digite el ano de salida."); form.txtAnoSalida.focus(); return; 

			}

			else i=i+1;

			if (form.Grados.value == "")

  			{ 

				alert("Por favor seleccione el grado cursado en el colegio."); form.txtRazon.focus(); return; 

			}

			else i=i+1;

			if (form.txtRazon.value == "")

  			{ 

				alert("Por favor ingrese la razon de salida."); form.txtRazon.focus(); return; 

			}

			else i=i+1;

			

			if(i=5)

			{	

				if(confirm("Esta seguro de registrar el colegio?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de ingreso por matriculas individuales.

	function validardatos_martriculas(form)

	{

		var dato, msg;

		i=0;

			if (form.ndocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del aspirante."); form.ndocumento.focus(); return; 

			}

			else i=i+1;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del aspirante."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.apellido.value == "")

  			{ 

				alert("Por favor ingrese el apellido del aspirante."); form.apellido.focus(); return; 

			}

			else i=i+1;

			if (form.grados.value == "")

  			{ 

				alert("Por favor confirme seleccione el grado del aspirante."); form.grados.focus(); return; 

			}

			else i=i+1;

			if(i=5)

			{	

				dato=form.nombre.value +" "+ form.apellido.value;

				

				if(form.registrar.value=="Generar")

				{

					msg="Esta seguro de generar la matricula para el aspirante "+dato+"?";

				

				}else 

					if(form.registrar.value=="Modificar"){

				

						msg="Esta seguro de modificar la matricula para el aspirante "+dato+"?";					

				

					}else{

				

						msg="Esta seguro de Registrar el pago de la matricula para el aspirante "+dato+"?";					

					}

				

				

				if(confirm(msg))

				{

						form.submit();

				}

			}

	}



//Validar modulo de ingreso por matriculas x grado.

	function validardatos_martriculasg(form)

	{

		var dato;

		i=0;

			if (form.grados.value == "")

  			{ 

				alert("Por favor confirme seleccione el grado del aspirante."); form.grados.focus(); return; 

			}

			else i=i+1;

			if(i=1)

			{	

				dato=form.grados.value;

				

				if(confirm("Esta seguro de generar la matricula para el grado "+dato+"?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de ingreso por matriculas individuales.

	function validardatos_vmartriculasi(form)

	{

		var dato;

		i=0;

			if (form.ndocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del aspirante."); form.ndocumento.focus(); return; 

			}

			else i=i+1;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del aspirante."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.apellido.value == "")

  			{ 

				alert("Por favor ingrese el apellido del aspirante."); form.apellido.focus(); return; 

			}

			else i=i+1;

			if(i=3)

			{	

				dato=form.nombre.value +" "+ form.apellido.value;

				

				if(confirm("Esta seguro de visualizar la matricula para el aspirante "+dato+"?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de ingreso por pensiones individuales.

	function validardatos_pensiones(form)

	{

		var dato, msg;

		i=0;

			if (form.ndocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del aspirante."); form.ndocumento.focus(); return; 

			}

			else i=i+1;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del aspirante."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.apellido.value == "")

  			{ 

				alert("Por favor ingrese el apellido del aspirante."); form.apellido.focus(); return; 

			}

			else i=i+1;

			if (form.grados.value == "")

  			{ 

				alert("Por favor confirme seleccione el grado del aspirante."); form.grados.focus(); return; 

			}

			else i=i+1;

			if (form.mes.value == "")

  			{ 

				alert("Por favor seleccione el mes de pensi�n."); form.mes.focus(); return; 

			}

			else i=i+1;

			if(i=5)

			{	

				dato=form.nombre.value +" "+ form.apellido.value;

				

				if(form.registrar.value=="Generar")

				{

					msg="Esta seguro de generar la pension para "+dato+"?";

				

				}else{

					msg="Esta seguro de modificar la pension para "+dato+"?";					

				}

				

				

				if(confirm(msg))

				{

						form.submit();

				}

			}

	}



//Validar modulo de pago por pensiones individuales.

	function validardatos_pago_pensiones(form)

	{

		var dato, msg;

		i=0;

			if (form.ndocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del estudiante."); form.ndocumento.focus(); return; 

			}

			else i=i+1;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del estudiante."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.apellido.value == "")

  			{ 

				alert("Por favor ingrese el apellido del estudiante."); form.apellido.focus(); return; 

			}

			else i=i+1;

			if (form.grados.value == "")

  			{ 

				alert("Por favor confirme seleccione el grado del estudiante."); form.grados.focus(); return; 

			}

			else i=i+1;

			if (form.codigo.value == "")

  			{ 

				alert("Por favor ingrese el codigo del estudiante."); form.mes.focus(); return; 

			}

			else i=i+1;

			if(i=5)

			{	

				dato=form.nombre.value +" "+ form.apellido.value;

				

					msg="Esta seguro de registrar el pago de la pension para "+dato+"?";

				

				

				

				if(confirm(msg))

				{

						form.submit();

				}

			}

	}



// ********************** REGISTROS ****************************



//Validar modulo de registro profesores.

	function validardatos_profesores(form)

	{

		var dato;

		i=0;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del profesor."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.apellido.value == "")

  			{ 

				alert("Por favor ingrese el apellido del profesor."); form.apellido.focus(); return; 

			}

			else i=i+1;

			if (form.fecha_nac.value == "")

  			{ 

				alert("Por favor ingrese la fecha de nacimiento del profesor."); form.fecha_nac.focus(); return; 

			}

			else i=i+1;

			if (form.lugar_nac.value == "")

  			{ 

				alert("Por favor ingrese el lugar de nacimiento del profesor."); form.lugar_nac.focus(); return; 

			}

			else i=i+1;

			if (form.tipo_documento.value == "")

  			{ 

				alert("Por favor seleccione el tipo de documento del profesor."); form.tipo_documento.focus(); return; 

			}

			else i=i+1;

			if (form.documento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del profesor."); form.documento.focus(); return; 

			}

			else i=i+1;

			if (form.direccion.value == "")

  			{ 

				alert("Por favor ingrese la direccion del profesor."); form.direccion.focus(); return; 

			}

			else i=i+1;

			if (form.barrio.value == "")

  			{ 

				alert("Por favor ingrese el barrio donde reside el profesor."); form.barrio.focus(); return; 

			}

			else i=i+1;

			if (form.sexo.value == "")

  			{ 

				alert("Por favor seleccione el sexo del profesor."); form.sexo.focus(); return; 

			}

			else i=i+1;

			if (form.telefono.value == "")

  			{ 

				alert("Por favor ingrese el numero de telefono fijo del profesor."); form.telefono.focus(); return; 

			}

			else i=i+1;

			if (form.celular.value == "")

  			{ 

				alert("Por favor ingrese el numero del celular del profesor."); form.celular.focus(); return; 

			}

			else i=i+1;

			if (form.email.value == "")

  			{ 

				alert("Por favor ingrese el E-mail del profesor."); form.email.focus(); return; 

			}

			else i=i+1;

			

			if(i=12)

			{	

				if(confirm("Esta seguro de registrar el profesor?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro asignaturas.

	function validardatos_asignaturas(form)

	{

		var dato;

		i=0;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre de la asignatura."); form.nombre.focus(); return; 

			}

			else i=i+1;

			

			if(i=1)

			{	

				if(confirm("Esta seguro de registrar la asignatura?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro grados.

	function validardatos_grados(form)

	{

		var dato;

		i=0;

			if (form.val_mat.value == "")

  			{ 

				alert("Por favor ingrese el valor de la matricula para el grado."); form.val_mat.focus(); return; 

			}

			else i=i+1;

			if (form.val_pension.value == "")

  			{ 

				alert("Por favor ingrese el valor de la pension para el grado."); form.val_pension.focus(); return; 

			}

			else i=i+1;

			

			if(i=2)

			{	

				if(confirm("�Esta seguro de actualizar el grado?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro salones.

	function validardatos_salones(form)

	{

		var dato;

		i=0;

			if (form.nombre.value == "")

  			{ 

				alert("Por favor ingrese el nombre del sal�n."); form.nombre.focus(); return; 

			}

			else i=i+1;

			if (form.capacidad.value == "")

  			{ 

				alert("Por favor ingrese la capacidad del sal�n."); form.capacidad.focus(); return; 

			}

			else i=i+1;

			if (form.descripcion.value == "")

  			{ 

				alert("Por favor ingrese la descripci�n del sal�n."); form.descripcion.focus(); return; 

			}

			else i=i+1;

			

			if(i=3)

			{	

				if(confirm("�Esta seguro de agregar el sal�n?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro documentos.

	function validardatos_documentos(form)

	{

		var dato;

		i=0;

			if (form.detalle.value == "")

  			{ 

				alert("Por favor ingrese el detalle del documento."); form.detalle.focus(); return; 

			}

			else i=i+1;

			

			if(i=1)

			{	

				if(confirm("Esta seguro de registrar el documento?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro otros ingresos.

	function validardatos_otrosingresos(form)

	{

		var dato;

		i=0;

			if (form.concepto.value == "")

  			{ 

				alert("Por favor ingrese el concepto."); form.concepto.focus(); return; 

			}

			else i=i+1;

			if (form.valor.value == "")

  			{ 

				alert("Por favor ingrese el valor."); form.valor.focus(); return; 

			}

			else i=i+1;

			if (form.incluyem.value == "")

  			{ 

				alert("Por favor seleccione la opci�n [incluir o no incluir en la matricula]."); form.incluyem.focus(); return; 

			}

			else i=i+1;

			if (form.incluyep.value == "")

  			{ 

				alert("Por favor seleccione la opci�n [incluir o no incluir en la pension]."); form.incluyep.focus(); return; 

			}

			else i=i+1;

			

			if(i=4)

			{	

				if(confirm("�Esta seguro de agregar el ingreso?"))

				{

						form.submit();

				}

			}

	}



// ********************** REGISTROS ACADEMICOS ****************************



//Validar modulo de registro GRUPOS.

	function validardatos_grupos(form)

	{

		var dato;

		i=0;

			if (form.nomgrupo.value == "")

  			{ 

				alert("Por favor ingrese el nombre del grupo."); form.nomgrupo.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrado.value == "")

  			{ 

				alert("Por favor seleccione el grado."); form.cbgrado.focus(); return; 

			}

			else i=i+1;

			if (form.cbsalon.value == "")

  			{ 

				alert("Por favor seleccione el sal�n."); form.cbsalon.focus(); return; 

			}

			else i=i+1;

			if (form.cbprofesor.value == "")

  			{ 

				alert("Por favor seleccione el profesor."); form.cbprofesor.focus(); return; 

			}

			else i=i+1;

			

			if(i=4)

			{	

				if(confirm("Esta seguro de registrar el grupo?"))

				{

						form.submit();

				}

			}

	}

	

//Validar modulo de registro CARGA.

	function validardatos_carga(form)

	{

		var dato;

		i=0;

			if (form.cbprofesor.value == "")

  			{ 

				alert("Por favor seleccione el nombre del profesor."); form.cbprofesor.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrado.value == "")

  			{ 

				alert("Por favor seleccione el grado."); form.cbgrado.focus(); return; 

			}

			else i=i+1;

			if (form.cbarea.value == "")

  			{ 

				alert("Por favor seleccione la asignatura."); form.cbarea.focus(); return; 

			}

			else i=i+1;

			if (form.numhoras.value == "")

  			{ 

				alert("Por favor digite el numero de horas en forma correcta."); form.numhoras.focus(); return; 

			}

			else i=i+1;

			

			if(i=4)

			{	

				if(confirm("Esta seguro de registrar la carga academica?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro HORA.

	function validardatos_hora(form)

	{

		var dato;

		i=0;

			if (form.cbHora.value == "")

  			{ 

				alert("Por favor seleccione la hora."); form.cbHora.focus(); return; 

			}

			else i=i+1;

			if (form.cbMinuto.value == "")

  			{ 

				alert("Por favor seleccione el minuto."); form.cbMinuto.focus(); return; 

			}

			else i=i+1;

			

			if(i=2)

			{	

				if(confirm("Esta seguro de registrar la hora?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro AsigGrupo.

	function validardatos_asigGrupo(form)

	{

		var dato;

		i=0;

			if (form.cbgrupo.value == "")

  			{ 

				alert("Por favor seleccione el grupo."); form.cbgrupo.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrado.value == "")

  			{ 

				alert("Por favor seleccione el grado."); form.cbgrado.focus(); return; 

			}

			else i=i+1;

			

			if(i=2)

			{	

				if(confirm("Esta seguro de continuar con el proceso de asignacion de estudiantes?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro AsigGrupo.

	function validardatos_asigGrupo(form)

	{

		var dato;

		i=0;

			if (form.cbgrupo.value == "")

  			{ 

				alert("Por favor seleccione el grupo."); form.cbgrupo.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrado.value == "")

  			{ 

				alert("Por favor seleccione el grado."); form.cbgrado.focus(); return; 

			}

			else i=i+1;

			

			if(i=2)

			{	

				if(confirm("Esta seguro de continuar con el proceso de asignacion de estudiantes?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro AsigCambioGrupo.

	function validardatos_asigCambioGrupo(form)

	{

		var dato;

		i=0;

			if (form.cbgrupoO.value == "")

  			{ 

				alert("Por favor seleccione el grupo origen."); form.cbgrupoO.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrupoD.value == "")

  			{ 

				alert("Por favor seleccione el grado destino."); form.cbgrupoD.focus(); return; 

			}

			else i=i+1;

			

			if(i=2)

			{	

				if(confirm("Esta seguro de continuar con el proceso de transferencia de estudiantes entre grupos?"))

				{

						form.submit();

				}

			}

	}



//Validar modulo de registro GenerarMaya.

	function validardatos_GrupoMaya(form)

	{

		var dato;

		i=0;

			if (form.cbgrupo.value == "")

  			{ 

				alert("Por favor seleccione el grupo a generar."); form.cbgrupo.focus(); return; 

			}

			else i=i+1;

			

			if(i=1)

			{	

				if(confirm("Esta seguro de generar maya de horarios para el grupo?"))

				{

						form.submit();

				}

			}

	}

	

//Validar modulo de registro INDICADORES.

	function validardatos_indicadores(form)

	{

		var dato;

		i=0;

			if (form.contenido.value == "")

  			{ 

				alert("Por favor ingrese el indicador."); form.contenido.focus(); return; 

			}

			else i=i+1;

			if (form.cbarea.value == "")

  			{ 

				alert("Por favor seleccione la asignatura."); form.cbarea.focus(); return; 

			}

			else i=i+1;

			if (form.cbperiodo.value == "")

  			{ 

				alert("Por favor seleccione el periodo."); form.cbperiodo.focus(); return; 

			}

			else i=i+1;

			if (form.cbgrado.value == "")

  			{ 

				alert("Por favor seleccione el grado."); form.cbgrado.focus(); return; 

			}

			else i=i+1;

			if (form.cbnota.value == "")

  			{ 

				alert("Por favor seleccione la calificaci�n."); form.cbnota.focus(); return; 

			}

			else i=i+1;

			

			if(i=5)

			{	

				if(confirm("Esta seguro de registrar el indicador?"))

				{

						form.submit();

						form.reset();

						form.contenido.focus();

				}

			}

	}



//Validar modulo de registro RECOMENDACIONES.

	function validardatos_recomendaciones(form)

	{

		var dato;

		i=0;

			if (form.contenido_r.value == "")

  			{ 

				alert("Por favor ingrese la recomendaci�n."); form.contenido_r.focus(); return; 

			}

			else i=i+1;

			if (form.cbarea_r.value == "")

  			{ 

				alert("Por favor seleccione la asignatura."); form.cbarea_r.focus(); return; 

			}

			else i=i+1;

			if (form.cbnota_r.value == "")

  			{ 

				alert("Por favor seleccione la calificaci�n."); form.cbnota_r.focus(); return; 

			}

			else i=i+1;

			

			if(i=3)

			{	

				if(confirm("Esta seguro de registrar la recomendaci�n?"))

				{

						form.submit();

						form.reset();

						form.contenido_r.focus();

				}

			}

	}



//Validar modulo de registro CALIFICACIONES.

	function validardatos_RCalificacion(form)

	{
		
		var dato;

		i=0;

			if (form.sDep.value == "")

  			{ 

				alert("Por favor seleccione un grupo."); form.sDep.focus(); return; 

			}

			else i=i+1;

			if (form.idEst.value == "")

  			{ 

				alert("Por favor seleccione un estudiante.");  return; 

			}

			else i=i+1;

			if (form.id_indica.value == "")

  			{ 

				alert("Por favor ingrese el indicador."); form.id_indica.focus(); return; 

			}

			else i=i+1;

			if (form.id_recomen.value == "")

  			{ 

				alert("Por favor ingrese la recomendaci�n."); form.id_recomen.focus(); return; 

			}

			else i=i+1;

			if (form.asignatu.value == "")

  			{ 

				alert("Por favor seleccione el grupo."); form.sDep.focus(); return; 

			}

			else i=i+1;

			if (form.cbperiodo2.value == "")

  			{ 

				alert("Por favor seleccione el periodo."); form.cbperiodo2.focus(); return; 

			}

			else i=i+1;

			if (form.nota_Est.value == "")

  			{ 

				alert("Por favor ingrese la nota cuantitativa."); form.nota_Est.focus(); return; 

			}

			else i=i+1;

			

			if(i=7)

			{	

				if(confirm("Esta seguro de registrar la recomendaci�n?"))

				{

						form.submit();

						form.idEst.value = "";

						form.nombre.value = "";

						form.id_indica.value = "";

						form.valor_indica.value = "";

						form.id_recomen.value = "";

						form.valor_recomen.value = "";

						form.nota_Est.value = "";

						form.sDep.focus();

				}

			}

	}



// ********************** REGISTROS UTILIDAD ****************************



//Validar modulo de registro PASSWORD.

	function validardatos_psw(form)

	{

		var dato;

		i=0;

			if (form.clave1.value == "")

  			{ 

				alert("Por favor digite el password actual."); form.clave1.focus(); return; 

			}

			else i=i+1;

			if (form.clave2.value == "")

  			{ 

				alert("Por favor digite el password nuevo."); form.clave2.focus(); return; 

			}

			else i=i+1;

			if (form.clave3.value == "")

  			{ 

				alert("Por favor digite nuevamente el password."); form.clave3.focus(); return; 

			}

			else i=i+1;

			if (form.clave2.value != form.clave3.value)

  			{ 

				alert("Los password nuevos no coinciden."); form.clave3.focus(); return; 

			}

			else i=i+1;

			

			if(i=4)

			{	

				if(confirm("Esta seguro de cambiar su password?"))

				{

						form.submit();

				}

			}

	}

	

// ********************** FUNCIONES ****************************



//Funcion que solo permite inclusion de numeros.

	var nav4 = window.Event ? true : false;

	function acceptNum(evt)

	{	

		// NOTA: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	

		var key = nav4 ? evt.which : evt.keyCode;	

		return (key <= 13 || (key >= 48 && key <= 57));

	}



//Funcion que cambia el texto a mayuscula.

	function cambiaMayus(dato)

	{   

   		return dato.value=dato.value.toUpperCase();

	}



//Funcion que calcula la edad de una persona.

	function calcular_edad(fecha, form){

	

    //calculo la fecha de hoy

    hoy=new Date()

    //alert(hoy)



    //calculo la fecha que recibo

    //La descompongo en un array

    var array_fecha = fecha.split("-")

    //si el array no tiene tres partes, la fecha es incorrecta

    if (array_fecha.length!=3)

       form.edad.value="False";//return false



    //compruebo que los ano, mes, dia son correctos

    var ano

    ano = parseInt(array_fecha[0]);

    if (isNaN(ano))

       form.edad.value="False";//return false



    var mes

    mes = parseInt(array_fecha[1]);

    if (isNaN(mes))

       form.edad.value="False";//return false



    var dia

    dia = parseInt(array_fecha[2]);

    if (isNaN(dia))

       form.edad.value="False";//return false





    //si el a�o de la fecha que recibo solo tiene 2 cifras hay que cambiarlo a 4

    if (ano<=99)

       ano +=1900



    //resto los a�os de las dos fechas

    edad=hoy.getYear()- ano - 1; //-1 porque no se si ha cumplido a�os ya este a�o



    //si resto los meses y me da menor que 0 entonces no ha cumplido a�os. Si da mayor si ha cumplido

    if (hoy.getMonth() + 1 - mes < 0) //+ 1 porque los meses empiezan en 0

       form.edad.value= edad//return edad

    if (hoy.getMonth() + 1 - mes > 0)

       form.edad.value=edad+1//return edad+1



    //entonces es que eran iguales. miro los dias

    //si resto los dias y me da menor que 0 entonces no ha cumplido a�os. Si da mayor o igual si ha cumplido

    if (hoy.getUTCDate() - dia >= 0)

       form.edad.value=edad+1//return edad + 1



    form.edad.value=edad+1//return edad

}



//Funcion que emite alerta modulo en construccion.

	function pendiente()

	{   

   		alert("Esta funcionalidad se encuentra en construccion.");

	}



//Validar modulo de ingreso por formulario.

	function val_empleado(form)

	{
//alert('estoy');

		var dato;

		i=0;

			if (form.txtcargo.value == "")

  			{ 

				alert("Por favor ingrese el cargo del empleado."); form.txtcargo.focus(); return; 

			}

			else i=i+1;

			if (form.txtdocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del empleado."); form.txtdocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtnombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre del empleado."); form.txtnombres.focus(); return; 

			}

			else i=i+1;

			if (form.txtfechaN.value == "")

  			{ 

				alert("Por favor ingrese la fecha de nacimiento."); form.txtfechaN.focus(); return; 

			}

			else i=i+1;
			
			if (form.txtOcupacion.value == "")

  			{ 

				alert("Por favor ingrese la ocupaci�n."); form.txtOcupacion.focus(); return; 

			}

			else i=i+1;

			if (form.txtDireccion.value == "")

  			{ 

				alert("Por favor ingrese el lugar de residencia."); form.txtDireccion.focus(); return; 

			}

			else i=i+1;
			
			if ((form.txtNpersonas.value < 0)|| (form.txtNpersonas.value== ""))

  			{ 

				alert("Por favor ingrese el numero de personas a cargo."); form.txtNpersonas.focus(); return; 

			}

			else i=i+1;
			
			if ((form.txtBarrio.value== ""))

  			{ 

				alert("Por favor ingrese el Barrio de su residencia."); form.txtBarrio.focus(); return; 

			}

			else i=i+1;

			if(i==8)

			{	

				if(confirm("Esta seguro de guardar los datos?"))

				{

						form.submit();

				}

			}

	}

	
//////////////////////////////////////
//Validar modulo de ingreso por formulario.

	function validar_servicio(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if (form.txtnomserv.value == "")

  			{ 

				alert("Por favor ingrese el nombre del servicio."); form.txtnomserv.focus(); return; 

			}

			else i=i+1;

			if (form.txtdesserv.value == "")

  			{ 

				alert("Por favor ingrese la descripcion  del servicio."); form.txtdesserv.focus(); return; 

			}

			else i=i+1;
			

			

			if(i=2)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}

	}

//Validar modulo de ingreso por formulario.

	function validar_auto(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if (form.txtauto.value == "")

  			{ 

				alert("Por favor ingrese el nombre del Vehiculo."); form.txtauto.focus(); return; 

			}

			else i=i+1;

						

			if(i=1)

			{	

				if(confirm("Esta seguro de realizar el registro del tipo de vehiculo?"))

				{

						form.submit();

				}

			}

	}
	
	//Validar modulo de ingreso por formulario.

	function validar_autoEdit(form)

	{
//alert('estoy');

		
			

			if (form.txtvh.value == "")

  			{ 

				alert("Por favor ingrese el nombre del Vehiculo."); form.txtvh.focus(); return; 

			}

			else i=i+1;

						

			if(i=1)

			{	

				if(confirm("Esta seguro de editar el tipo de vehiculo?"))

				{

						form.submit();

				}

			}

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Validar modulo de ingreso por formulario.

	function validardatos_cliente(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if (form.txtmatricula.value == "")

  			{ 

				alert("Por favor ingrese la matricula del vehiculo."); form.txtmatricula.focus(); return; 

			}

			else i=i+1;

			if (form.txtnombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre del cliente."); form.txtnombres.focus(); return; 

			}

			else i=i+1;

			if (form.txtapellidos.value == "")

  			{ 

				alert("Por favor ingrese el apellido del cliente."); form.txtapellidos.focus(); return; 

			}

			else i=i+1;

			
			if (form.txt_telefono.value == "")

  			{ 

				alert("Por favor ingrese el telefono del cliente."); form.txt_telefono.focus(); return; 

			}

			else i=i+1;
			if (form.txt_celular.value == "")

  			{ 

				alert("Por favor ingrese el celular del cliente."); form.txt_celular.focus(); return; 

			}

			else i=i+1;

			if (form.txt_email.value == "" )

  			{ 

				alert("Por favor ingrese el email del cliente."); form.txt_email.focus(); return; 

			}

			else i=i+1;

			if (form.txt_email.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email del cliente en la forma: nombre@servidor.dominio"); form.txt_email.focus(); return; 

			}

			else i=i+1;

			

			if(i=7)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}

	}

	
//Validar modulo de ingreso por formulario.

	function validar_valser(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if ((form.txttiempo.value == "") || (form.txttiempo.value ==0))

  			{ 

				alert("Por favor ingrese un valor valido de tiempo."); form.txttiempo.focus(); return; 

			}

			else i=i+1;
             if ((form.txtvalserv.value == "") || (form.txtvalserv.value ==0))

  			{ 

				alert("Por favor ingrese un valor valido para el servicio."); form.txtvalserv.focus(); return; 

			}

			else i=i+1;
			
			
			if(i=2)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}

	}


function validar_paquete(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if (form.txtnompaq.value == "")

  			{ 

				alert("Por favor ingrese el nombre del paquete."); form.txtnompaq.focus(); return; 

			}

			else i=i+1;

               if ((form.txtvalor.value == "")||(form.txtvalor.value <1))

  			{ 

				alert("Por favor ingrese el valor del paquete."); form.txtvalor.focus(); return; 

			}

			else i=i+1;
			
			

			

			if(i=2)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}

	}
//Validar modulo de ingreso por formulario.

	function validar_gasto(form)

	{
//alert('estoy');

		var dato;

		i=0;

			

			if (form.txtnomserv.value == "")

  			{ 

				alert("Por favor ingrese el nombre del gasto."); form.txtnomserv.focus(); return; 

			}

			else i=i+1;

			
			

			

			if(i=1)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}

	}
	
	//Validar modulo de ingreso por formulario.

	function validar_RegGas(form)

	{

	i=0;

	    if (form.txtGs.value == 0){ alert("Por favor seleccione el nombre del gasto."); form.txtGs.focus(); return; }
		else i=i+1;
		
		 if (form.txtSA.value == 0){ alert("Por favor seleccione el servicio para aplicar el gasto."); form.txtSA.focus(); return; }
		else i=i+1;
		
		if (form.txtcant.value <1){ alert("Por favor ingrese la cantidad del gasto."); form.txtcant.focus(); return; }
		else i=i+1;
		
		if (form.txtvalGas.value <1){ alert("Por favor ingrese el valor del gasto."); form.txtvalGas.focus(); return; }
		else i=i+1;
		
		if (form.txtTotal.value <1){ alert("No ha calculado correctamente el valor del gasto."); form.txtTotal.focus(); return; }
		else i=i+1;

			
			

			

			if(i==5)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}	

	}
	//Validar modulo de ingreso por formulario.

	function validar_RegDesc(form)

	{

	i=0;

	   	
		 if (form.txtSer.value <1){ alert("Por favor seleccione el servicio para aplicar el descuento."); form.txtSer.focus(); return; }
		else i=i+1;
		
			
		if (form.txtvalDes.value <1){ alert("Por favor ingrese el valor del descuento."); form.txtvalDes.focus(); return; }
		else i=i+1;
		
		
		if(i==2)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{
						
						form.submit();

				}

			}	

	}
	//Validar modulo de ingreso por formulario.

	function validar_RegServ(form)

	{

	i=0;

	    if (form.txtS.value == 0){ alert("Por favor seleccione el nombre del servicio."); form.txtS.focus(); return; }
		else i=i+1;
		
		if (form.txtcant.value <1){ alert("Por favor ingrese la cantidad del servicio."); form.txtcant.focus(); return; }
		else i=i+1;
		
		if (form.txtvalSer.value <1){ alert("Por favor ingrese el valor del servicio."); form.txtvalSer.focus(); return; }
		else i=i+1;
		
		if (form.txtTotal.value <1){ alert("No ha calculado correctamente el valor del servicio."); form.txtTotal.focus(); return; }
		else i=i+1;

			
			

			

			if(i=4)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}	

	}
	
	//Validar modulo de ingreso por formulario.

	function validar_RegGas(form)

	{

	i=0;

	    if (form.txtGs.value == 0){ alert("Por favor seleccione el nombre del gasto."); form.txtGs.focus(); return; }
		else i=i+1;
		
		 if (form.txtSA.value == 0){ alert("Por favor seleccione el servicio para aplicar el gasto."); form.txtSA.focus(); return; }
		else i=i+1;
		
		if (form.txtcant.value <1){ alert("Por favor ingrese la cantidad del gasto."); form.txtcant.focus(); return; }
		else i=i+1;
		
		if (form.txtvalGas.value <1){ alert("Por favor ingrese el valor del gasto."); form.txtvalGas.focus(); return; }
		else i=i+1;
		
		if (form.txtTotal.value <1){ alert("No ha calculado correctamente el valor del gasto."); form.txtTotal.focus(); return; }
		else i=i+1;

			
			

			

			if(i==5)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{

						form.submit();

				}

			}	

	}
	//Validar modulo de ingreso por formulario.

	function validar_RegDesc(form)

	{

	i=0;

	   	
		 if (form.txtSer.value <1){ alert("Por favor seleccione el servicio para aplicar el descuento."); form.txtSer.focus(); return; }
		else i=i+1;
		
			
		if (form.txtvalDes.value <1){ alert("Por favor ingrese el valor del descuento."); form.txtvalDes.focus(); return; }
		else i=i+1;
		
		
		if(i==2)

			{	

				if(confirm("Esta seguro de realizar el registro?"))

				{
						
						form.submit();

				}

			}	

	}
	//Validar modulo de ingreso por formulario.

	function valgas(form)

	{

	i=0;

	    if (form.txtGs.value == 0){ alert("Por favor seleccione el nombre del gasto."); form.txtGs.focus(); return; }
		else i=i+1;
		
		if (form.txtvalGas.value <1){ alert("Por favor ingrese la valor del gasto."); form.txtvalGas.focus(); return; }
		else i=i+1;
		
		
		
		if(i=2)	{ 
		  if(confirm("Esta seguro de realizar el registro?")){

						form.submit();
				}

			}	

	}
	
	//VALIDAR SERVICIOS

	function val_service(form)
  
	{
 
		var dato;

		i=0;

			if (form.txtprinserv.value ==0)

  			{ 

				alert("Por favor sleccione el grupo de servicios."); form.txtprinserv.focus(); return; 

			}

			else i=i+1;

			if (form.listServ.value ==0)

  			{ 

				alert("Por favor seleccion el  servicio."); form.listServ.focus(); return; 

			}

			else i=i+1;

			if (form.txtcantserv.value <1)

  			{ 

				alert("Por favor escriba la cantidad solicitada."); form.txtcantserv.focus(); return; 

			}

			else i=i+1;

						

			

			if(i=3)

			{	

				if(confirm("Esta seguro de procesar los datos del  servicio?"))

				{

						form.submit();

				}

			}

	}
//////////////////////////////////////////////////////////////////////////////////	
///////////////////////////////VALIDAR CLIENTE/////////////////////////////////7
///////////////////////////////////////////////////////////////////////////////////
	//Validar modulo de ingreso por aspirantes.

	function validardatos_cliente(form)
  
	{
 
		var dato;

		i=0;

			if (form.txtnombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre de la empresa."); form.txtnombres.focus(); return; 

			}

			else i=i+1;

		

			if (form.tipo_doc.value == "")

  			{ 

				alert("Por favor seleccione el Tipo de Documento."); form.tipo_doc.focus(); return; 

			}

			else i=i+1;

			if (form.txtdocumento.value == "")

  			{ 

				alert("Por favor ingrese el Nit."); form.txtdocumento.focus(); return; 

			}

			else i=i+1;

				

			if (form.txtdireccion.value == "")

  			{ 

				alert("Por favor ingrese la direccion."); form.txtdireccion.focus(); return; 

			}

			else i=i+1;

			if (form.txt_telefono.value == "")

  			{ 

				alert("Por favor ingrese el telefono de contacto."); form.txt_telefono.focus(); return; 

			}

			else i=i+1;

			if (form.txt_email.value == "")

  			{ 

				alert("Por favor ingrese el email."); form.txt_email.focus(); return; 

			}

			else i=i+1;

			if (form.txt_email.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email  en la forma: nombre@servidor.dominio"); form.txt_email.focus(); return; 

			}

			else i=i+1;

			

			

			if(i=7)

			{	

				if(confirm("Esta seguro de guardar los anteriores datos?"))

				{

						form.submit();

				}

			}

	}

//Validar modulo de ingreso por formulario.

	function validar_serv_hijo(form)

	{

	i=0;
	
	    if (form.txtprinserv.value == 0){ alert("Por favor seleccione el Tipo de servicio."); form.txtprinserv.focus(); return; }
		else i=i+1;

	    if (form.txtnomserv2.value == ""){ alert("Por favor escriba el nombre del servicio."); form.txtnomserv2.focus(); return; }
		else i=i+1;
		
		 if (form.txtdesserv2.value == ""){ alert("Por favor escriba la descripci�n del servicio."); form.txtdesserv2.focus(); return; }
		else i=i+1;
		
		if (form.txtvalserv.value <1){ alert("Por favor ingrese el valor del servicio por unidad."); form.txtvalserv.focus(); return; }
		else i=i+1;
		
		if (form.txtivaserv.value <1){ alert("Por favor ingrese el valor del impuesto."); form.txtivaserv.focus(); return; }
		else i=i+1;
		
		if (form.txtrealserv.value <1){ alert("No ha calculado correctamente el valor del servicio."); form.txtrealserv.focus(); return; }
		else i=i+1;

			if (form.txtprovserv.value ==0){ alert("Por favor seleccione le proveedor del servicio."); form.txtprovserv.focus(); return; }
		else i=i+1;
			

			

			if(i==7)

			{	

				if(confirm("Esta seguro de realizar el registro del servicio?"))

				{

						form.submit();

				}

			}	

	}
	
	//////////////////////////////////////////////////////


	function valcontrato(form)

	{

	i=0;

	    if (form.fecha0.value == 0){ alert("Por favor seleccione la fecha de inicio."); form.fecha0.focus(); return; }
		else i=i+1;
		
		if (form.fecha2.value <1){ alert("Por favor ingrese la fecha de final."); form.fecha2.focus(); return; }
		else i=i+1;
		
		if (form.fecha0.value>form.fecha2.value){ alert("La fecha de final no puede ser menor a la inicial."); form.fecha0.focus(); return; }
		else i=i+1;
		
		if (form.valtext.value <1){ alert("Por favor ingrese la valor del contrato."); form.valtext.focus(); return; }
		else i=i+1;
		
		
		if(i=2)	{ 
		  if(confirm("Esta seguro de realizar el registro?")){

						form.submit();
				}

			}	

	}
	
	function val_registro1(form,op)

	{
//alert('estoy');

		var i=0;
		var op1=op;
		
		    if (form.txtdocumento.value == ""){ alert("Por favor ingrese el numero del documento del empleado."); form.txtdocumento.focus(); return; }else i=i+1;
		
			if (form.txtcargo.value == ""){ alert("Por favor ingrese el cargo del empleado."); form.txtcargo.focus(); return; 	}else i=i+1;

			if (form.txtnombres.value == ""){ alert("Por favor ingrese el nombre del empleado."); form.txtnombres.focus(); return; }else i=i+1;
		
			if (form.txtDireccion.value == ""){ alert("Por favor ingrese el lugar de residencia."); form.txtDireccion.focus(); return;}	else i=i+1;
			
			if ((form.txtTelefono.value== "")){ alert("Por favor ingrese el Numero de telefono de contacto."); form.txtTelefono.focus(); return; }else i=i+1;
			
			if ((form.txtCel.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtCel.focus(); return; }	else i=i+1;

			if(i==6){if(confirm("Esta seguro de guardar los datos?")){
				
				var doc=form.txtdocumento.value;
				var cr=form.txtcargo.value;
				var nom=form.txtnombres.value;
				var dir=form.txtDireccion.value;
				var tel=form.txtTelefono.value;
				var cel=form.txtCel.value;
				//var op1=1;
				if(op1==1){
				var param=doc+ '-' +cr+ '-' +nom+ '-' +dir+ '-' +tel+ '-' +cel+ '-' +op1;
				grupoFocus('menu/clientes/php/guardar_empleado.php?param='+param, 'DivContenido', 'carga', '', 'menu/testx/continuar.php?doc='+doc, 'DivContenido', '')
				}else{
				var param=doc+ '-' +cr+ '-' +nom+ '-' +dir+ '-' +tel+ '-' +cel+ '-' +op1;
				grupoFocus('menu/clientes/php/guardar_empleado.php?param='+param, 'DivContenido', 'carga', '', 'menu/testx/windexFin.php', 'DivContenido', '')
					
				}
				
				}}

	}

	
//////////////////////////////////////
function val_registro(form)

	{
//alert('estoy');

		var i=0;
		
		    if (form.txtdocumento.value == ""){ alert("Por favor ingrese el numero del documento del empleado."); form.txtdocumento.focus(); return; }else i=i+1;
		
			if (form.txtcargo.value == ""){ alert("Por favor ingrese el cargo del empleado."); form.txtcargo.focus(); return; 	}else i=i+1;

			if (form.txtnombres.value == ""){ alert("Por favor ingrese el nombre del empleado."); form.txtnombres.focus(); return; }else i=i+1;
		
			if (form.txtDireccion.value == ""){ alert("Por favor ingrese el lugar de residencia."); form.txtDireccion.focus(); return;}	else i=i+1;
			
			if ((form.txtTelefono.value== "")){ alert("Por favor ingrese el Numero de telefono de contacto."); form.txtTelefono.focus(); return; }else i=i+1;
			
			if ((form.txtCel.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtCel.focus(); return; }	else i=i+1;

			if(i==6){if(confirm("Esta seguro de guardar los datos?")){
					form.submit();
				
				
				}}

	}
	
	//////////////////////////////////////
function val_club(form)

	{

var i=0;
		
		    if (form.txtNomclub.value == ""){ alert("Por favor ingrese el nombre del club."); form.txtNomclub.focus(); return; }else i=i+1;
		
			if (form.Barrio.value == ""){ alert("Por favor seleccione el barrio."); form.Barrio.focus(); return; 	}else i=i+1;

			if (form.txtdireccion.value == ""){ alert("Por favor ingrese el lugar de funcionamiento."); form.txtdireccion.focus(); return; }else i=i+1;
			///////////////////////////////////////////////////////////////////
		
			if (form.txtCorreo.value == "")

  			{ 

				alert("Por favor ingrese el email."); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			if (form.txtCorreo.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email  en la forma: nombre@servidor.dominio"); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			

			
			////////////////////////////////////////////////////////////////////
			
			
			if ((form.txtresponsable.value== "")){ alert("Por favor ingrese el nombre del representante."); form.txtresponsable.focus(); return; }else i=i+1;
			
			if ((form.txtcelular1.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtcelular1.focus(); return; }	else i=i+1;
			
			if ((form.txtEntrenador.value== "")){ alert("Por favor ingrese el nombre del entrenador."); form.txtEntrenador.focus(); return; }else i=i+1;
			
			if ((form.txtCelular2.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtCelular2.focus(); return; }	else i=i+1;

			if(i==9){if(confirm("Esta seguro de guardar los datos?")){
					form.submit();
				
				
				}}

	}
	
	
	/////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////
function val_invitado(form)

	{


    
	
var i=0;
var nom=form.txtNomclub.value;
var dir=form.txtdireccion.value;
var correo=form.txtCorreo.value;
var resp=form.txtresponsable.value;
var cel1=form.txtcelular1.value;
var entre=form.txtEntrenador.value;
var cel2=form.txtCelular2.value;
		
		    if (form.txtNomclub.value == ""){ alert("Por favor ingrese el nombre del club."); form.txtNomclub.focus(); return; }else i=i+1;
		
			

			if (form.txtdireccion.value == ""){ alert("Por favor ingrese el lugar de funcionamiento."); form.txtdireccion.focus(); return; }else i=i+1;
			///////////////////////////////////////////////////////////////////
		
			if (form.txtCorreo.value == "")

  			{ 

				alert("Por favor ingrese el email."); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			if (form.txtCorreo.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email  en la forma: nombre@servidor.dominio"); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			

			
			////////////////////////////////////////////////////////////////////
			
			
			if ((form.txtresponsable.value== "")){ alert("Por favor ingrese el nombre del representante."); form.txtresponsable.focus(); return; }else i=i+1;
			
			if ((form.txtcelular1.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtcelular1.focus(); return; }	else i=i+1;
			
			if ((form.txtEntrenador.value== "")){ alert("Por favor ingrese el nombre del entrenador."); form.txtEntrenador.focus(); return; }else i=i+1;
			
			if ((form.txtCelular2.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtCelular2.focus(); return; }	else i=i+1;

			if(i==8){if(confirm("Esta seguro de guardar los datos registrados?")){
				
			relocate('dam/modDam/mod_registro/ejec/RclubApp.php',{'nom':nom,'dir':dir,'correo':correo,'resp':resp,'cel1':cel1,'entre':entre,'cel2':cel2});
			
					//form.submit();
				
				
				}}

	}
	
	
	/////////////////////////////////////////////////////////////////////
	
	
	
	//Validar modulo de ingreso por formulario.

	function val_dep(form)

	{

		var dato;

		i=0;

			if (form.TipoDocumento.value == "")

  			{ 

				alert("Por favor seleccione el tipo de documento del(la) deportista."); form.TipoDocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtDocumento.value == "")

  			{ 

				alert("Por favor ingrese el numero del documento del(la) deportista."); form.txtDocumento.focus(); return; 

			}

			else i=i+1;

			if (form.txtNombres.value == "")

  			{ 

				alert("Por favor ingrese el nombre del(la) deportista."); form.txtNombres.focus(); return; 

			}

			else i=i+1;

			if (form.txtApellidos.value == "")

  			{ 

				alert("Por favor ingrese el apellido del(la) deportista."); form.txtApellidos.focus(); return; 

			}

			else i=i+1;

			
			

			if(i=4)

			{	

				if(confirm("Esta seguro de registrar el(la) deportista?"))

				{

						form.submit();

				}

			}

	}

	//Validar modulo de ingreso por formulario.

	function valRegApp(form)

	{
		
		
		var dato;
              
		i=0;

			
		 ////////////////////////////////////////////////////////////////////

		 var miCampoTexto = document.getElementById('txtEmail').value;
		 //la condici�n
		 if(miCampoTexto.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
			 alert("Por favor ingrese el correo correctamente del registro.");
			 document.getElementById('txtEmail').focus();
			 return false;
		 }else{
			 i=i+1;
			
		  }
		  ///////////////////////////////////////////////////////////////
		  var miCampoTexto = document.getElementById('txtDocumento').value;
		  //la condici�n
		  if(miCampoTexto.length == 0){
			  alert("Por favor ingrese el documento del(la) socio(a).");
			  document.getElementById('txtDocumento').focus();
			  return false;
		  }else{
			  i=i+1;
			 
		   }
		   ///////////////////////////////////////////////////////////////
	  
			  var miCampoTexto = document.getElementById('txtNombres').value;
		  //la condici�n
		  if(miCampoTexto.length == 0){
			  alert("Por favor ingrese el nombre del(la) socio(a).");
			  document.getElementById('txtNombres').focus();
			  return false;
		  }else{
			  i=i+1;
			 
		   }
		  ////////////////////////////////////////////////////////////////////
			  var miCampoTexto = document.getElementById('txtApellidos').value;
		  //la condici�n
		  if(miCampoTexto.length == 0){
			  alert("Por favor ingrese los apellidos del(la) socio(a).");
			  document.getElementById('txtApellidos').focus();
			  return false;
		  }else{
			  i=i+1;
			 
		   }
  
		    ////////////////////////////////////////////////////////////////////	
			 var miCampoTexto = document.getElementById('txtCelular').value;
             //la condici�n
             if(miCampoTexto.length == 0){
                 alert("Por favor ingrese el telefono del(la) socio(a).");
                 document.getElementById('txtCelular').focus();
                 return false;
             }else{
                 i=i+1;
                
              }
             ////////////////////////////////////////////////////////////////////

			
			

			 if(i!=0)

                {	
    
                    if(confirm("Proceder a hacer el registro?"))
    
                    {
    
                            form.submit();
                            
    
                    }

			}

	}


//////////////////////////////////////

//////////////////////////////////////
function v_club_mt(form)

	{

var i=0;
		
		    if (form.txtNomclub.value == ""){ alert("Por favor ingrese el nombre del club."); form.txtNomclub.focus(); return; }else i=i+1;
		
			if (form.txtdireccion.value == ""){ alert("Por favor ingrese el lugar de funcionamiento."); form.txtdireccion.focus(); return; }else i=i+1;
			///////////////////////////////////////////////////////////////////
		
			if (form.txtCorreo.value == "")

  			{ 

				alert("Por favor ingrese el email."); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			if (form.txtCorreo.value.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig))

  			{ 

				alert("Por favor ingrese el email  en la forma: nombre@servidor.dominio"); form.txtCorreo.focus(); return; 

			}

			else i=i+1;

			

			
			////////////////////////////////////////////////////////////////////
			
			
			if ((form.txtresponsable.value== "")){ alert("Por favor ingrese el nombre del representante."); form.txtresponsable.focus(); return; }else i=i+1;
			
			if ((form.txtcelular1.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtcelular1.focus(); return; }	else i=i+1;
			
			if ((form.txtEntrenador.value== "")){ alert("Por favor ingrese el nombre del entrenador."); form.txtEntrenador.focus(); return; }else i=i+1;
			
			if ((form.txtCelular2.value== "")){ alert("Por favor ingrese el Numero de celular de contacto."); form.txtCelular2.focus(); return; }	else i=i+1;

			if(i==8){if(confirm("Esta seguro de guardar los datos?")){
					form.submit();
				
				
				}}

	}
	
	
	//////////////////validaciones del evento////////////////////////////////
	
	//////////////////////////////////////
	function validardatos_evento(){ 

//valido el documento. tiene que ser entero largo  

  	cat =parseInt(document.frmNevento.categorias.value);

	tit = document.frmNevento.txttitulo.value;
	
	tde = document.frmNevento.txtdes.value;

  	//document.niv_academico.txtnivelA.value=docu ;

   	if (cat == 0){ 

     	 alert("Debe seleccionar la categoria para el evento.");

      	 document.frmNevento.categorias.focus();

     	 return 0; 

	}else{

		if(tit==""){

			alert("Los eventos deben tener un titulo para identificarlos.");

      	 document.frmNevento.txttitulo.focus();

     	 return 0;
		 
	}else{

		if(tde==""){

			alert("La descripcion es importante como informacion del evento.");

      	 document.frmNevento.txtdes.focus();

     	 return 0;

   	}  	

	}
	}

   	document.frmNevento.submit(); 

} 
////////////////////////////////////////////////////////////////////////////////////////
function valBloque1_evento(form){ 

	//valido el documento. tiene que ser entero largo  
	var forma=form;
	alert(`Entrando a...${forma}`);

	//$(document).ready(function() {
	//	$('#btnDatos').click(function() {
		  // defines un arreglo
		  var selected = [];
		  $(":checkbox[name=criterio_combate]").each(function() {
			if (this.checked) {
			  // agregas cada elemento.
			  selected.push($(this).val());
			}
		  });
		  if (selected.length) {
			alert(JSON.stringify(selected));
			$.ajax({
			  cache: false,
			  type: 'post',
			  dataType: 'json', // importante para que 
			  data: selected, // jQuery convierta el array a JSON
			  //url: 'ejec/modBloque1.php',
			  success: function(data) {
				alert('datos enviados');
			  }
			});
	  
			// esto es solo para demostrar el json,
			// con fines didacticos
			alert(JSON.stringify(selected));
			document.frmBloque1.submit(); 
			alert('you');
		  } else{
			alert('Debes seleccionar al menos una opción.');
	  
			return false;
		  }
			
		

		 
	//alert(document.frmBloque1.individual.checked);
		 // var isChecked = document.forma.individual.checked;
		 
		/*
		var indi = document.getElementById('individual').checked;
		var tk3 = document.getElementById('tk3').checked;
		var tk5 = document.getElementById('tk5').checked;
		var m1 = document.getElementById('masculino1').checked;
		var m2 = document.getElementById('masculino2').checked;
		var m3 = document.getElementById('masculino3').checked;
		var f1 = document.getElementById('femenino1').checked;
		var f2 = document.getElementById('femenino2').checked;
		var f3 = document.getElementById('femenino3').checked;
		//alert(indi);
		  //alert(`variable ..${indi}`);
		/*if(indi){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(tk3){
			//alert('SI esta seleccionado');
  			}else{
	 		// alert('NOT  esta seleccionado');
  		}
		if(tk5){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(m1){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(m2){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(m3){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(f1){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(f2){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		if(f3){
 				// alert('SI esta seleccionado');
		}else{
			//alert('NOT  esta seleccionado');
		}
		

		/*tit = document.frmNevento.txttitulo.value;
		
		tde = document.frmNevento.txtdes.value;
	
		  //document.niv_academico.txtnivelA.value=docu ;
	
		   if (cat == 0){ 
	
			  alert("Debe seleccionar la categoria para el evento.");
	
			   document.frmNevento.categorias.focus();
	
			  return 0; 
	
		}else{
	
			if(tit==""){
	
				alert("Los eventos deben tener un titulo para identificarlos.");
	
			   document.frmNevento.txttitulo.focus();
	
			  return 0;
			 
		}else{
	
			if(tde==""){
	
				alert("La descripcion es importante como informacion del evento.");
	
			   document.frmNevento.txtdes.focus();
	
			  return 0;
	
		   }  	
	
		}
		}
	*/
	alert('paso');
		  document.frmBloque1.submit(); 
	
	} 
	
	////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

//Validar modulo de ingreso por formulario.

	function valid_PagoMes(form)

	{


		i=0;
		
       var miCampoTexto = document.getElementById('txtVpago').value;
        //la condici�n
        if(miCampoTexto.length == 0){
			alert("Por favor ingrese el valor a registrar del socio/deportista.");
			document.getElementById('txtVpago').focus();
            return false;
        }else{
		    i=i+1;
           
         }
		 ///////////////////////////////////////////////////////////////
	
			
        ////////////////////////////////////////////////////////////////////
			

			

			if(i!=0)

			{	

				if(confirm("Esta seguro de registrar el PAGO?"))

				{

						form.submit();
						

				}

			}

	}

	//////////////////////////////////////
function val_Cmes(form)

{

var i=0;
	
		if (form.valmes.value == ""){ alert("Por favor ingrese el valor del mes."); form.valmes.focus(); return; }else i=i+1;
	
		if (form.valclase.value == ""){ alert("Por favor ingrese el valor de la clase."); form.valclase.focus(); return; 	}else i=i+1;

		if (form.maximo.value == ""){ alert("Por favor ingrese el número de días."); form.maximo.focus(); return; }else i=i+1;
		
		if (form.valextra.value == ""){ alert("Por favor ingrese el valor extraordinario de incremento."); form.valextra.focus(); return; }else i=i+1;
		
		///////////////////////////////////////////////////////////////////
	
		
		if(i==4){if(confirm("Esta seguro de guardar los datos?")){
				form.submit();
			
			
			}}

}



//////////////////////////////////////
function valFrmU(form)

{

var i=0;
	
		if (form.txtuser.value == ""){ alert("Por favor ingrese el nombre de usuario."); form.txtuser.focus(); return; }else i=i+1;
	
		if (form.txtclave.value == ""){ alert("Por favor ingrese el acceso de usuario."); form.txtclave.focus(); return; 	}else i=i+1;

		
		///////////////////////////////////////////////////////////////////
	
		
		if(i==2){if(confirm("Esta seguro de generar el usuario para el evento?")){
				form.submit();
			
			
			}}

}
/////////////////////////////////////////////////////////////////////

//////////////////////////////////////
function valLstGrd()

{

//document.form.Grados.value
var i=0;
		if (document.frmAsigGrd.selGrados.value == 0){
			 alert("Por favor seleccione un grado valido."); document.frmAsigGrd.selGrados.focus(); return; 
			}else {
				i=1;
			}
			
	
		
		///////////////////////////////////////////////////////////////////
	
		
		if(i==1){if(confirm("Esta seguro de asignar el grado?")){
			frmAsigGrd.submit();
			
			
			}}

}
/////////////////////////////////////////////////////////////////////

// Función de validación para el formulario completo de socios
function valSocioFull(form) {
    var i = 0;
    
    // Validar nombres
    var nombres = document.getElementById('txtNombres').value;
    if(nombres.length == 0){
        alert("Por favor ingrese el nombre del(la) socio(a).");
        document.getElementById('txtNombres').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar apellidos
    var apellidos = document.getElementById('txtApellidos').value;
    if(apellidos.length == 0){
        alert("Por favor ingrese los apellidos del(la) socio(a).");
        document.getElementById('txtApellidos').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar documento
    var documento = document.getElementById('txtDocumento').value;
    if(documento.length == 0){
        alert("Por favor ingrese el documento del(la) socio(a).");
        document.getElementById('txtDocumento').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar email
    var email = document.getElementById('txtEmail').value;
    if(email.search(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ig)){
        alert("Por favor ingrese el correo correctamente del registro.");
        document.getElementById('txtEmail').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar barrio
    var barrio = document.getElementById('Barrio').value;
    if(barrio.length == 0){
        alert("Por favor ingrese el barrio del(la) socio(a).");
        document.getElementById('Barrio').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar dirección
    var direccion = document.getElementById('txtDireccion').value;
    if(direccion.length == 0){
        alert("Por favor ingrese la dirección del(la) socio(a).");
        document.getElementById('txtDireccion').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar EPS
    var eps = document.getElementById('txtSalud').value;
    if(eps.length == 0){
        alert("Por favor ingrese la EPS del(la) socio(a).");
        document.getElementById('txtSalud').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar celular
    var celular = document.getElementById('txtCelular').value;
    if(celular.length == 0){
        alert("Por favor ingrese el teléfono del(la) socio(a).");
        document.getElementById('txtCelular').focus();
        return false;
    } else {
        i = i + 1;
    }
    
    // Validar que se haya seleccionado tipo de socio
    var opSocio = document.querySelector('input[name="OpSocio"]:checked');
    if(!opSocio){
        alert("Por favor seleccione el tipo de socio.");
        return false;
    } else {
        i = i + 1;
    }
    
    // Si todas las validaciones pasaron


 if(i!=0)

                {	
    
                    if(confirm("¿Proceder a hacer el registro completo?")) 
    
                    {
    
                            form.submit();
                            
    
                    }

			}

    
}
/////////////////////////////////////////////////////////////////////