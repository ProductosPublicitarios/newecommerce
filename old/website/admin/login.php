<?php
require("./incl/bdd.php");
require("./incl/functions.php");
$msj = '';
if( isset($_POST['usuario']) and trim($_POST['usuario'])!= '')
{
	$msj = 'inn';
	$conn = conn();
	$usu = mysql_real_escape_string($_POST['usuario'], $conn);
	$pas = mysql_real_escape_string($_POST['clave'], $conn);
	$pass = md5(md5($pas));
	$sql = "SELECT id FROM usuariosx WHERE xusuariox='$usu' AND xclavex='$pass' AND visible=1";
	$res = mysql_query($sql, $conn);
	
	if(!$res){
		$msj = 'Error, datos incorrectos.';
	}else{
		$cant_res = mysql_num_rows($res);
		if($cant_res <= 0){
			$msj = 'Error, datos incorrectos.';
		}else{
			$row = mysql_fetch_assoc($res);
			session_start();
			$_SESSION['logged'] = true;
			header('Location: ./');
		}
	}
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<script language='javascript' type='text/javascript'>
function init()
{
	var b = document.getElementById('envio');
	b.onclick = valid;
}
function valid()
{
	var error = false;
	var m = document.getElementById('message');
	var form = document.getElementById('form');
	var usuario = document.getElementById('usuario').value;
	var clave = document.getElementById('clave').value;
	
	if( usuario.length < 6 || clave.length < 6 )
	{
		error = true;
	}
	
	if(error){
		m.innerHTML = 'Complete todos los campos';
	}else{
		form.submit();
	}
}
window.onload = init;
</script>
<style type="text/css">
.cfx{clear:both};
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333;
}
body {
	background-color: #ffffff;
	background-image: url(img/bg.jpg);
	background-repeat: repeat-x;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#cont{
	position:absolute;
	width:500px;
	height:240px;
	background-color:#fff;
	top:50%;
	left:50%;
	margin-top: -120px;
	margin-left: -250px;
}
	#logo{
		width:99px;
		height:63px;
		background-image:url(img/logo.png);
		background-repeat:no-repeat;
		margin:auto;
		margin-top:20px;
		margin-bottom:20px;
	}
form{
	width:300px;
	margin:auto;
}
input{
	padding:2px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	height:16px;
	float:right;
	width:196px;
}
label{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	display:block;
	width:80px;
	height:18px;
	margin-bottom:10px;
	margin-right:4px;
	padding:2px;
	background-color:#E4EBE2;
	float:left;
}
#envio{
	width:100px;
	height:20px;
	margin-top:10px;
	color:#333;
	background-color:#c0d4c0;
	border:1px solid #aaa;
}
#envio:hover{background-color:#619365;color:#fff;}
#message{
	color:#076324;
	font-weight:bold;
	text-align:center;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	margin-bottom:10px;
}
</style>
</head>
<body>
<div id='cont'>
	<div id="logo">&nbsp;</div>
    <div id="message"><?php echo $msj; ?></div>
    <form name="form" id="form" method="post" action="login.php">
    	<label for="usuario">usuario:</label> <input type="text" name="usuario" id="usuario" /><br />
        <span class="cfx">&nbsp;</span>
        <label for="clave">clave:</label> <input type="password" name="clave" id="clave" />
        <span class="cfx">&nbsp;</span>
        <input type="button" id="envio" value="Ingresar" />
    </form>
</div>
</body>
</html>