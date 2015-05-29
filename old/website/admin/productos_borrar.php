<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 1;
$id = intval($_GET['id']);
if($id==0){header('Location:productos.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$s = "DELETE FROM productos WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'El producto ha sido borrado.';
		header("Location: productos.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM productos WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$orden = $row['orden'];
		$visible = $arr_yn[$row['visible']];
		$codigo = $row['codigo'];
		$categoria = $arr_categorias[$row['id_categoria']];
		$nombre = $row['titulo'];
		$descripcion = $row['descripcion'];
		$destacado = $row['destacado'];
}	}

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
    <form name="edit" method="post" action="productos_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar el producto? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='productos.php'" />
            </th>
        </tr>
        <tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>orden</th>
            <td><?php echo $orden; ?></td>
        </tr>
    	<tr>
        	<th>visible</th>
            <td><?php echo $visible; ?></td>
        </tr>
    	<tr>
        	<th>código</th>
            <td><?php echo $codigo; ?></td>
        </tr>
    	<tr>
        	<th>categoría</th>
            <td><?php echo $categoria; ?></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
        	<th>descripción</th>
            <td><?php echo $descripcion; ?></td>
        </tr>
        <tr>
        	<th>destacado</th>
            <td><?php echo $destacado; ?></td>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>