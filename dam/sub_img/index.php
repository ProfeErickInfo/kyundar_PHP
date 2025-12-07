<?php
//include('db.php');
session_start();
$session_id='1'; //$session id
?>
<html>
<head>
<title></title>
<!---------------foto-------------------->
  
<script type="text/javascript" src="sub_img/jquery.min.js"></script>
<script type="text/javascript" src="sub_img/jquery.form.js"></script>

<script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="sub_img/loader.gif" alt="Cargando...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>


<!--------------fin foto------------------->

</head>


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
#dvform{
   -moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	-webkit-box-shadow:1px 1px 3px #888;
	-moz-box-shadow:1px 1px 3px #888;
	background-color:#068;
	height:100px;
	font:Tahoma;
	font-size:12px;	
	color:#EEE;
	font-weight:bold;
	padding:5px 5px 5px 5px;
	border:solid  #BBB;
	
}
</style>
<bodpay>
<div style="width:600px">
  <p>&nbsp;</p>
   <div id="dvform">
    <p style="color:#FF0">Tips: Tamaño Maximo del Archivo es de 50 Kilobytes</p>
    <form id="imageform" method="post" enctype="multipart/form-data" action='sub_img/ajaximage.php'>
Seleccione la imagen <input type="file" name="photoimg" id="photoimg"  />
</form>
<p>Clic sobre la imagen despues de cargada para actualizar el explorador de imagenes</p>
</div>
<p>&nbsp;</p>
<div id='preview' style="alignment-baseline:baseline; left:!important; height:300px; width:450px; float:left; border:solid; border-color:#DDD" align="center"  onClick="cargarFocus('sub_img/img_explorer.php', 'DVExplorer', 'carga','');">
</div>


</div>

<div id="DVExplorer" style="display:inline-block; float:right; margin-right:10px; height:300px; overflow:auto; width:600px; border:solid; border-color:#DDD">
<?php include('img_explorer.php'); ?>
</div>
<div id="DVexecute"  ></div> 
   
</body>
</html>