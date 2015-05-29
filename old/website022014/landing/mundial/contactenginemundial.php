<?php

$EmailFrom = "landmundial@gylenterprise.com.ar";
$EmailTo = "infomundial@gylenterprise.com.ar";
$Subject = "Contacto por Prod Mundial";
$Name = Trim(stripslashes($_POST['name'])); 
$Tel = Trim(stripslashes($_POST['tel'])); 
$Email = Trim(stripslashes($_POST['email'])); 
$Message = Trim(stripslashes($_POST['message'])); 

// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "Nombre: ";
$Body .= $Name;
$Body .= "\n";
$Body .= "Tel: ";
$Body .= $Tel;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $Email;
$Body .= "\n";
$Body .= "Mensaje: ";
$Body .= $Message;
$Body .= "\n";

$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= "From: <$EmailFrom>";

// send email 
$success = mail($EmailTo, $Subject, $Body, $cabeceras);

// redirect to success page 
if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contactthanksmundial.php\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
}
?>