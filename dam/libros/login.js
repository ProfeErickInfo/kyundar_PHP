// Login Form
function valEmail(valor){
    re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
    if(!re.exec(valor))    {
        return false;
    }else{
        return true;
    }
}



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
function entrar(){
	
	nom=document.regForm.txtnusu.value;
	pas=document.regForm.txtpass.value;
	
	if(nom==""){
		 showNotification({
                            message: "El nombre de usuario no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.regForm.txtnusu.focus();

     	 return 0; 

	}else if(pas==""){
				 showNotification({
                            message: "El dato de contrase&ntilde;a no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.regForm.txtpass.focus();

     	 return 0; 		
	}else{
		
	relocate('logU.php',{'nom':nom,'pas':pas});
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
	
	nom=document.regForm.txtnusu.value;
	pas=document.regForm.txtpass.value;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
  if ((charCode == 13 )) {
	if(nom==""){
		  showNotification({
                            message: "El nombre de usuario no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.regForm.txtnusu.focus();

     	 return 0; 

			
	}else if(pas==""){
				  showNotification({
                            message: "El dato de contrase�a no puede quedar vacio",
							autoClose: true,
							duration: 2, 
							type: "error"
                        });
		document.regForm.txtpass.focus();

     	 return 0; 		
	}else{
		
	relocate('logU.php',{'nom':nom,'pas':pas});
				}
	}
}
