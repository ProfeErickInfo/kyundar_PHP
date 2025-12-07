// Login Form
$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});
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
function entrar_admin(){
	
	user=document.loginForm.txtusuario.value;
	pass=document.loginForm.txtclave.value;
	
	if(user==""){
		 showNotification({
                            message: "El usuario no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.loginForm.txtusuario.focus();

     	 return 0; 

		
	}else if(pass==""){
				 showNotification({
                            message: "La contrase&ntilde;a no puede quedar vacia",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.loginForm.txtclave.focus();

     	 return 0; 
			
	
	}else{
		
	relocate('login.php',{'user':user,'pass':pass});
				}
	}
	
	////////////////
//Funcion para moverse entre cajas de texto en el formulario enviando al punto donde quieras
function focusNextLogin(form, actualName , elemName, evt) {
evt = (evt) ? evt : event;
forma=form.elements[actualName].value;
      
//if (forma!=""){
  var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
  if ((charCode == 13 || charCode == 3)&& forma=="") {
	  //alert("No puede quedar vacio!!");
	  showNotification({
                            message: "No puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
	  form.elements[actualName].focus( );
      return false;
    }else if((charCode == 13 || charCode == 3)&& forma!=""){
       form.elements[elemName].focus( );
       return false;
      }
    return true;
  }
  
  
  //////////////////////////////////////////////////////
function entrarOnKey(evt){
	evt = (evt) ? evt : event;
	
	user=document.loginForm.txtusuario.value;
	pass=document.loginForm.txtclave.value;
	
  var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
  if ((charCode == 13 )) {
	if(user==""){
		  showNotification({
                            message: "El usuario no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.loginForm.txtusuario.focus();

     	 return 0; 

		
	}else if(pass==""){
				   showNotification({
                            message: "La contrase&ntilde;a no puede quedar vacia",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.loginForm.txtclave.focus();

     	 return 0; 
			
	
	}else{
		
	relocate('login.php',{'user':user,'pass':pass});
				}
	}
}
