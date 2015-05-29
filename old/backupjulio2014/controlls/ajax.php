<?php
require('bdd.php');
require('varios.php');
require('functions.php');

if(!$_POST){
	die('aaa');
}else{
	$conn = conn();
	$f = $_POST['_f'];
	call_user_func($f, $conn);
}

function br2nl($s)
{
	$code = 'x83sxX983X';
		$str = str_replace("\r\n", $code, $s);
		$str = str_replace("\n\r", $code, $str);
		$str = str_replace("\r", $code, $str);
		$str = str_replace("\n", $code, $str);
		
		$str = str_replace("<br/>", $code, $str);
		$str = str_replace("<br />", $code, $str);
		$str = str_replace("<br >", $code, $str);
		$str = str_replace("<br>", $code, $str);

	return $str;
}

function code2br($s)
{
	$code = 'x83sxX983X';
	$str = str_replace($code, "<br>", $s);
	return $str;
}
function code2nl($s)
{
	$code = 'x83sxX983X';
	$str = str_replace($code, "\n", $s);
	return $str;
}

function login($conn)
{
	$out = false;
	$usuario = mysql_real_escape_string($_POST['usuario'], $conn);
	$clave = md5(md5(mysql_real_escape_string($_POST['clave'], $conn)));
	
	$sql = "SELECT id,nombre FROM usuariosx WHERE email='$usuario' AND xclavex='$clave' AND visible=1 AND admin=0";
	$res = mysql_query($sql);
	if($res){
		$num = mysql_num_rows($res);
		if($num > 0){
			$row = mysql_fetch_array($res);
			$id = $row['id'];
			$nombre = $row['nombre'];
			$apellido = $row['apellido'];
			
			session_start();
			$_SESSION['logged'] = true;
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name'] = $nombre.' '.$apellido;
			$_SESSION['user_email'] = $usuario;
			$out = $nombre.' '.$apellido;
		}else{
			$out = '0r';
		}
	}
	die($out);
}

function contactar($conn)
{
	$out = false;
	$fecha = date('d-m-Y H:i:s');
	$fechax = date('Y-m-d H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];	
	$nombre = mysql_real_escape_string($_POST['nombre'], $conn);
	$empresa = mysql_real_escape_string($_POST['empresa'], $conn);
	$email = mysql_real_escape_string($_POST['email'], $conn);
	$telefono = mysql_real_escape_string($_POST['telefono'], $conn);
	$como = mysql_real_escape_string($_POST['como'], $conn);
	$consulta = $_POST['consulta'];
	$consulta_code = br2nl($consulta);
	$consulta_nl = utf8_decode($consulta_code);
	$consulta_br = utf8_decode($consulta_code);
	$consulta_db = code2br(mysql_real_escape_string($consulta_br, $conn));
	$news = $_POST['news']=='1'?'Si':'No';
	$pre_clave = genClave($arr_char);
	$clave = md5(md5($pre_clave));
	
	$escli = $_POST['escliente']=='1'?'Si':'No';
	$escliente = mysql_real_escape_string($_POST['escliente'], $conn);
	
	if($news == 'Si'){
		$campos = "f_creacion,nombre,email,xusuariox,xclavex,empresa,telefono,detalles,newsletter,visible,escliente";
		$valores = "'$fechax','$nombre','$email','$email','$clave','$empresa','$telefono','$consulta_db',1,0,$escliente";
		
		$sql = "INSERT INTO usuariosx ($campos) VALUES($valores)";
		$res = mysql_query($sql);
	}
	
	require('class.phpmailer.php');

	$asunto = "Formulario de Contacto GyL Enterprise.";
	$msg = "Datos completados por el Usuario: <br>";
	$msg .= "Nombre: ".utf8_decode($nombre)." <br>";
	$msg .= "Email: ".utf8_decode($email)." <br>";
	$msg .= "Empresa: ".utf8_decode($empresa)." <br>";
	$msg .= "Telefono: ".utf8_decode($telefono)." <br>";
	$msg .= "Como nos conocio: ".utf8_decode($como)." <br>";
	$msg .= "Suscribirse al newsletter: $news <br>";
	$msg .= "Es cliente: $escli <br>";
	$msg .= "Consulta: ".$consulta_db." <br>";
	$msg .= "Este email ha sido enviado el $fecha desde el IP: $ip <br>";
	
	$msgAlt = "Datos completados por el Usuario: \n";
	$msgAlt .= "Nombre: ".utf8_decode($nombre)." \n";
	$msgAlt .= "Email: ".utf8_decode($email)." \n";
	$msgAlt .= "Empresa: ".utf8_decode($empresa)." \n";
	$msgAlt .= "Telefono: ".utf8_decode($telefono)." \n";
	$msgAlt .= "Como nos conocio: ".utf8_decode($como)." \n";
	$msgAlt .= "Suscribirse al newsletter: $news \n";
	$msgAlt .= "Es cliente: $escli \n";
	$msgAlt .= "Consulta: ".code2nl(mysql_real_escape_string($consulta_nl, $conn))." \n";
	$msgAlt .= "Este email ha sido enviado el $fecha desde el IP: $ip \n";
	
	

	$envio = nuMail2(utf8_decode($nombre), $email, MAIL_SITE, '', '', $asunto, $msg, $msgAlt);
	if($envio){
		$out = true;
	}
	die($out);
}

function add_cart()
{
	$prods = '';
	$q = intval($_POST['q']);
	$id = intval($_POST['id']);
	$xmin = intval($_POST['xmin']);
	$name = $_POST['na'];
	
	if( $q!=0 and $id!=0 ){
		if( array_key_exists($id, $_SESSION['prods']) ){
			$_SESSION['prods'][$id] += $q;
			$prods = "existe,".$_SESSION['prods'][$id];
		}else{
			$_SESSION['prods'][$id] = $q;
			$_SESSION['prods_name'][$id] = $name;
			$_SESSION['prods_min'][$id] = $xmin;
			$prods = "noexiste";
		}
		/*foreach($_SESSION['prods'] as $key=>$val){
			if($val != 0){
				$prods .= "<li>".$_SESSION['prods_name'][$key] . ' ('.$val.') <a href=\\"#\\" onclick=\\"removeProd(\''.$key.'\')\\">[X]</a></li>';
			}
		}*/
		die($prods);
	}else{
		die(false);
	}
}
function remove_cart()
{
	$prods = '';
	$id = intval($_POST['id']);
	
	if( array_key_exists($id, $_SESSION['prods']) ){
		unset($_SESSION['prods'][$id]);
		unset($_SESSION['prods_name'][$id]);
		die('ok');
	}else{
		die(false);
	}
}
?>