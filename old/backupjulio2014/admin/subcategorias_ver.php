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
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><a href="subcategorias_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar esta subcategoria</a></th>
        </tr>
    </table>
    </div>
</div>
</body>
</html>