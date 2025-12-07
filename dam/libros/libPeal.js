
// JavaScript funciones ajax

var txtIndica="";
var ano_mat ="2000"; //Variable usada en el proceso de generar matricula.
// creando objeto XMLHttpRequest de Ajax
var obXHR;
try {
	obXHR=new XMLHttpRequest();
} catch(err) {
	try {
		obXHR=new ActiveXObject("Msxml2.XMLHTTP");
	} catch(err) {
		try {
			obXHR=new ActiveXObject("Microsoft.XMLHTTP");
		} catch(err) {
			obXHR=false;
		}
	}
}

// creando objeto XMLHttpRequest de Ajax
var obXHR2;
try {
	obXHR2=new XMLHttpRequest();
} catch(err) {
	try {
		obXHR2=new ActiveXObject("Msxml2.XMLHTTP");
	} catch(err) {
		try {
			obXHR2=new ActiveXObject("Microsoft.XMLHTTP");
		} catch(err) {
			obXHR2=false;
		}
	}
}// INICIO ENVIO DE UN CHECKBOX

function cargarPOST(url, urlreturn, divinfo, divreload, foco) {
	
	url=url+"&q=getinfo"+GetInfoStringN();
	
	mostrar(divreload);
		
	obXHR.open("GET", url, true);
	
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			alert(obXHR.responseText);
			ocultar(divreload);
			cargarFocus(urlreturn,divinfo,divreload, foco);
		}
	}
	
	obXHR.send(null);
}

	function GetInfoString(){
		
		//===================================================================================================================
	    // PROBLEMA SOLUCIONADO PARA EL FUNCIONAMIENTO EN TODOS LOS BROWSER...BUENO AL MENOS ESTA PROBADO EN CHROME Y MOZILA 
	    //===================================================================================================================
	 var sData="";
	 var Nform=document.forms[2].name;
	 var iCount = document.getElementById(Nform).idAsA;
	   var cont = 0;
   
         for (var x=0; x < iCount.length; x++) {
			
             if (iCount[x].checked) {
             cont = cont + 1;
			 sData += "&idAsA[]=" + document.forms[2].idAsA[x].value;
             }
         }
     
		return sData;
	}	
	
	function GetInfoStringN(){
		
	    var sData="";
        var iCount =0;

        iCount = myform.elements.namedItem("idAsA").length;
        if(iCount>>0){
	        for(i=0;i<iCount;i++){
	            //===========================================================================
	            // This Logic Is Compatible With IE browser but most not compatible for Other 
	            //===========================================================================
	            //if (myform.elements.namedItem("chkinfo[]","")(i).checked){
	            //sData += "&chkinfo[]=" +  myform.elements.namedItem("chkinfo[]","")(i).value;
	            //}
	            
	            //==============================================================
	            //Replace With This New Logic:  has been Tested In IE And Chrome
	            //==============================================================
	            if (myform.idAsA[i].checked) {
	                sData += "&idAsA[]=" + myform.idAsA[i].value;
	            }
	        }
	    }         
	    
		return sData;
	}
	
	function cargarVentanaReport(url, divinfo, divreload, ventana, divtitulo, txttitulo, idRedimencion, width, height, foco) {
	
		var obDiv = document.getElementById(divinfo);
	
		mostrar(divreload);
		
		url=url+GetInfoString2();
		
		//alert(url);
	
		obXHR.open("GET", url);
		obXHR.onreadystatechange = function() {
			if (obXHR.readyState == 4 && obXHR.status == 200) {
			
				obDiv.innerHTML=obXHR.responseText;
			
				ocultar(divreload);
				
				ubicoVentana(ventana, idRedimencion, width, height);
			
				divMsg(divtitulo,txttitulo);
						
				mostrar(ventana);
			
				document.getElementById(foco).focus();
			}
		}
		obXHR.send(null);
	}


	function GetInfoString2(){
		
	var sData="";
        var iCount =0;

        iCount = myform.elements.namedItem("idAsA").length;
        if(iCount>>0){
	        for(i=0;i<iCount;i++){
	            //===========================================================================
	            // This Logic Is Compatible With IE browser but most not compatible for Other 
	            //===========================================================================
	            //if (myform.elements.namedItem("chkinfo[]","")(i).checked){
	            //sData += "&chkinfo[]=" +  myform.elements.namedItem("chkinfo[]","")(i).value;
	            //}
	            
	            //==============================================================
	            //Replace With This New Logic:  has been Tested In IE And Chrome
	            //==============================================================
	            if (myform.idAsA[i].checked) {
					if(sData==''){
	                	sData += "idAsA=" + myform.idAsA[i].value;
					}else{
						sData += '-' + myform.idAsA[i].value;
					}
	            }
	        }
	    }         
	    
		return sData;
	}
	
//FINAL ENVIO DE UN CHECKBOX


//INICIO ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

function EnviarLista(url,idform, nlib, idcheck, divreload,idsocio, urlreturn ,divinfo,divreload,foco){
	if( ! confirm('Seguro desea validar el(los) aspirante(s) selecciondo(s) ?') ){
		return false;
	}
	val=0;
	
	codlibr=0;
	libranzas ='';
	soccios ='';
	num=0;
	obj = document.getElementById(idcheck);
	
	 document.getElementById(idcheck);
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(libranzas==''){
				libranzas = ele.value;
				socios = document.getElementById(idsocio+ele.value).value;
				if(document.getElementById(idsocio+ele.value).value == ''){val++ ; codlibr=ele.value;} 
				
			}else{
				libranzas += '-'+ele.value;
				socios += '-'+document.getElementById(idsocio+ele.value).value;  
				if(document.getElementById(idsocio+ele.value).value == '') {val++ ; codlibr=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado aspirantes.');
		return false;
	}
	
	if( val != 0 ){
		alert('En el aspirante de id= '+codlibr+', digite el codigo correspondiente.');
		document.getElementById(idsocio+codlibr).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+libranzas+'&id_alumno='+socios+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT
////////////////////////////////////////////////añadi/////////////////////////////////////

function EnviarListaCarga(url, idform, nlib, idcheck, divreload, nhoras, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar la carga seleccionda ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	num=0;
	obj = document.getElementById(idcheck);
	      //document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				numhoras=document.getElementById(nhoras+ele.value).value;
				
				if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				numhoras += '-'+document.getElementById(nhoras+ele.value).value;  
				
				if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado asignaturas.');
		return false;
	}
	
	if( val != 0 ){
		alert('En la asignatura de Codigo= '+codasig+', digite el numero de horas correspondiente.');
		document.getElementById(nhoras+codasig).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&nhoras='+numhoras+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

//////////////////////////////////////////////////////////////////////////////////////////
//INICIO ENVIO varios OBJETOs  INPUT

function EnviarListaCalifica(url,idform, nlib, idcheck, divreload, idcheck, idconcepto, idnotanum, idasistencia, urlreturn ,divinfo,divreload,foco){
	if( ! confirm('Seguro desea procesar el conjunto de datos ?') ){
		return false;
	}
	val=0;
	val2=0;
	val3=0;
	
	codlibr=0;
	notlibr=0;
	asilibr=0;
	libranzas ='';
	concepto ='';
	notanum='';
	asistencia='';
	
	num=0;
	obj = document.getElementById(idcheck);
	
	 document.getElementById(idcheck);
	 
	 //alert('Libranza='+ idcheck);
	 
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(libranzas==''){
				libranzas = ele.value;
				concepto = document.getElementById(idconcepto+ele.value).value;
				if(document.getElementById(idconcepto+ele.value).value == ''){val++ ; codlibr=ele.value;} 
				
				notanum = document.getElementById(idnotanum+ele.value).value;
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 

				asistencia = document.getElementById(idasistencia+ele.value).value;
				if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 


								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);
				
			}else{
				
				libranzas += '-'+ele.value;
				
				concepto += '-'+document.getElementById(idconcepto+ele.value).value;  
				if(document.getElementById(idconcepto+ele.value).value == '') {val++ ; codlibr=ele.value;}
				
				notanum += '-'+document.getElementById(idnotanum+ele.value).value;  
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 


				asistencia += '-'+document.getElementById(idasistencia+ele.value).value;  
				if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 
				
								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);

			}
				
			num++;
	  }
	}
	
	
	//alert('Paso 0');
	
	if( num==0 ){
		alert('Usted no ha seleccionado aspirantes.');
		return false;
	}
	
	
	if( val != 0 ){
		alert('En el estudiante de id= '+codlibr+', digite el concepto correspondiente.');
		document.getElementById(idconcepto+codlibr).focus();
		return false;
	}else{
		
			if( val2 != 0 ){
				alert('En el estudiante de id= '+notlibr+', digite la nota correspondiente.');
				document.getElementById(idnotanum+notlibr).focus();
				return false;
			}else{
	
					if( val3 != 0 ){
						alert('En el estudiante de id= '+asilibr+', digite la asistencia correspondiente.');
						document.getElementById(idasistencia+asilibr).focus();
						return false;
					}			
		
				}

		}

	//alert('Paso 1');
	mostrar(divreload);
	//alert('Paso 2');
	cadenaFormulario= 'idAsA='+libranzas+'&idconcepto='+concepto+'&notanum='+notanum+'&asistencia='+asistencia+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

function cargarLink(url,urlreturn,divinfo,divreload, foco) {
		
	
	mostrar(divreload);
		
	obXHR.open("GET", url, true);
	
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			alert(obXHR.responseText);
			ocultar(divreload);
			cargarFocus(urlreturn,divinfo,divreload, foco);
		}
	}
	obXHR.send(null);
}


function cargarB(url,divinfo) {
	
	var obDiv = document.getElementById(divinfo);
	
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
		}
	}
	obXHR.send(null);
}

function cargarFocus(url, divinfo, divreload, foco) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
		
	}
	obXHR.send(null);
}






function cargarFocusIFrame(url,divinfo,divreload, foco) {
	
	var obDiv = document.getElementById(divinfo);
	
	parent.document.getElementById(divreload).style.visibility='visible';//mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			parent.document.getElementById(divreload).style.visibility='hidden';//ocultar(divreload);
			document.getElementById(foco).focus();
		}
	}
	obXHR.send(null);
}


function cargar(url,divinfo,divreload) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
		}
	}
	obXHR.send(null);
}

function cargarVentana(url, divinfo, divreload, ventana, divtitulo, txttitulo, idRedimencion, width, height, foco) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			
			obDiv.innerHTML=obXHR.responseText;
			
			ocultar(divreload);
			
			ubicoVentana(ventana, idRedimencion, width, height);
			
			divMsg(divtitulo,txttitulo);
						
			mostrar(ventana);
			
			document.getElementById(foco).focus();
		}
	}
	obXHR.send(null);
}


function ubicoVentana(ventana, idRedimencion, width, height){		
	
	document.getElementById(idRedimencion).style.width = ((width))+'px';
	document.getElementById(idRedimencion).style.height = ((height))+'px';

	document.getElementById(ventana).style.left = ((document.width-width)/2)+'px';
	document.getElementById(ventana).style.top = ((document.height-height)/2)+'px';
	
}


function cargarS(url,dato,divinfo,divreload) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url+dato);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
		}
	}
	obXHR.send(null);
}

function cargarInput(url,divinfo,divreload) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.value=obXHR.responseText;
			ocultar(divreload);
		}
	}
	obXHR.send(null);
}

function cargarInputFocus(url,divinfo,divreload, foco) {
	
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.value=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
	}
	obXHR.send(null);
}

function limpiarDiv(div){
document.getElementById(div).innerHTML="";
}
function mostrar(div){
document.getElementById(div).style.visibility="visible";
}
function ocultar(div){
document.getElementById(div).style.visibility="hidden";
} 

function divMsg(div,msg){
document.getElementById(div).innerHTML=msg;
} 

function divIco(div,url){
document.getElementById(div).innerHTML=url;
} 

function eventIgualar(idObjetoD,dato){
document.getElementById(idObjetoD).value=dato;
}

// En uso de checkbox
 function mostrar_obj(obj1, obj2){
 	//var cambiapsw = document.getElementsByName(obj1);
 	var ObjActivo = document.getElementById(obj2);
 	if(obj1.checked){
		ObjActivo.disabled = false;
		ObjActivo.focus();
	}else{
		ObjActivo.disabled= true;
	}
 }


//****************************************************************//
// Funcion para seleccionar todos los checkbox.					  //
//****************************************************************//
function seleccionar_todo(form){
	var Formulario = document.getElementById(form);
	for (i=0;i<Formulario.elements.length;i++)
		if(Formulario.elements[i].type == "checkbox")	
			Formulario.elements[i].checked=1
}
function deseleccionar_todo(form){
	var Formulario = document.getElementById(form);
	for (i=0;i<Formulario.elements.length;i++)
		if(Formulario.elements[i].type == "checkbox")	
			Formulario.elements[i].checked=0
}


//****************************************************************//
// Funcion para enviar la informacion de un formulario completo.
//****************************************************************//

function enviarFormulario(url, formid, redir, url_redir, loading, divContent, foco){
		//alert('aqui js');
		//ocultar('apDivVentana');
		mostrar(loading);
		
         
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         
		 var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
}
  obXHR.open("POST", url, true);
 
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
		ocultar(loading);
		//document.getElementById('apDivCuerpo').innerHTML=obXHR.responseText;
		alert(obXHR.responseText);
		
		Formulario.reset();
		
		if(redir==1){
			
			cargarFocus(url_redir,divContent,loading, foco);
		
		}
		
		//cargar(recarga);
	}
}
obXHR.send(cadenaFormulario);
}
// FUNCION ENVIAR FORMULARIO PARA EL REGISTRO DE CATEDRA EDUCATIVA Y LA GENERACION DE RECIBO
function enviarFormularioImprimeRec(url, formid, redir, url_redir, url_recibo, loading, divContent, foco, foco_rec, titulo){
		
		//ocultar('apDivVentana');
		mostrar(loading);
        
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         	cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         	sepCampos="&";
		 }
  obXHR.open("POST", url, true);
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
		ocultar(loading);
		//document.getElementById('apDivCuerpo').innerHTML=obXHR.responseText;
		//alert(obXHR.responseText);
		Formulario.reset();
		
		if(obXHR.responseText != 0){
			
			if(confirm(titulo+' Desea imprimir el recibo?')){
			
				cargarVentanaRecibos('modulos/corpofinanciero/iframe.php?idPer='+obXHR.responseText+'&h=500&url='+url_recibo+'?', 'apDivCuerpoVentana', loading, 'apDivVentana', 'apDivBarraTitulo', titulo, 'TblVentana', 800, 500, foco);
				
				//ocultar('apDivVentana');
				
			}
			
		}else{
			
			alert('El abono por catedra educativa no pudo ser registrado.');
			
			}
			
		if(redir==1){
			
			//cargarFocus(url_redir,divContent,loading, foco);
		
		}
		
		//cargar(recarga);
	}
}
obXHR.send(cadenaFormulario);
}

/**********************************************************************/
	function cargarVentanaRecibos(url, divinfo, divreload, ventana, divtitulo, txttitulo, idRedimencion, width, height, foco) {
	
		var obDiv = document.getElementById(divinfo);
	
		mostrar(divreload);
		
		//url=url+GetInfoString2();
		
		//alert(url);
	
		obXHR.open("GET", url);
		obXHR.onreadystatechange = function() {
			if (obXHR.readyState == 4 && obXHR.status == 200) {
			
				obDiv.innerHTML=obXHR.responseText;
			
				ocultar(divreload);
				
				ubicoVentana(ventana, idRedimencion, width, height);
			
				divMsg(divtitulo,txttitulo);
						
				//mostrar(ventana);
			
				document.getElementById(foco).focus();
			}
		}
		obXHR.send(null);
	}
/**********************************************************************/

// FIN DE LA FUNCION ENVIAR FORMULARIO PARA EL REGISTRO DE CATEDRA EDUCATIVA Y LA GENERACION DE RECIBO

function enviarFormularioIFrame(url, formid, redir, url_redir, loading, divContent, foco){
		
		//ocultar('apDivVentana');
		parent.document.getElementById(loading).style.visibility='visible';//mostrar(loading);
        
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
}
  obXHR.open("POST", url, true);
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
		parent.document.getElementById(loading).style.visibility='hidden';//ocultar(loading);
		//document.getElementById('apDivCuerpo').innerHTML=obXHR.responseText;
		alert(obXHR.responseText);
		Formulario.reset();
		
		if(redir==1){
			
			cargarFocusIFrame(url_redir,divContent,loading, foco);
		
		}
		
		//cargar(recarga);
	}
}
obXHR.send(cadenaFormulario);
}


function enviarFormularioPOST(url, formid, redir, url_redir, loading, divContent, foco){
		//alert('aqui j2s');
		//ocultar('apDivVentana');
		mostrar(loading);
        
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
}

	url=url+"&q=getinfo"+GetInfoString();

  obXHR.open("POST", url, true);
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
		ocultar(loading);
		//document.getElementById('apDivCuerpo').innerHTML=obXHR.responseText;
		alert(obXHR.responseText);
		Formulario.reset();
		
		if(redir==1){
			
			cargarFocus(url_redir,divContent,loading, foco);
		
		}
		
		//cargar(recarga);
	}
}
obXHR.send(cadenaFormulario);
}


function enviarFormularioR(url, formid, urlrecarga, divinfo){
		


		//ocultar('apDivVentana');
		mostrar('carga');
        
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
}
  obXHR.open("POST", url, true);
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
		ocultar('carga');
		//document.getElementById('apDivCuerpo').innerHTML=obXHR.responseText;
		alert(obXHR.responseText);
		cargar(urlrecarga,divinfo,'apDiv2');
	}
}
obXHR.send(cadenaFormulario);
}


function login(url, formid, recarga){
		
		var obDivmsg = document.getElementById('apDivMsg');
		//ocultarVent();
		mostrar("carga");
        
		 var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i <= Formulario.elements.length-1;i++) {
         	cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         	sepCampos="&";
		 }
  obXHR.open("POST", url, true);
  obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  obXHR.onreadystatechange = function () {
  if (obXHR.readyState == 4) {
	  
		ocultar("carga");
		
		if(obXHR.responseText!="1"){
			
			obDivmsg.innerHTML=obXHR.responseText;
			
		}else{
			
			document.location.href="app/";
			
		}
		
		//alert(obXHR.responseText);
		//cargar(recarga);

	}
}
obXHR.send(cadenaFormulario);
}
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
function logearse(){
	
	user=document.loginForm.txtusuario.value;
	psw=document.loginForm.txtclave.value;
	key=document.loginForm.txtllave.value;
	
	if(user==""){
		alert ("El usuario se encuentra vacio");
		document.loginForm.txtusuario.focus();

     	 return 0; 

		
	}else if(psw==""){
				alert ("El password se encuentra vacio");
		document.loginForm.txtclave.focus();

     	 return 0; 
			
	}else if(key==""){
				alert ("La llave no ha sido enviada");
		document.loginForm.txtllave.focus();

     	 return 0; 		
	}else{
		relocate('apps/login.php',{'user':user,'psw':psw,'key':key});
				}
	}
	
	
	
function logearse2(){
	user=document.login.txtusuario.value;
	psw=document.login.txtclave.value;
	
	if(user==""){
		alert ('El usuario se encuentra vacio');
		//document.getElementById("apDivMsg").innerHTML="Favor Digitar el Usuario.";
		//document.getElementById("txtusuario").focus();
	}else if(psw==""){
		//document.getElementById("apDivMsg").innerHTML="Favor Digitar la Contrase&ntilde;a.";
		alert ('El password se encuentra vacio');
		//document.getElementById("txtclave").focus();
	
	}else{
	
			//document.getElementById("recarga").style.visibility="visible";
			obXHR.open("GET","login/login.php?user="+user+"&psw="+psw);
			
		
			obXHR.onreadystatechange = function() {
				
				if (obXHR.readyState == 4 && obXHR.status == 200) {
				//obDiv.innerHTML=obXHR.responseText;
					document.getElementById("recarga").style.visibility="hidden";
					//alert(obXHR.responseText.length+" / "+obXHR.responseText);
					if(parseInt(obXHR.responseText)==1){//en el servidor mandar 114
						location.href='index2.php';
					}else{
						//document.getElementById("apDivMsg").innerHTML=obXHR.responseText;
						document.getElementById("user").select();
					}
					//;
					
				}
			}
			obXHR.send(null);
	}//fin else;
}


function cerrarsesion(){
	
	obXHR.open("GET","../login/cerrarsesion.php");
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				location.href='../';
		}
	}
	obXHR.send(null);
}


function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
function ajaxUpload(form,url_action,id_element,html_show_loading,html_error_http){
	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";
	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exists.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	if($m(id_element)==null){
		erro += "The element of 3rd parameter does not exists.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+id_element+"').innerHTML = document.body.innerHTML; void(0);";
		$m(id_element).innerHTML = html_error_http;
		$m('ajax-temp').src = cross;
		if(detectWebKit){
        	remove($m('ajax-temp'));
        }else{
        	setTimeout(function(){ remove($m('ajax-temp'))}, 250);
        }
    }
	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url_action);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");
	if(html_show_loading.length > 0){
		$m(id_element).innerHTML = html_show_loading;
	}
	form.submit();
}

//**************************************************************************//

 //Mas en: http://javascript.espaciolatino.com/

      //Objeto oNumero

function oNumero(numero)
{
	
	//Propiedades 
	
	this.valor = numero || 0
	
	this.dec = -1;
	
	//Métodos 
	
	this.formato = numFormat;
	
	this.ponValor = ponValor;
	
	//Definición de los métodos


	function ponValor(cad)
	
	{
	
		if (cad =='-' || cad=='+') return
		
		if (cad.length ==0) return
		
		if (cad.indexOf('.') >=0)
		
			this.valor = parseFloat(cad);
		
		else 
		
			this.valor = parseInt(cad);
		
	} 

function numFormat(dec, miles)

{

var num = this.valor, signo=3, expr;

var cad = ""+this.valor;

var ceros = "", pos, pdec, i;

for (i=0; i < dec; i++)

ceros += '0';

pos = cad.indexOf('.')

if (pos < 0)

    cad = cad+"."+ceros;

else

    {

    pdec = cad.length - pos -1;

    if (pdec <= dec)

        {

        for (i=0; i< (dec-pdec); i++)

            cad += '0';

        }

    else

        {

        num = num*Math.pow(10, dec);

        num = Math.round(num);

        num = num/Math.pow(10, dec);

        cad = new String(num);

        }

    }

pos = cad.indexOf('.')

if (pos < 0) pos = cad.lentgh

if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') 

       signo = 4;

if (miles && pos > signo)

    do{

        expr = /([+-]?\d)(\d{3}[\.\,]\d*)/

        cad.match(expr)

        cad=cad.replace(expr, RegExp.$1+','+RegExp.$2)

        }

while (cad.indexOf(',') > signo)

    if (dec<0) cad = cad.replace(/\./,'')

        return cad;

}

}//Fin del objeto oNumero:

//////////////////////////////////////////////////////////////////////////////////////////
//Funcion para moverse entre cajas de texto en el formulario enviando al punto donde quieras
function focusNext(form, elemName, evt) {
evt = (evt) ? evt : event;
var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
if (charCode == 13 || charCode == 3) {
form.elements[elemName].focus( );
return false;
}
return true;
}

//Funcion que solo permite inclusion de numeros.
function SoloNum(evt) {

 evt = (evt) ? evt : event;

 var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);

	if (charCode == 13 || charCode == 3) {

		//form.elements[elemName].focus( );
	
		return false;
		
	}else{
		
		// NOTA: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
		var nav4 = window.Event ? true : false;
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57));
		
	}
	
return true;

}

//Funcion que solo permite inclusion de numeros y caracter.
function SoloNumChar(evt,caracter) {

 evt = (evt) ? evt : event;

 var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);

	if (charCode == 13 || charCode == 3) {

		//form.elements[elemName].focus( );
	
		return false;
		
	}else{
		
		// NOTA: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
		var nav4 = window.Event ? true : false;
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57) || key==130 );
		
	}
	
return true;

}


//Funcion para moverse entre cajas de texto en el formulario enviando al punto donde quieras
function focusNextNum(form, elemName, evt) {

 evt = (evt) ? evt : event;

 var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);

	if (charCode == 13 || charCode == 3) {

		form.elements[elemName].focus( );
	
		return false;
		
	}else{
		
		// NOTA: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
		var nav4 = window.Event ? true : false;
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57)|| key==46 || key==44);
		
	}
	
return true;

}
	



///script para mover entre list
function verficarIguales(emisor1, receptor1){
	// Accedemos a los 2 selects
emisor1 = document.getElementById(emisor1);
receptor1 = document.getElementById(receptor1);
cantidad = receptor1.options.length;
selecionados = emisor1.selectedIndex;
texto = emisor1.options[selecionados].text;
//texto2=receptor.options[0].text;
i=0;
x2=0;
// INICIO DEL CICLO PARA RECORRER LAS ASIGNATURAS DE LA LISTA

for(i=0; i<cantidad; i++ )
	{
		texto2=receptor1.options[i].text;
        if(texto==texto2){
			x2=0;
			alert('La selecion hace parte del conjunto de elementos contenidos, verifiquelo');
			break;
		}else{
			x2=1;
			}
	}
	
   if (x2!=0 || cantidad==0){
	 posicion = receptor1.options.length;
     selecionado = emisor1.selectedIndex;

     if(selecionado != -1) {

         volcado = emisor1.options[selecionado];

         // Volcamos la opcion al select receptor y lo eliminamos del emisor
              receptor1.options[posicion] = new Option(volcado.text, volcado.value);
              emisor1.options[selecionado] = null;
              emisor1.selectedIndex=selecionado;
       if(selecionado>emisor1.length-1){emisor1.selectedIndex=emisor1.length-1;}

        }
     }
 }

function volcarSelects(emisor, receptor){

// Accedemos a los 2 selects
emisor = document.getElementById(emisor);
receptor = document.getElementById(receptor);

// Obtenemos algunos datos necesarios
posicion = receptor.options.length;
selecionado = emisor.selectedIndex;

if(selecionado != -1) {

volcado = emisor.options[selecionado];

// Volcamos la opcion al select receptor y lo eliminamos del emisor
receptor.options[posicion] = new Option(volcado.text, volcado.value);
emisor.options[selecionado] = null;
emisor.selectedIndex=selecionado;
if(selecionado>emisor.length-1){emisor.selectedIndex=emisor.length-1;}

}

}
////////////////////FUNCION PARA EL MAIL/////////////////////
function enviarSelects(x, y, receptor){
// Accedemos a los 2 selects
id=x;
nombre=y;
receptor = document.getElementById(receptor);
cantidad = receptor.options.length;
posicion = receptor.options.length;
// Obtenemos algunos datos necesarios

////////////////////////////////////////
if(cantidad >0){
for(i=0; i<cantidad; i++ )
	{
		nom=receptor.options[i].text;
    if(nombre==nom){
			x2=0;
			alert('Ya existe en la lista que esta editando, verifiquelo');
			break;
		}else{
			x2=1;
			}
	}
}else{
x2=1;	
}
////////////////////////////////////////

if((id != 0) && (x2!=0)) {

// Volcamos la opcion al select receptor y lo eliminamos del emisor
receptor.options[posicion] = new Option(nombre, id);

}

}


function quitarSelects(receptor){

receptor = document.getElementById(receptor);

selecionado = receptor.selectedIndex;

receptor.options[selecionado] = null;


}


/////////////////////////////////////////////////////////////////
function ArmaCadenaSelect(obj){
	
	IdSelect = document.getElementById(obj);
	CantId = IdSelect.length;
	
	cadenaSelect='';
	
	for(j=0; j<CantId ; j++){
	
		//alert(IdSelect[j].value + IdSelect[j].text);
		if(cadenaSelect==''){
			cadenaSelect += IdSelect[j].value;
		}else{
			cadenaSelect += ',' + IdSelect[j].value;
		}
	
	}
	return cadenaSelect;
	//alert(cadenaSelect);
	
}

///////////////////////////////////////////////////////////
function EnviarLista_Desc(url,idform, nlib, idcheck, divreload,idsocio,idsocio2, urlreturn ,divinfo,divreload,foco){
	if( ! confirm('Seguro desea aplicar los descuentos a el(los) estudiante(s) selecciondo(s) ?') ){
		return false;
	}
	val=0;
	
	codlibr=0;
	libranzas ='';
	soccios ='';
	soccios2 ='';
	num=0;
	obj = document.getElementById(idcheck);
	
	 document.getElementById(idcheck);
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(libranzas==''){
				libranzas = ele.value;
				socios = document.getElementById(idsocio+ele.value).value;
				socios2= document.getElementById(idsocio2+ele.value).value;
				if(document.getElementById(idsocio+ele.value).value == ''){val++ ; codlibr=ele.value;} 
				
			}else{
				libranzas += '-'+ele.value;
				socios += '-'+document.getElementById(idsocio+ele.value).value; 
				socios2 += '-'+document.getElementById(idsocio2+ele.value).value;
				if(document.getElementById(idsocio+ele.value).value == '') {val++ ; codlibr=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado estudiante. ');
		return false;
	}
	
	if( val != 0 ){
		alert('En el estudiante de id= '+codlibr+', digite el codigo correspondiente.');
		document.getElementById(idsocio+codlibr).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+libranzas+'&des_mat='+socios+'&des_pen='+socios2+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

function EnviarListaAtributo(url, idform, nlib, idcheck, divreload, nhoras, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar los atributos seleccionados ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	num=0;
	obj = document.getElementById(idcheck);
	      document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				numhoras=document.getElementById(nhoras+ele.value).value;
				
				if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				numhoras += '-'+document.getElementById(nhoras+ele.value).value;  
				
				if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado atributos.');
		return false;
	}
	
	if( val != 0 ){
		alert('En el atributo de id= '+codasig+', digite el codigo correspondiente.');
		document.getElementById(nhoras+codasig).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&nhoras='+numhoras+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT


////////////////////////////////////////////////añadi/////////////////////////////////////

function EnviarListaRep(url, idform, nlib, idcheck, divreload, nhoras, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar a los estudiantes selecciondos el reporte actual ?') ){
		return false;
	}
	alert('al principio idcheck= '+idcheck);
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	num=0;
	obj = document.getElementById(idcheck);
	      document.getElementById(idcheck);
		  
	//alert('al principio'+val+codasig+asignatura+numhoras+num);
	
	for (i=0; ele=obj.form.elements[i]; i++){
		//alert('primer ciclo'+ele.value);
	        
	  if (ele.checked){
		 // alert('primer ciclo'+i);
	        
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				numhoras=document.getElementById(nhoras+ele.value).value;
				
				if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				numhoras += '-'+document.getElementById(nhoras+ele.value).value;  
				
				if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado estudiantes.');
		return false;
	}
	
	if( val != 0 ){
		alert('El estudiante de Codigo= '+codasig+', actualice los datos.');
		document.getElementById(nhoras+codasig).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&nhoras='+numhoras+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

//////////////////////////////////////////////////////////////////////////////////////////

//INICIO ENVIO varios OBJETOs  INPUT
/*
function EnviarListaCalActi(url,idform, nlib, idcheck, divreload, idcheck, idconcepto, idnotanum, idasistencia, urlreturn ,divinfo,divreload,foco){
	if( ! confirm('Seguro desea procesar el conjunto de datos ?') ){
		return false;
	}
	val=0;
	val2=0;
	val3=0;
	
	codlibr=0;
	notlibr=0;
	asilibr=0;
	libranzas ='';
	concepto ='';
	notanum='';
	asistencia='';
	
	num=0;
	obj = document.getElementById(idcheck);
	
	 document.getElementById(idcheck);
	 
	 //alert('Libranza='+ idcheck);
	 
	alert('antes del for');
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  alert('dentro del for y el primer if'+i);
			if(libranzas==''){
				alert('dentro del for y el segundo if'+i);
				libranzas = ele.value;
				alert('libranza:'+libranzas);
				//concepto = document.getElementById(idconcepto+ele.value).value;
				//if(document.getElementById(idconcepto+ele.value).value == ''){val++ ; codlibr=ele.value;} 
				
				notanum = document.getElementById(idnotanum+ele.value).value;
				alert('nota:'+notanum);
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 

				//asistencia = document.getElementById(idasistencia+ele.value).value;
				//if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 


								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);
				
			}else{
				alert('dentro del for y el else'+i);
				
				libranzas += '-'+ele.value;
				
				//concepto += '-'+document.getElementById(idconcepto+ele.value).value;  
				//if(document.getElementById(idconcepto+ele.value).value == '') {val++ ; codlibr=ele.value;}
				
				notanum += '-'+document.getElementById(idnotanum+ele.value).value;  
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 


				//asistencia += '-'+document.getElementById(idasistencia+ele.value).value;  
				//if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 
				
								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);

			}
			alert('sali del else'+i);
				
			num++;
	  }
	  
	}
	alert('salgo segundo if'+i);
	
	//alert('Paso 0');
	
	if( num==0 ){
		alert('Usted no ha seleccionado aspirantes.');
		return false;
	}
	
	
	if( val != 0 ){
		alert('En el estudiante de id= '+codlibr+', digite el concepto correspondiente.');
		document.getElementById(idconcepto+codlibr).focus();
		return false;
	}else{
		
			if( val2 != 0 ){
				alert('En el estudiante de id= '+notlibr+', digite la nota correspondiente.');
				document.getElementById(idnotanum+notlibr).focus();
				return false;
			}else{
	
					if( val3 != 0 ){
						alert('En el estudiante de id= '+asilibr+', digite la asistencia correspondiente.');
						document.getElementById(idasistencia+asilibr).focus();
						return false;
					}			
		
				}

		}

	//alert('Paso 1');
	mostrar(divreload);
	//alert('Paso 2');
	cadenaFormulario= 'idAsA='+libranzas+'&idconcepto='+concepto+'&notanum='+notanum+'&asistencia='+asistencia+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT*/
function EnviarListaNotas(url, idform, nlib, idcheck, divreload, nhoras, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar las calificaciones siguientes ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	num=0;
	obj = document.getElementById(idcheck);
	      //document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				numhoras=document.getElementById(nhoras+ele.value).value;
				
				if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				numhoras += '-'+document.getElementById(nhoras+ele.value).value;  
				
				if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado Estudiante.');
		return false;
	}
	
	if( val != 0 ){
		alert('En al estudiante de Codigo= '+codasig+', digite la calificacion correspondiente.');
		document.getElementById(nhoras+codasig).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&nhoras='+numhoras+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT
function cargarFocusSs(url,divinfo,divreload, tipo) {
	
	var tipoD = tipo;
	if(tipoD==1){
	
	if( ! confirm('Seguro Desea Cerrar El Expediente ?') ){
		return false;
	}
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
	}
	alert('Expediente Cerrado!, Recuerde que usted tiene la opcion adicional de re-abrirlo');
	obXHR.send(null);
	}else{
	if(tipoD==2){
	if( ! confirm('Seguro Desea Re-Abrir El Expediente ?') ){
		return false;
	}
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
	}
	alert('Expediente Re-Abierto Satisfactoriamente!.');
	obXHR.send(null);
	}else{
		if(tipoD==3){
	if( ! confirm('Seguro Desea Cancelar La Cita ?') ){
		return false;
	}
	var obDiv = document.getElementById(divinfo);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
	}
	alert('Cita Cancelada Satisfactoriamente!.');
	obXHR.send(null);
		}
	
}
	}
}

////////////////////////////////////////////////
//Funcion para validar direccion de correo
function validarEmail(valor) {
  if (/^[\w-\.]+@([\w-]+\.)+[\w-]{3,4}$/ig.test(valor)){
    document.frmregistro.btnaceptar.disabled='';
    igualarusuarios();
  } else {
   alert("La dirección de email es incorrecta.");
   document.frmregistro.txtemail.value='usuario@servidor.com';
   document.frmregistro.btnaceptar.disabled='disabled';
   document.frmregistro.txtemail.focus();
  }
}
function ajaxFileUpload()
	{
		//starting setting some animation when the ajax starts and completes
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		
		/*
			prepareing ajax file upload
			url: the url of script file handling the uploaded files
                        fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
			dataType: it support json, xml
			secureuri:use secure protocol
			success: call back function when the ajax complete
			error: callback function when the ajax failed
			
                */
		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php', 
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}  
	function ajaxFunction() {
  var xmlHttp;
  
  try {
   
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
  } catch (e) {
    
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
    } catch (e) {
      
      try {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
      } catch (e) {
        alert("Tu navegador no soporta AJAX! Disculpa.");
        return false;
      }}}
}
 
 
 
 
function Enviar(directorio,pagina) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", directorio, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
 
    ajax.onreadystatechange = function() {
        if (ajax.readyState==1){
            document.getElementById(pagina).innerHTML = " Espere porfavor...";
                 }
        if (ajax.readyState == 4) {
           
                document.getElementById(pagina).innerHTML=ajax.responseText; 
             }}
             
    ajax.send(null);
}
function ventana(url,ancho,alto) {
var posicion_x; 
var posicion_y; 
posicion_x=(screen.width/2)-(ancho/2); 
posicion_y=(screen.height/2)-(alto/2); 
window.open("url="+url+",width="+ancho+",height="+alto+",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left="+posicion_x+",top="+posicion_y+"");
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////añadi/////////////////////////////////////

function ListaCargaProf(url, idform, nlib, idcheck, divreload, nhoras, idprof, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar la carga seleccionda ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	profs='';
	num=0;
	obj = document.getElementById(idcheck);
	      //document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				numhoras=document.getElementById(nhoras+ele.value).value;
				profs=document.getElementById(idprof+ele.value).value;
				
				if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				numhoras += '-'+document.getElementById(nhoras+ele.value).value; 
				profs += '-'+document.getElementById(idprof+ele.value).value; 
				
				if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado asignaturas.');
		return false;
	}
	
	if( val != 0 ){
		alert('En la asignatura de Codigo= '+codasig+', digite el numero de horas correspondiente.');
		document.getElementById(nhoras+codasig).focus();
		return false;
	}
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&nhoras='+numhoras+'&num='+num+'&idprof='+profs;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

//////////////////////////////////////////////////////////////////////////////////////////
//INICIO ENVIO varios OBJETOs  INPUT

function EnviarListaNotas(url,idform, nlib, idcheck, divreload, idcheck, idAct, nota, urlreturn ,divinfo,divreload,foco){
	if( ! confirm('Seguro desea procesar el conjunto de calificaciones ?') ){
		return false;
	}
	val=0;
	val2=0;
	val3=0;
	
	codact=0;
	codalum=0;
	libranzas ='';
	concepto ='';
	notanum='';
	asistencia='';
	
	num=0;
	obj = document.getElementById(idcheck);
	
	 document.getElementById(idcheck);
	 
	 //alert('Libranza='+ idcheck);
	 
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(libranzas==''){
				libranzas = ele.value;
				concepto = document.getElementById(idconcepto+ele.value).value;
				if(document.getElementById(idconcepto+ele.value).value == ''){val++ ; codlibr=ele.value;} 
				
				notanum = document.getElementById(idnotanum+ele.value).value;
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 

				asistencia = document.getElementById(idasistencia+ele.value).value;
				if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 


								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);
				
			}else{
				
				libranzas += '-'+ele.value;
				
				concepto += '-'+document.getElementById(idconcepto+ele.value).value;  
				if(document.getElementById(idconcepto+ele.value).value == '') {val++ ; codlibr=ele.value;}
				
				notanum += '-'+document.getElementById(idnotanum+ele.value).value;  
				if(document.getElementById(idnotanum+ele.value).value == '') {val2++ ; notlibr=ele.value;} 


				asistencia += '-'+document.getElementById(idasistencia+ele.value).value;  
				if(document.getElementById(idasistencia+ele.value).value == '') {val3++ ; asilibr=ele.value;} 
				
								//alert('Libranza='+libranzas+', Concepto= '+concepto+', NotaNum= '+notanum+', asistencia= '+asistencia);

			}
				
			num++;
	  }
	}
	
	
	//alert('Paso 0');
	
	if( num==0 ){
		alert('Usted no ha seleccionado aspirantes.');
		return false;
	}
	
	
	if( val != 0 ){
		alert('En el estudiante de id= '+codlibr+', digite el concepto correspondiente.');
		document.getElementById(idconcepto+codlibr).focus();
		return false;
	}else{
		
			if( val2 != 0 ){
				alert('En el estudiante de id= '+notlibr+', digite la nota correspondiente.');
				document.getElementById(idnotanum+notlibr).focus();
				return false;
			}else{
	
					if( val3 != 0 ){
						alert('En el estudiante de id= '+asilibr+', digite la asistencia correspondiente.');
						document.getElementById(idasistencia+asilibr).focus();
						return false;
					}			
		
				}

		}

	//alert('Paso 1');
	mostrar(divreload);
	//alert('Paso 2');
	cadenaFormulario= 'idAsA='+libranzas+'&idconcepto='+concepto+'&notanum='+notanum+'&asistencia='+asistencia+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT

///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

function ListaNotas(url, idform, nlib, idcheck, divreload, nota, idAct, urlreturn, divinfo, divreload, foco){
	//alert('Entre al F');
	if( ! confirm('Seguro desea asignar las calificaciones presentes?') ){
		return false;
	}
	 var obj = document.getElementById(idcheck);
	 val=0;
	 total= 280;
	 codalum=0;
	 idalumno ='';
	 notaNum='';
	 idact='';
	 num=0;
	 var forma=idform;
	// alert ('forumalrio: '+forma);
	 //elelmntos=document.elements.length;
	 //vlaChek=document.getElementById.(idcheck);
	//alert(elelmntos);
	
	      //document.getElementById(idcheck);
    
	//alert(obj);	  
	//alert('Estoy el ele');
	//alert(ele);
	
//for(c=0; c<8; c++){	
    var entradas =document.getElementsByTagName("input");
	var i =2;
	
   //alert(entradas.length);
   var Nums=(entradas.length-2)/3;
   ele=entradas[3].value;
   ele2=entradas[4].value;
   ele3=entradas[5].value;
   
   //alert('E'+ele);
   //alert('E2'+ele2);
   //alert('E3'+ele3);
   //alert(Nums);
   
        idalumno=ele2;
        notaNum=ele;
        idact=ele3;    
	//alert(idalumno+'-'+notaNum+'-'+idact); 
	for (i=6; i < entradas.length;  i=i+3){
		x=i+1;
		z=i+2;
		ele=entradas[i].value;
		ele2=entradas[x].value;
		ele3=entradas[z].value;
		 //alert(ele);
        // if (isNaN(ele)){ 
          // alert("¡Debes introducir un número!"); 
          // return false; 
          //   } 
            //       else { 
                   // alert(ele+'-'+i);
          //  if(alumno==''){
			//	alumno = ele;
			
			
        idalumno += '-'+ele2;
        notaNum += '-'+ele;
        idact += '-'+ele3;  
		//alert(idalumno+'-'+notaNum+'-'+idact+'-'+i); 
		
		
   
		//document.getElementById(idAct)
		//alert(vlaChek);
	  //if (ele.checked){
		  //alert('Esta Chek');
			/*if(alumno==''){
				alumno = ele;
				
				alert('cando es vacio'+alumno);
				//socios = document.getElementById(idsocio+ele.value).value;
				notaNum=document.getElementById(nota+ele).value;
				act=document.getElementById(idAct+ele).value;
				
				alert('ele:'+ele);
				alert('nota:'+notaNum);
				alert('act:'+act);
				
				if(document.getElementById(nota+ele).value == ''){val++ ; codalum=ele;} 
				
			}else{
				//alert('Cuando no es vacio');
				alumno += '-'+ele;
				notaNum += '-'+document.getElementById(nota+ele).value; 
				act += '-'+document.getElementById(idAct+ele).value; 
				
				alert(ele);
				alert(notaNum);
				alert(act);
				if(document.getElementById(nota+ele).value == '') {val++ ; codalum=ele;} 
			*/
			num++;
			}
				
			
	  //}
	//}
	
	if( num==0 ){
		alert('Usted no ha seleccionado estudiantes.');
		return false;
	}
	
	/*if( val != 0 ){
		alert('En el estudiante de Codigo= '+codasig+', digite la nota correspondiente.');
		document.getElementById(nota+codalum).focus();
		return false;
	}*/
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+idalumno+'&nota='+notaNum+'&num='+num+'&idAct='+idact;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	//}
	//alert('voy a enviar');
	//alert(notaNum);
	ocultar(divreload);
	obXHR.send(cadenaFormulario);
	//} 
//}
}


//FINAL ENVIO CHECK + OTRO OBJETO EJEMPLO: UN INPUT
function EnviarNotasRec(url, idform, nlib, idcheck, divreload, notanum, urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar las calificaciones siguientes ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	notaNum='';
	num=0;
	obj = document.getElementById(idcheck);
	      //document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		 // alert('entre al ciclo');
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				notaNum=document.getElementById(notanum+ele.value).value;
				
				if(document.getElementById(notanum+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				notaNum += '-'+document.getElementById(notanum+ele.value).value;  
				
				if(document.getElementById(notanum+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
		//alert('fuera del ciclo');

	if( num==0 ){
		alert('Usted no ha seleccionado Estudiante.');
		return false;
	}
	
	if( val != 0 ){
		
        alert('Se presentan estudiantes si nota o con el campo vacio, digite la calificacion correspondiente.');
		document.getElementById(notanum+codasig).focus();
		return false;
	}
	//alert('en funcion fuera del ciclo');
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&notanum='+notaNum+'&num='+num;
		//alert('arme la cadena');
		//alert('cadena: '+cadenaFormulario);

	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	
	obXHR.send(cadenaFormulario);
	//alert('envie');
}
//////////////////////////////////////////////////////////////////////////////////////////

function EnviarListaNivel(url, idform, nlib, idcheck, divreload,  urlreturn, divinfo, divreload, foco){
	if( ! confirm('Seguro desea asignar la carga seleccionda ?') ){
		return false;
	}
	val=0;
	codasig=0;
	asignatura ='';
	numhoras='';
	num=0;
	obj = document.getElementById(idcheck);
	      //document.getElementById(idcheck);
		  
	
	for (i=0; ele=obj.form.elements[i]; i++){
	  if (ele.checked){
		  
			if(asignatura==''){
				asignatura = ele.value;
				
				//socios = document.getElementById(idsocio+ele.value).value;
				//numhoras=document.getElementById(nhoras+ele.value).value;
				
				//if(document.getElementById(nhoras+ele.value).value == ''){val++ ; codasig=ele.value;} 
				
			}else{
				
				asignatura += '-'+ele.value;
				//numhoras += '-'+document.getElementById(nhoras+ele.value).value;  
				
				//if(document.getElementById(nhoras+ele.value).value == '') {val++ ; codasig=ele.value;} 
			}
				
			num++;
	  }
	}
	
	if( num==0 ){
		alert('Usted no ha seleccionado asignaturas.');
		return false;
	}
	
	
	
	mostrar(divreload);
	cadenaFormulario= 'idAsA='+asignatura+'&num='+num;
	
	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	}
	obXHR.send(cadenaFormulario);
}

////////////////////////////////////////////////////////////
function grupoFocus(url, divinfo, divreload, foco, url2, divinfo2, foco2){
	var obDiv = document.getElementById(divinfo);
	var obDiv2 = document.getElementById(divinfo2);
	
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
			
		}
		
	}
	obXHR2.open("GET", url2);
	obXHR2.onreadystatechange = function() {
		if (obXHR2.readyState == 4 && obXHR2.status == 200) {
			obDiv2.innerHTML=obXHR2.responseText;
			ocultar(divreload);
			document.getElementById(foco2).focus();
			
		}
		
	}
	obXHR.send(null);
	obXHR2.send(null);
	
	
	
}
////////////////////////////////////////////////////////////////


function cargarFocusReporteChk(url, divinfo, divreload, foco) {
	
	var obDiv = document.getElementById(divinfo);
	url=url+GetInfoString2();
	mostrar(divreload);
	
	obXHR.open("GET", url);
	obXHR.onreadystatechange = function() {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
			obDiv.innerHTML=obXHR.responseText;
			ocultar(divreload);
			document.getElementById(foco).focus();
		}
		
	}
	obXHR.send(null);
}


//Funcion para moverse entre cajas de texto en el formulario enviando al punto donde quieras
function focusNextNt(form,  textO, ap, evt) {
evt = (evt) ? evt : event;
 /////////////////////////////////////////7
//alert(textO);
//alert(ap);

 ////////////////////////////////////////////

valN=document.getElementById(textO).value;
//valN=document.getElementByName(textO).value;
//alert('ok');
//alert(valN);
 //var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
 var charCode = (evt.which) ? evt.charCode : evt.keyCode
 // var charCode = event.which ? window.event.which : window.event.keyCode;

  if ((charCode == 13 || charCode == 40)&& valN=="") {
	  alert('No puede quedar vacio, minimo debe contener un CERO (0)!!');
      document.getElementById(textO).focus();
	    document.getElementById(textO).select();
       return false;
    }else if((charCode == 13 || charCode == 40)&& valN!=""){
	  sig=textO+ap;
	  document.getElementById(sig).focus();
	  document.getElementById(sig).select();
     return false;
	 
	 }else if(charCode == 38 && valN!=""){
	  ant=textO-ap;
	  document.getElementById(ant).focus();
	   document.getElementById(ant).select();
     return false;
     
	}else if(charCode <= 13 || (charCode >= 48 && charCode <= 57) || charCode==46){
	 
     return true;
	 }else{
		 alert('Recuerde que solo debe ingresar notas numericas!!');
      document.getElementById(textO).focus();
	   document.getElementById(textO).select();
	  return false;
	 }
	 return true;
}
  ////////////////////////////////////////////////

/////////////////////////////////////////////////////77
function format(input){
var num = input.value.replace(/\,/g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\,?)(\d{3})/g,'$1,');
num = num.split('').reverse().join('').replace(/^[\,]/,'');
input.value = num;


}
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\,]*/g,'');
input.focus();
}
}


//////////////////////////////////////////////////////////////////////////////////////////////////////
//ENVIAR OPTION FORMULARIO
function EnviarForma(url, idform, nlib, divreload, urlreturn, divinfo, divEncabezado, foco){
	if( ! confirm('Completar Formulario ?') ){
		return false;
	}
	var val=0;
	var num=0;
	var respuesta='';
	var codPreg;
	var cadenaFormulario;
	var nlib=nlib;
	var obj = document.getElementsByTagName("input");
	
	var ele=obj.length;
	ele=(ele-1);
	
	//alert(ele);
	
   for (i=0; i<ele; i++){
		var elementos = obj[i].id;
		  var nmobj=obj[i].name;
         
		
      var len = $('#frmRespuestas input[name='+nmobj+']:radio:checked').length;
	  if (len>0){
		  
		 idele=obj[i].id;
	     txtele=obj[i].value;
		 if(respuesta==''){
				respuesta = txtele;
				codPreg = idele;
				val++;
				//alert('si');
			}else{
						
				respuesta += '-'+txtele;
				codPreg += '-'+idele;
				val++;
				//alert('si+');
		 }
		 
		 num++;
	 
	  }else{
		   
		  document.getElementById(nmobj).style.background = "#F9C7AE";
          document.getElementById(nmobj).style.color = "red";
		  document.getElementById(nmobj).style.border = "thin solid red";
          document.getElementById(elementos).focus();
		  return false;
          break;
          
	  }
	  
	 }
	alert ('val: '+val);
	
	//if( val != nlib ){
		
     //   alert('Verifique sus respuestas, se encuentran preguntas sin responder.');
		//document.getElementById(notanum+codasig).focus();
	//	return false;
	//}
	//alert('en funcion fuera del ciclo');
	mostrar(divreload);
	cadenaFormulario= 'codPreg='+codPreg+'&respuesta='+respuesta+'&num='+num;
		alert('arme la cadena');
		//alert('caRespuestadena: '+respuesta);

	obXHR.open("POST", url, true);
	obXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	obXHR.onreadystatechange = function () {
		if (obXHR.readyState == 4 && obXHR.status == 200) {
				
				alert(obXHR.responseText);
				ocultar(divreload);
				limpiarDiv(divEncabezado);
				cargarFocus(urlreturn,divinfo,divreload,foco);
				
		}
	
	}
	obXHR.send(cadenaFormulario);
	
}
//////////////////////////////////////////////////////////////////////////////////////////
