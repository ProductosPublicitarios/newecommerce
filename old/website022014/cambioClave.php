<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$msj = $boton = '';
$userMail = $_SESSION['user_email'];

if($_POST){
	$conn = conn();
	$clave = md5(md5(mysql_real_escape_string($_POST['clave'], $conn)));
	$sql = "UPDATE usuariosx set xclavex='". $clave . "' WHERE email='" . $userMail ."'";
	$res = mysql_query($sql);
	if($res){
		session_start();
		$msj = "Clave cambiada con éxito para el usuario: " . $_SESSION['user_email'];
	}else{
		$msj = "Ha ocurrido un error, por favor intente nuevamente.";		
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
    font-size: 17px;
    height: 40px;
    position: center;
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
	$('#cambio_clave').click(validar);
});
function validar()
{
	var form = $('#form');
	var clave = $('#clave').val();
	var confirmacionClave = $('#confirmacionClave').val();
	
	if(clave==confirmacionClave){
		form.submit();
	}else{
		alert('La confirmación de la clave es diferente.');
	}
}
</script>
</head>

<body>
<div class="buy" style="width: 400px;height: 124px;">
    <!--buy-->
    <form name="form" id="form" action="cambioClave.php" class="bottom-form" method="post">
        <fieldset>
            <legend>
                Cambio de Clave
            </legend>
         
           <div class="row">
                <label for="name">
                    Clave
                </label>
                <span class="input-bottom"><input class="name" name="clave" id="clave" type="text" /></span>
            </div>
			 <div class="row">
                <label for="name">
                    Confirmar Clave
                </label>
                <span class="input-bottom"><input class="name" name="confirmacionClave" id="confirmacionClave" type="text" /></span>
            </div>
			<div class="cfx">&nbsp;</div><br />
            <input type="button" class="submit3" name="cambio_clave" id="cambio_clave" value="Cambiar Clave" />
        </fieldset>
    </form>
</div>
<div id="messagex" style="font-size:10px; color:#900; margin-left:20px;"><?php echo $msj; ?></div>
</body>
</html>