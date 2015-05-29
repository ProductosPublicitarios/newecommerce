<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 4;

if( isset($_POST['envio']) ){
	$conn = conn();
	$visible = $_POST['visible'];
	$titulo = mysql_real_escape_string($_POST['titulo']);
	$texto = mysql_real_escape_string($_POST['texto']);

	$valores = "'$visible', '$titulo', '$texto'";
	$s = "INSERT INTO novedades(visible,titulo,texto) VALUES($valores)";
	$r = mysql_query($s);
	if($r){
		$msj = 'La novedad ha sido cargada.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}



$options_visible = '<option value="1" selected="selected">Si</option>';
$options_visible .= '<option value="2">No</option>';
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
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
    <form name="edit" method="post" action="novedades_cargar.php">
    	<tr>
        	<th>visible</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
    	<tr>
        	<th>titulo</th>
            <td><input type="text" name="titulo" /></td>
        </tr>
        <tr>
        	<th>texto</th>
            <td><textarea name="texto"></textarea></td>
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