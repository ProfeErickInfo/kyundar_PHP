<?PHP
session_start();
$url=@$_SESSION['direction'];
$Xrefer = getenv('HTTP_REFERER'); 
$id_usu=(int)@$_SESSION['id_usuario'];
$tipoU=$_SESSION['tipo_U'];
?>
<!----------------------------------------------------------------->

<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bestuur | Plataforma</title>
   <meta name="description" content="Easy Event">
    <!--  
   Favicons
    =============================================
  
     -->
     <link rel="icon" type="image/png" sizes="144x144" href="biblio10/images/sj-icono144x144.png">
    <link rel="manifest" href="/manifest.json">
</head>



<?
//echo"idUsuario: ".$id_usu;
//echo"Tupo U:: ".$tipoU;
//echo "Dir: ".$url;
//if (($Xrefer)){
//if ((!$Xrefer) || ($id_usu==0)){
if ($id_usu!=0){
    if($tipoU==1){
        if(!empty($url)){
           // $url='index.php';
            include($url);

            exit();
        }else{
            ?> 
            <script languaje="JavaScript">
            location.href='../sesionOut.html';
            </script>
            
            <?php
        }
    }else{
        ?> 
        <script languaje="JavaScript">
        location.href='../sesionOut.html';
        </script>
        
        <?php
    }

}else{
    ?> 
    <script languaje="JavaScript">
    location.href='../sesionOut.html';
    </script>
    
    <?php

}
