<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

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

$msj = $boton = '';
$ERROR = false;
if($_POST){
	$conn = conn();
	
	// REGISTRO.
	$fecha = date('Y-m-d H:i:s');
	require('controlls/class.phpmailer.php');
	if(!$_SESSION['logged']){
		$nombre = mysql_real_escape_string($_POST['name'], $conn);
		$email = mysql_real_escape_string($_POST['email'], $conn);
		$empresa = mysql_real_escape_string($_POST['empresa'], $conn);
		$telefono = mysql_real_escape_string($_POST['tel'], $conn);
		
		$consulta = $_POST['consulta'];
		$consulta_code = br2nl($consulta);
		$consulta_nl = utf8_decode($consulta_code);
		$consulta_br = utf8_decode($consulta_code);
		$consulta_db = code2br(mysql_real_escape_string($consulta_br, $conn));
		
		$news = mysql_real_escape_string($_POST['newsletter'], $conn);
		$escliente = mysql_real_escape_string($_POST['escliente'], $conn);
		$estampar = mysql_real_escape_string($_POST['estampar'], $conn);
		$pre_clave = genClave($arr_char);
		$clave = md5(md5($pre_clave));
		
		$campos = "f_creacion,nombre,email,xusuariox,xclavex,empresa,telefono,detalles,newsletter,visible,escliente";
		$valores = "'$fecha','$nombre','$email','$email','$clave','$empresa','$telefono','$consulta_db','$news',1, '$escliente'";
		
		// Check reg.
		$ssql = "SELECT * FROM usuariosx WHERE email='$email' OR xusuariox='$email' LIMIT 1";
		$rres = mysql_query($ssql);
		if($rres){
			$nnr = mysql_num_rows($rres);
			if($nnr > 0){
				// Existe.
				$msj = "Ya existe un usuario con el email: $email, si ud ya está registrado ingrese su email y constraseña para loguearse.";
				$rrow = mysql_fetch_assoc($rres);
				
				$id_usuario = $rrow['id'];
				$nombre = $rrow['nombre'];
				$email = $rrow['email'];
				$xusuariox = $rrow['xusuariox'];
				$empresa = $rrow['empresa'];
				$telefono = $rrow['telefono'];
				$consulta = $rrow['detalles'];
				$newsletter = $rrow['newsletter'];
				$escliente = $rrow['escliente'];
				$visible = $rrow['visible'];
				
				$_SESSION['logged'] = true;
				$_SESSION['user_id'] = $id_usuario;
				$_SESSION['user_name'] = $nombre;
				$_SESSION['user_email'] = $email;
				
			}
			else
			{
				$sql = "INSERT INTO usuariosx ($campos) VALUES($valores)";
				$res = mysql_query($sql);
				if($res){
					$id_usuario = mysql_insert_id($conn);
					$asunto = "Registro en GyL Enterprise.";
					
					$msg = $nombre . ", gracias por registrarse en nuestro sitio, cada vez que nos visite ingrese sus datos para ";
					$msg.= "acceder y poder solicitar cotizaciones online. <br><br>";
					$msg .= "Sus datos de acceso son los siguientes: <br>";
					$msg .= "Usuario: $email <br>";
					$msg .= "Clave: $pre_clave <br>";
					$msg .= "Ante cualquier duda por favor consultenos.";
					
					$msgAlt = $nombre . ", gracias por registrarse en nuestro sitio, cada vez que nos visite ingrese sus datos para ";
					$msgAlt.= "acceder y poder solicitar cotizaciones online. \n\n";
					$msgAlt .= "Sus datos de acceso son los siguientes: \n";
					$msgAlt .= "Usuario: $email \n";
					$msgAlt .= "Clave: $pre_clave\n\n";
					$msgAlt .= "Ante cualquier duda por favor consultenos.";
				
					$envio = nuMail2('GyL Enterprise', MAIL_SITE, $email, '', '', $asunto, $msg, $msgAlt);
					if($envio){
						$msj = "Ud ha sido registrado correctamente, revise su email para ver los datos de acceso.";
						$boton = 'disabled="disabled"';
						
						
						$_SESSION['logged'] = true;
						$_SESSION['user_id'] = $id_usuario;
						$_SESSION['user_name'] = $nombre;
						$_SESSION['user_email'] = $email;
					}else{
						$ERROR = true;
						$msj = "Ha ocurrido un error, por favor intente nuevamente.";		
					}
				}else{
					$ERROR = true;
					$msj = "Ha ocurrido un error, por favor intente nuevamente.";		
				}
			}
		}
	}
	
	//$descripcion = mysql_real_escape_string($_POST['descripcion'], $conn);
	$descripcion = $_POST['descripcion'];
	$descripcion_code = br2nl($descripcion);
	$descripcion_nl = utf8_decode($descripcion_code);
	$descripcion_br = utf8_decode($descripcion_code);
	$descripcion_db = code2br(mysql_real_escape_string($descripcion_br, $conn));
	
	
	$estamp_string = $estampar == 1 ? 'Si' : 'No';
	$descripcion_db.= " Estampar productos: " . $estamp_string;
	$desc_final = code2nl(mysql_real_escape_string($descripcion_nl, $conn));
	$desc_final.= " Estampar productos: " . $estamp_string;
	
	$sql_ped = "INSERT INTO pedidos (id_usuario,fecha,descripcion) VALUES('".$_SESSION['user_id']."', '$fecha', '$descripcion_db')";
	$res_ped = mysql_query($sql_ped);
	
	if($res_ped){
		$id_pedido = mysql_insert_id($conn);
	
		// Productos + Pedido
		$campos_valores = '';
		$prods_string = '';
		foreach($_POST as $k=>$v){
			$ini = substr($k,0,2);
			if($ini=='p_'){
				$id_actual = substr($k,2);
				$nombre_actual = $_POST['n_'.$id_actual];
				//echo "ID:".$id_actual." Q:".$v." NAME:".$nombre_actual."<br />";
				$campos_valores .= "($id_pedido,$id_actual,$v), ";
				$prods_string .= utf8_decode("Producto $nombre_actual")." | Cantidad: $v <br>";
				$prods_stringAlt .= utf8_decode("Producto $nombre_actual")." | Cantidad: $v \n";
				
			}/*elseif($ini=='n_'){
				$nombre_actual = $v;
			}*/
		}
		$prods_string .= "Estampar: $estamp_string <br><br>";
		$prods_stringAlt .= "Estampar: $estamp_string \n\n";
		$prods_string .= "Descripcion: $descripcion_db <br><br>";
		$prods_stringAlt .= "DescripcionX: ".$desc_final." \n\n";
		
		$campos_valores = substr($campos_valores, 0, -2);
		//echo "$campos_valores<br />";
		
		$vend_nombre = $vend_email = '';
		
		$sqlv = "SELECT nombre,email FROM vc LEFT JOIN vendedores v ON v.id=vc.id_vendedor WHERE vc.id_cliente=".$_SESSION['user_id'];
		$resv = mysql_query($sqlv);
		if($resv){
			$nrv = mysql_num_rows($resv);
			if( $nrv > 0 ){
				$rowv = mysql_fetch_assoc($resv);
				$vend_nombre = $rowv['nombre'];
				$vend_email = $rowv['email'];
			}
		}
		
		
		$sql2 = "INSERT INTO pedidos_productos (id_pedido,id_producto,cantidad) VALUES $campos_valores";
		$res2 = mysql_query($sql2);
		if($res2){
			$msj = "Su cotización ha sido enviada, nos contactaremos a la brevedad.";
			unset($_SESSION['prods']);
			unset($_SESSION['prods_name']);
			
			$asunto = "Nueva Cotizacion";
			$msg = "Se ha realizado un nuevo pedido de cotizacion. <br>";
			$msg.= "Se detalla a continuacion los productos solicitados <br>";
			
			$msgAlt = "Se ha realizado un nuevo pedido de cotizacion. \n";
			$msgAlt.= "Se detalla a continuacion los productos solicitados \n";
			
			$msg.= $prods_string;
			$msgAlt.= $prods_stringAlt;
			
			
			$id_usuario_check = $_SESSION['user_id'];
			$su = "SELECT * FROM usuariosx WHERE id='$id_usuario_check' LIMIT 1";
			$ru = mysql_query($su);
			if($ru){
				$rou = mysql_fetch_assoc($ru);
				$nombre = $rou['nombre'];
				$empresa = $rou['empresa'];
				$email = $rou['email'];
				$telefono = $rou['telefono'];
				$consulta_db = $rou['detalles'];
				$news_string = $rou['newsletter']==1?'Si':'No';
				$escliente = $rou['escliente'];
			}
			
			if( $escliente == 1 ){
				$msg.= "El usuario que realizo el pedido es cliente y sus datos son: <br>";
				$msgAlt.= "El usuario que realizo el pedido es cliente y sus datos son: \n";
			}else{
				$msg.= "El usuario que realizo el pedido no es cliente y sus datos son: <br>";
				$msgAlt.= "El usuario que realizo el pedido no es cliente y sus datos son: \n";
			}
			
			
			
			
			$news_string = $news==1 ? 'Si' : 'No';
			$msg.= "Nombre: ".utf8_decode($nombre)." <br>";
			$msgAlt.= "Nombre: ".utf8_decode($nombre)." \n";
			$msg.= "Empresa: ".utf8_decode($empresa)." <br>";
			$msgAlt.= "Empresa: ".utf8_decode($empresa)." \n";
			$msg.= "Email: ".utf8_decode($email)." <br>";
			$msgAlt.= "Email: ".utf8_decode($email)." \n";
			$msg.= "Telefono: ".utf8_decode($telefono)." <br>";
			$msgAlt.= "Telefono: ".utf8_decode($telefono)." \n";
			$msg.= "Consulta: ".$consulta_db." <br>";
			$msgAlt.= "Consulta: ".code2nl(mysql_real_escape_string($consulta_nl, $conn))." \n";
			$msg.= "Suscribirse al newsletter: ".utf8_decode($news_string)." <br><br>";
			$msgAlt.= "Suscribirse al newsletter: ".utf8_decode($news_string)." \n\n";
			

			
			if( $vend_nombre != '' ){
				$msg.= "El ejecutivo de cuentas que se encarga del cliente es: <br>";
				$msgAlt.= "El ejecutivo de cuentas que se encarga del cliente es: \n";
				
				$msg.= "Nombre: ".utf8_decode($vend_nombre)." <br>";
				$msgAlt.= "Nombre: ".utf8_decode($vend_nombre)." \n";
				$msg.= "Email: ".utf8_decode($vend_email)." <br><br>";
				$msgAlt.= "Email: ".utf8_decode($vend_email)." \n\n";
			}else{
				$msg.= "Este cliente no tiene ejecutivo de cuentas asignado. <br>";
				$msgAlt.= "Este cliente no tiene ejecutivo de cuentas asignado. \n";
			}
			
			
			$msg.= "Para ver mas informacion del pedido recuerde que puede hacerlo desde su adminsitrador.";
			$envio = nuMail2('GyL Enterprise', MAIL_SITE, MAIL_SITE, '', '', $asunto, $msg, $msgAlt);
		}else{
			$msj = "Ha ocurrido un error, por favor intente nuevamente.";
			$ERROR = true;
		}
	}else{
		$msj = "Ha ocurrido un error, por favor intente nuevamente.";
		$ERROR = true;
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GyL</title>
<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/cufon-fonts.js"></script>
<script type="text/javascript" src="js/cufon-settings.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'width'			:	660, 
		'height'		:	440,
		'type'			:	'iframex2'
	});
});
</script>
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
form.bottom-form .row span.input-bottomx {
    display: block;
    float: right;
    width: 90px;
    height: 23px;
    background: url("./images/input_smx.png") no-repeat;
}
.buy #form .row .input-bottomx .quantity{
	text-align:center;
	width:80px;
	margin-top:3px;
	background:none;
	margin-left:2px;
	margin-right:2px;
}
.buy #form .row label{
	width:240px;
	margin-top:2px;
}

#labelon{
	width:380px !important;
}
#labelon .radio.int{
	width:380px !important;
}
#labelon #termsx{
	width:320px !important;
	font-size:11px !important;
	float:left;
	color:#006325 !important;
}
#labelon #termsx.iframe{
	width:330px !important;
}
#labelon #terms, .buy #labelon #terms:visited{
	display:block;
	width:20px;
	float:left;
}
</style>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#envio_cotizar').click(validar);
});
function validar()
{
	var error = false;
	var errorCant = false;
	var errorCli = false;
	var errorEst = false;
	var errorTerms = false;
	var msjCant = "Revise las cantidades mínimas de su pedido. \n";
	var terms = $('#terms').is(':checked')?1:0;
	var form = $('#form');
	
	<?php if(!$_SESSION['logged']){ ?>
	var name = $('#name').val();
	var email = $('#email').val();
	
	if(name=='' || email=='' || !isValidEmail(email) ){
		error = true;
	}
	<?php } ?>
	
	// Cantidades minimas.
	$('#form :input').each(function(i, n){
		type = $(this).attr('type');
		if( type == 'hidden' ){
			id = $(this).attr('id');
			first = id.substr(0, 2);
			if( first == 'm_' ){
				min_key = id.substr(2);
				min_value = $(this).val();
				user_value = $('#p_'+min_key).val();
				/*if( parseInt(min_value) > parseInt(user_value) ){
					msjCant += "- La cantidad mínima para "+$('#n_'+min_key).val()+" es de "+min_value+" unidades. \n";
					errorCant = true;
				}*/
			}
		}
		
	});
	
	if( !$('#cliente_1').attr('checked') && !$('#cliente_2').attr('checked') ){
		errorCli = true;
	}
	
	if( !$('#estampar_1').attr('checked') && !$('#estampar_0').attr('checked') ){
		errorEst = true;
	}
	if( ! terms ){
		errorTerms = true;
	}
	
	if(errorCant){
		alert(msjCant);
	}else{
		if(error){
			alert('Complete al menos email y nombre e indique si es cliente');
		}else if(errorCli){
			alert('Indique si es cliente');
		}else if(errorEst){
			alert('Indique si desea el servicio de estampado o bordado');
		}else if(errorTerms){
			alert('Debe aceptar las políticas de privacidad');
		}else{
			form.submit();
		}
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
<?php if( count($_SESSION['prods']) > 1 or $_POST){ ?>
    <!--buy-->
    <form name="form" id="form" action="cotizar.php" class="bottom-form" method="post">
        <fieldset>
            <legend>
                COTIZAR
            </legend>
<?php if( ($ERROR and $_POST) or !$_POST ){?>            
            <div style="font-size:10px; margin-top:10px;">Modifique la cantidad de los productos si es necesario.</div>
            <?php // Listado de Productos
			if( is_array($_SESSION['prods'])){ foreach($_SESSION['prods'] as $k=>$v){ if($v!=0){
				?>
                <div class="row">
                	<label for="p_<?php echo $k; ?>"><?php echo $_SESSION['prods_name'][$k]; ?></label>
                	<span class="input-bottomx"><input class="quantity" name="p_<?php echo $k; ?>" id="p_<?php echo $k; ?>" type="text" value="<?php echo $v; ?>" />
                    <input type="hidden" id="n_<?php echo $k; ?>" name="n_<?php echo $k; ?>" value="<?php echo $_SESSION['prods_name'][$k]; ?>" />
                    <input type="hidden" id="m_<?php echo $k; ?>" name="mmm[<?php echo $k; ?>]" value="<?php echo $_SESSION['prods_min'][$k]; ?>" /></span>
            	</div>
                <?php
			}}}
			?>
            <div class="cfx" style="height:20px;">&nbsp;</div>
            <div style="font-size:10px; margin-bottom:10px;">
            <span style="float:left; margin-right:6px">Desea incluir el servicio de estampado o bordado</span>
            	<label for="estampar_1" style="width:40px;"><input type="radio" name="estampar" id="estampar_1" value="1" /> Si</label>
                <label for="estampar_0"><input type="radio" name="estampar" id="estampar_0" value="0" /> No</label><br />
            </div>
            <div style="font-size:10px; margin-bottom:10px;">Si lo desea escriba comentarios adicionales sobre el detalle del pedido</div>
            <textarea name="descripcion" id="comm" style="width:360px; height:70px;"></textarea>
            
            <?php if(!$_SESSION['logged']){ ?>
            <div class="cfx" style="height:20px;">&nbsp;</div>
            <legend>
                Datos Personales
            </legend>
            <div class="row">
                <label for="name">Nombre y Apellido</label>
                <span class="input-bottom"><input class="name" name="name" id="name" type="text" /></span>
            </div>
            <div class="row">
                <label for="email">
                    Email
                </label>
                <span class="input-bottom"><input name="email" id="email" type="text" /></span>
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
                <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="newsletter" value="1"  /><span>No</span><input class="radio" type="radio" name="newsletter" value="0" checked="checked" />
            </div><!-- end radio-->
            <?php } ?>
            <label id="opt" for="si">
                ¿Usted ya es cliente de nuestra empresa?
            </label>
            <div class="radio">
                <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="escliente" id="cliente_1" value="1"  /><span>No</span><input class="radio" type="radio" id="cliente_2" name="escliente" value="0" />
            </div>
            <div id="labelon" class="radio int" style="float:left;">
                <!--radio--><input class="radio" type="checkbox" name="terms" id="terms" value="1" /> 
                <a id="termsx" target="_blank" href="politicas.php">Es obligatorio leer y aceptar las políticas de privacidad</a>
                <div style="clear:both;">&nbsp;</div>                  
            </div>
            <div class="cfx">&nbsp;</div><br />
            <input type="button" class="submit3" name="envio_cotizar" id="envio_cotizar" value="Enviar" <?php echo $boton; ?> />
<?php } ?>
        </fieldset>
    </form>
</div>
<div id="messagex" style="font-size:10px; color:#900; margin-left:20px;"><?php echo $msj; ?>

<!-- Google Code for GyL Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 997668516;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "t-0bCNTOmQMQpO3c2wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/997668516/?value=0&amp;label=t-0bCNTOmQMQpO3c2wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


-- 
</div>
<?php }else{ ?>
<div id="messagex" style="font-size:10px; color:#900; margin-left:20px; margin-top:30px;">No tiene productos en su carro.</div>
<?php } ?>
</body>
</html>