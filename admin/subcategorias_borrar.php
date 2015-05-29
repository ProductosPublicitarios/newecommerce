<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 1;
$id = intval($_GET['id']);
if($id==0){header('Location:subcategorias.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$s = "DELETE FROM subcategorias WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La subcategoria ha sido borrada.';
		header("Location: subcategorias.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM subcategorias WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$orden = $row['orden'];
		//$visible = $arr_yn[$row['visible']];
		$categoria = $arr_categorias[$row['id_categoria']];
		$nombre = $row['titulo'];
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
    <form name="edit" method="post" action="subcategorias_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar la subcategoria? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='subcategorias.php'" />
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
        	<th>categoría</th>
            <td><?php echo $categoria; ?></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>