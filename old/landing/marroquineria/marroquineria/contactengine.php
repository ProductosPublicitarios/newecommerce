<?php
//engine para marroquineria/marroquineria/marroquineria_publicitaria.html
$EmailFrom = "marroquineria@gylenterprise.com.ar";
$EmailTo = "ventas@gylenterprise.com.ar";
$Subject = "Contacto por marroquineria";
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

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contactthanks.html\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
}
?>