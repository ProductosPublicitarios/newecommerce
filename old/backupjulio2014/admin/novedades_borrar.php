<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 3;
$id = intval($_GET['id']);
if($id==0){header('Location:novedades.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$s = "DELETE FROM novedades WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La novedad ha sido borrada.';
		header("Location: productos.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM novedades WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$visible = $arr_yn[$row['visible']];
		$nombre = $row['titulo'];
		$texto = nl2br($row['texto']);
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
    <form name="edit" method="post" action="novedades_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar la novedad? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='novedades.php'" />
            </th>
        </tr>
        <tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>visible</th>
            <td><?php echo $visible; ?></td>
        </tr>
    	<tr>
        	<th>título</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
        	<th>texto</th>
            <td><?php echo $texto; ?></td>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>