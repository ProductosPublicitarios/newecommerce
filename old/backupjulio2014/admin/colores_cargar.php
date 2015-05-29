<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 10;

$conn = conn();
if( isset($_POST['envio']) ){
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$hex = mysql_real_escape_string($_POST['hex']);

	$valores = "'$nombre', '$hex'";
	$s = "INSERT INTO colores(nombre,hex) VALUES($valores)";
	$r = mysql_query($s);
	if($r){
		$id = mysql_insert_id($conn);
		$msj = 'El color ha sido cargado.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<link rel="stylesheet" href="css/colorpicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script type="text/javascript" src="js/colorpicker/jquery.js"></script>
<script type="text/javascript" src="js/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="js/colorpicker/eye.js"></script>
<script type="text/javascript" src="js/colorpicker/utils.js"></script>
<script type="text/javascript" src="js/colorpicker/layout.js?ver=1.0.2"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#hex').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorshow').css('backgroundColor','#'+hex);
		$('#hex').val(hex);
	}
});
});
</script>
</head>
<body>
<div id="message"><?php echo $msj; ?></div>
<div id='cont'>
	<div id="header">
    	<div id="logo">&nbsp;</div>
	    <?php require('./incl/menu.php'); ?>
        <div class="cfx">&nbsp;</div>
    </div>
    <div id="contenidos">
    <table width="100%" cellpadding="3" cellspacing="1" border="0" class="lft">
    <form name="edit" method="post" action="colores_cargar.php">
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="nombre" value="<?php echo $nombre; ?>" /></td>
        </tr>
    	<tr>
        	<th>hex</th>
            <td id="colorin">#<input type="text" name="hex" id="hex" value="<?php echo $hex; ?>" class="xs" /></td>
        </tr>
        <tr>
        	<th>color</th>
            <td><span id="colorshow" style="display:block; width:50px; height:50px; background-color:#<?php echo $hex; ?>;"></span></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><input type="submit" name="envio" id="envio" value="CARGAR" /></th>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>