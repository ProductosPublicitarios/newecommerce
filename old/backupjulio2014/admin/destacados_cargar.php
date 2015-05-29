<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$conn = conn();
$msj = '';
$ss = 4;

if( isset($_POST['envio']) ){
	$id = $_POST['prods'];
	$s = "UPDATE productos SET destacado=1 WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'El producto ha sido destacado.';
		header("Location: destacados.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}

$options_prods = '';
$s = "SELECT id,id_categoria,titulo,codigo FROM productos WHERE destacado!=1 ORDER BY id_categoria,orden,id";
$r = mysql_query($s);
if($r and mysql_num_rows($r)>0 ){
	while( $row = mysql_fetch_array($r) ){
		$id = $row['id'];
		$nombre = $arr_categorias[$row['id_categoria']].' >> ('.$row['codigo'].') '.$row['titulo'];
		$options_prods .= '<option value="'.$id.'">'.$nombre.'</option>';
	}
}else{
	$options_prods = '<option value="0" selected="selected">No hay productos para destacar</option>';
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
    <form name="edit" method="post" action="destacados_cargar.php">
    	<tr>
        	<th colspan="2">Seleccione el producto que desea destacar</th>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
    	<tr>
            <td colspan="2"><select name="prods"><?php echo $options_prods; ?></select></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><input type="submit" name="envio" id="envio" value="DESTACAR" /></th>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>