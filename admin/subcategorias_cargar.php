<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 12;

if( isset($_POST['envio']) ){
	$conn = conn();
	$orden = mysql_real_escape_string($_POST['orden']);
	//$visible = $_POST['visible'];
	$id_categoria = $_POST['id_categoria'];
	$titulo = mysql_real_escape_string($_POST['titulo']);

	$valores = "'$orden', '$titulo', '$id_categoria'";
	$s = "INSERT INTO subcategorias(orden,titulo,id_categoria) VALUES($valores)";
	$r = mysql_query($s);
	if($r){
		$id = mysql_insert_id($conn);
		$msj = 'La subcategoria ha sido cargada.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$options_visible = '<option value="1" selected="selected">Si</option>';
$options_visible .= '<option value="2">No</option>';

foreach($arr_categorias as $k=>$v){
	$options_categoria .= "<option value='$k'>$v</option>";
}
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
    <form name="edit" method="post" action="subcategorias_cargar.php">
    	<tr>
        	<th>orden</th>
            <td><input type="text" name="orden" class="xs" /></td>
        </tr>
    	<tr>
        	<th>categoría</th>
            <td><select name="id_categoria"><?php echo $options_categoria; ?></select></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="titulo" /></td>
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