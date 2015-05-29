<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$msj = $boton = '';

if($_POST){
	$conn = conn();
	
	$nombre = mysql_real_escape_string($_POST['name'], $conn);
	$email = mysql_real_escape_string($_POST['email'], $conn);
	$empresa = mysql_real_escape_string($_POST['empresa'], $conn);
	$telefono = mysql_real_escape_string($_POST['tel'], $conn);
	$consulta = mysql_real_escape_string($_POST['consulta'], $conn);
	$news = mysql_real_escape_string($_POST['newsletter'], $conn);
	//$pre_clave = genClave($arr_char);
	//$clave = md5(md5($pre_clave));
	$clave = md5(md5(mysql_real_escape_string($_POST['clave'], $conn)));
	
	$fecha = date('Y-m-d H:i:s');
	
	$campos = "f_creacion,nombre,email,xusuariox,xclavex,empresa,telefono,detalles,newsletter,visible";
	$valores = "'$fecha','$nombre','$email','$email','$clave','$empresa','$telefono','$consulta','$news',1";
	
	// Check reg.
	$ssql = "SELECT * FROM usuariosx WHERE email='$email' OR xusuariox='$email'";
	$rres = mysql_query($ssql);
	if($rres){
		$nnr = mysql_num_rows($rres);
		if($nnr > 0){
			// Existe.
			$msj = "Ya existe un usuario con el email: $email, si ud ya está registrado ingrese su email y constraseña para loguearse.";
		}
		else
		{
			$sql = "INSERT INTO usuariosx ($campos) VALUES($valores)";
			$res = mysql_query($sql);
			if($res){
				require('controlls/class.phpmailer.php');
				$asunto = "Registro en GyL Enterprise.";
				$msg = $nombre . ", gracias por registrarse en nuestro sitio, cada vez que nos visite ingrese sus datos para ";
				$msg.= "acceder y poder solicitar cotizaciones online. \n\n<br /><br />";
				$msg .= "Sus datos de acceso son los siguientes: \n<br />";
				$msg .= "Usuario: $email \n<br />";
				$msg .= "Clave: $pre_clave\n\n<br /><br />";
				$msg .= "Ante cualquier duda por favor consultenos.";
			
				$envio = nuMail2('GyL Enterprise', MAIL_SITE, $email, '', '', $asunto, $msg, $msg);
				if($envio){
					$msj = "Ud ha sido registrado correctamente, revise su email para ver los datos de acceso.";
					$boton = 'disabled="disabled"';
					
					$id = mysql_insert_id($conn);
					$_SESSION['logged'] = true;
					$_SESSION['user_id'] = $id;
					$_SESSION['user_name'] = $nombre;
					$_SESSION['user_email'] = $email;
				}else{
					$msj = "Ha ocurrido un error, por favor intente nuevamente.";		
				}
			}else{
				$msj = "Ha ocurrido un error, por favor intente nuevamente.";		
			}			
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GyL</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/cufon-fonts.js"></script>
<script type="text/javascript" src="js/cufon-settings.js"></script>
<!--link rel="stylesheet" type="text/css" href="css/all.css" /-->
<style type="text/css">
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, hr, button {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    vertical-align: baseline;
}
body {
	background-color: #dde3dd;
}
ol, ul {
    list-style: none;
}

h1, h2, h3, h4, h5, h6, li {
    line-height: 100%;
}

blockquote, q {
    quotes: none;
}

q:before, q:after {
    content: '';
}

table {
    border-collapse: collapse;
    border-spacing: 0;
}

html, body {
    margin: 0;
    padding: 0;
    min-height: 100%;
    font-family: Arial;
}

input, textarea, select {
    font: 11px Arial, Helvetica, sans-serif;
    padding: 0;
    margin: 0;
    border: 0px;
}

form, fieldset {
    border-style: none;
    float: none;
}

a {
    text-decoration: none
}

.buy {
    background-color: #DDE3DD;
    /*float: right;*/
    width: 300px;
    padding-bottom: 39px;
}

form.bottom-form.sub {
    background-color: #DADFD9;
    margin: 0;
    padding: 0 0 39px 13px;
}

form.bottom-form.sub legend {
    text-indent: 84px;
	border:0;
}

form.bottom-form.sub #ot {
    float: right;
    font-size: 11px;
    margin: -48px 22px 0 0;
    width: 120px;
}


form.bottom-form {
    margin: 18px 0 0 8px;
    position: relative;
}

form.bottom-form legend {
    text-indent: 61px;
}

form.bottom-form label {
    color: #006325;
    font-size: 12px;
    width: 70px;
    display: block;
    float: left;
}

form.bottom-form .row {
    margin: 10px 0 -2px 8px;
    overflow: hidden;
    width: 248px;
    float: left;
}

form.bottom-form .row label {
}

form.bottom-form .row span.input-bottom {
    display: block;
    float: right;
    width: 175px;
    height: 23px;
    background: url("./images/input4.png") no-repeat top center;
}

form.bottom-form .row span.input-bottom.sub {
    width: 132px;
    height: 23px;
    background: url("./images/input3.png") no-repeat top center;
}

form.bottom-form .row span.input-bottom input {
    background: none;
    width: 132px;
    height: 23px;
}

form.bottom-form .row #excp {
    width: 110px;
}

form.bottom-form span.textarea-bottom {
    background: url("./images/input5.png") no-repeat scroll center top transparent;
    float: right;
    height: 54px;
    width: 175px;
}

form.bottom-form span.textarea-bottom {
    background: url("./images/input8.jpg") no-repeat scroll center top transparent;
    float: right;
    height: 106px;
    width: 178px;
}

form.bottom-form span.textarea-bottom textarea {
    background: none;
   height: 106px;
    width: 179px;
}

form.bottom-form .row.sub {
    height: 17px;
    margin: 5px 0 0 8px;
    overflow: visible;
    width: 190px;
}

form.bottom-form.sub .row.sub {
    height: 17px;
    margin: 16px 0 0 8px;
    overflow: visible;
    width: 190px;
}

form.bottom-form .row.sub label {
    width: auto;
}

form.bottom-form .row.sub span.submit2 {
    background: url("images/btn2.png") no-repeat scroll center 3px transparent;
    float: right;
    height: 25px;
    width: 95px;
    color: #fff;
	display:block;
	overflow:hidden;
	padding:0px;
	
}
*+ html form.bottom-form .row.sub span.submit2{
   padding:1px 0 0 0;
}
form.bottom-form .row.sub span.submit2 input {
    background: none repeat scroll 0 0 transparent;
    color: #FFFFFF;
    height: 22px;
    line-height: 5px;
    padding: 0 9px;
    width: 86px;
	display:block;
}

form.bottom-form #opt {
    font-size: 10px;
    margin: 7px 0 0 6px;
    width: auto;
}

form.bottom-form .radio {
    clear: both;
    padding: 15px 0 0 6px;
    overflow: hidden;
	width:85px;
}

form.bottom-form .radio span {
    font-size: 12px;
    color: #006325;
	float:left;
    width: auto;
}
form.bottom-form.sub .radio {
    clear: none;
    float: right;
    margin: -10px 0 0;
    overflow: hidden;
    padding: 0 38px 0 0;
    width: 85px;
}

form.bottom-form .radio input.radio {
    clear: none;
    float: left;
    margin: 0;
    overflow: visible;
    margin: 0 8px 0 0;
	width:auto;
	padding:0px;
}

form.bottom-form input.submit3 {
    background-color: #FFD300;
    bottom: -15px;
    font-size: 17px;
    height: 40px;
    position: absolute;
    right: 54px;
    width: 127px;
}

form.bottom-form.sub input.submit3 {
    bottom: 15px;
    height: 33px;
    right: 45px;
    width: 89px;
}
.buy form.bottom-form .row{
	width:95%;
}
.buy form.bottom-form .row label{
	width:120px;
}
.buy form.bottom-form .row .input-bottom, .buy form.bottom-form .row .textarea-bottom{
	text-align:left;
	float:left;
}
.buy form.bottom-form label#opt
{
	margin-top:20px;
	float:left;
	display:inline;
	clear:none;
	margin-right:20px;
	margin-bottom:0px;
}
.buy form.bottom-form .radio
{
	float:left;
	display:inline;
	clear:none;
	margin-bottom:0px;
}
.buy .bottom-form #envio_cotizar{
	float:left;
	clear:both;
	display:inline;
	margin:0;
	padding:0;
	left:10px;
	top:0px;
	position:relative;
}
.cfx{clear:both};
div#messagex{
	margin-left:10px;
	font-weight:bold;
	color:#900;
	font-size:10px;
	border:1px solid red;
	display:block;
	width:90%;
}
</style>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#envio_cotizar').click(validar);
});
function validar()
{
	var form = $('#form');
	var name = $('#name').val();
	var email = $('#email').val();
	
	if(name!='' && email!='' && isValidEmail(email)){
		form.submit();
	}else{
		alert('Complete al menos email y nombre');
	}
}

function isValidEmail(str){
	var regex = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if(str.search(regex) == -1){
		return false;
	}
	return true; 
}
</script>
</head>

<body>
<div class="buy" style="width:350px;">
    <!--buy-->
    <form name="form" id="form" action="registro.php" class="bottom-form" method="post">
        <fieldset>
            <legend>
                REGISTRO
            </legend>
            <div class="row">
                <label for="name">
                    Nombre y Apellido
                </label>
                <span class="input-bottom"><input class="name" name="name" id="name" type="text" /></span>
            </div>
            <div class="row">
                <label for="email">
                    Email
                </label>
                <span class="input-bottom"><input name="email" id="email" type="text" /></span>
            </div>
			  <div class="row">
                <label for="email">
                    Clave
                </label>
                <span class="input-bottom"><input name="clave" id="clave" type="password" /></span>
            </div>
			  <div class="row">
                <label for="email">
                    Confirmar Clave
                </label>
                <span class="input-bottom"><input name="confirmacionClave" id="confirmacionClave" type="password" /></span>
            </div>
            <div class="row">
                <label for="empresa">
                    Empresa
                </label>
                <span class="input-bottom"><input name="empresa" id="empresa" type="text" /></span>
            </div>
            <div class="row">
                <label for="tel">
                    Tel&eacute;fono
                </label>
                <span class="input-bottom"><input name="tel" id="tel" type="text" /></span>
            </div>
            <!--div class="row">
                <label id="excp" for="como">
                    Como nos conoci&oacute; 
                </label>
                <span class="input-bottom sub"><input id="como" name="como" type="text" /></span>
            </div-->
            <div class="row">
                <label for="consulta">
                    Mensaje
                </label>
                <span class="textarea-bottom">
                    <textarea name="consulta" id="consulta" rows="" cols=""></textarea>
                </span>
            </div>
            <!--div class="row sub">
                <label for="examinar">
                    Adjuntar Archivo
                </label>
                <span class="submit2"><input type="submit" value="Examinar..."/></span>
            </div-->
            <label id="opt" for="si">
                Desea suscribirse a nuestro newsletter
            </label>
            <div class="radio">
                <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="newsletter" value="1" checked="checked" /><span>No</span><input class="radio" type="radio" name="newsletter" value="0" />
            </div><!-- end radio-->
            <div class="cfx">&nbsp;</div><br />
            <input type="button" class="submit3" name="envio_cotizar" id="envio_cotizar" value="Enviar" <?php echo $boton; ?> />
        </fieldset>
    </form>
</div>
<div id="messagex" style="font-size:10px; color:#900; margin-left:20px;"><?php echo $msj; ?></div>
</body>
</html>