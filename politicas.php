<?php
/*
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$sexion = 4;
$sexion_name = $arr_sexiones[$sexion];


$texto = '';
$titulo = 'Políticas de Privacidad';
$img = '<img src="images/logo-prod-ver.jpg" width="168" height="71" vspace="10" />';

$conn = conn();
$sql = "SELECT titulo,texto,uri FROM secciones WHERE code=$sexion";
$res = mysql_query($sql);
if($res){
	$nr = mysql_num_rows($res);
	if($nr>0){
		$row = mysql_fetch_array($res);
		$titulo = $row['titulo'];
		$texto = stripslashes($row['texto']);
		$img = $row['uri'];
		if($img != ''){
			$img = '<img src="images/secciones/'.$img.'" vspace="10" />';
		}
	}
}
*/
$titulo = 'Políticas de Privacidad';
$texto = 'Mediante este aviso, GYL Enterprise (Productos publicitarios SRL) le informa a los usuarios de su sitio web:<br />
wwww.gylenterprise.com.ar acerca de su política de protección de datos de carácter personal (en adelante, "los Datos Personales"). GYL Enterprise (Productos Publicitarios SRL) se reserva el derecho a modificar la presente política para adaptarla a novedades legislativas o jurisprudenciales así como a prácticas de la industria. En dichos supuestos, anunciará en esta página los cambios introducidos con razonable antelación a su puesta en práctica.
<br /><br />
<br />1. Uso de datos personales
<br />Los datos que se recopilan son: Nombre, Email y Telefono.
<br />El uso de los datos recopilados es para exclusiva cotización/contratación del servicio solicitado, estos mismos datos serán transferidos a las empresas prestadoras del servicio una vez autorizada la contratación por el cliente.
<br />Los datos pueden ser modificados por el cliente en el momento que el lo decida con los fines necesarios para continuar o agrandar la prestación del servicio.
<br />Los datos del cliente serán eliminados de nuestra base de clientes, al término de la prestación de servicio o cuando el cliente solicite la baja del mismo de forma anticipada.
<br /><br />	
2. Empleo de la tecnología cookie
<br />El Usuario reconoce y acepta que GYL Enterprise (Productos Publicitarios SRL) podrá utilizar cookies cuando un Usuario navegue por el Website. Las cookies de GYL Enterprise (Productos Publicitarios SRL) se asocian únicamente con un Usuario anónimo y su ordenador y no proporcionan referencias que permitan deducir datos personales del Usuario. El Usuario podrá configurar su navegador para que notifique y rechace la instalación de las cookies enviadas por GYL Enterprise (Productos Publicitarios SRL), sin que ello perjudique la posibilidad del Usuario de acceder a los Contenidos.
<br /><br />
3. Prohibición de comunicaciones comerciales no solicitadas realizadas a través de correo electrónico u otros medios de comunicación electrónica: anti-spamming
<br />GYL Enterprise (Productos Publicitarios SRL) SE OBLIGA A NO:
<br />1. 1. Recabar datos de los usuarios con finalidad publicitaria y de remitir publicidad de cualquier clase y comunicaciones con fines de venta u otras de naturaleza comercial sin que medie su previa solicitud o consentimiento.
<br />2. 2. Remitir cualesquiera otros mensajes no solicitados ni consentidos previamente a una pluralidad de personas.
<br />3. 3. Enviar cadenas de mensajes electrónicos no solicitados ni previamente consentidos.
<br />4. 4. Utilizar listas de distribución a las que pueda accederse a través de los Servicios.
<br />5. 5. Poner a disposición de terceros, con cualquier finalidad, datos recabados a partir de listas de distribución.
<br /><br />
4. Seguridad
<br />GYL Enterprise (Productos Publicitarios SRL) protege la transmisión de sus datos personales con la tecnología SSL (Secure Sockets Layer o Capa Segura de Contactos) y los almacena en un formato codificado (encriptado).
<br /><br />
5. Modificaciones a esta política de privacidad
<br />GYL Enterprise (Productos Publicitarios SRL) realiza enmiendas a esta normativa ocasionalmente. Si los cambios que realizamos son importantes y afectan directamente al uso que le damos a la información personal de nuestros usuarios, se los haremos saber colocando en nuestras páginas avisos destacados al respecto.
<br />Dudas o sugerencias:
<br /><br />
6. Ley aplicable y jurisdicción
<br />La prestación del servicio del Website y el presente Aviso sobre Política de privacidad y protección de datos se rigen por la Ley Argentina.
';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>G &amp; L</title>
<style type="text/css">
*{font-family:Arial, Helvetica, sans-serif; font-size:14px;}
.cfx{clear:both;}
#prod_img{
	width:300px; float:left; margin-right:20px;
}
#prod_data{
	margin:auto;
}
#titulo{
	font-weight:bold;
	display:block;
	margin-bottom:10px;
}
#prod_data img{
	/*width:168px;
	height:71px;*/
	max-width:600px;
}
#prod_data .seccion_texto p, #prod_data .seccion_texto a{
	font-size:12px;
}
#prod_data .seccion_texto a{color:#666; text-decoration:underline; font-weight:bold;}
#prod_data .seccion_texto a:hover{color:#333;}
</style>
</head>

<body>
<div>
  <div id="prod_data">
   	  <span id="titulo"><?php echo $titulo; ?></span>
      <div class="seccion_texto"><?php echo $texto; ?></div>
      <?php echo $img; ?>
</div>
    <div class="cfx">&nbsp;</div>
</div>
</body>
</html>