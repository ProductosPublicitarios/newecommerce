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
	$visible = $_POST['visible'];
	$titulo = mysql_real_escape_string($_POST['titulo']);
	$texto = mysql_real_escape_string($_POST['texto']);
	
	$valores = "visible='$visible', titulo='$titulo', texto='$texto'";
	$s = "UPDATE novedades SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La novedad ha sido editada.';
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
		$visible = $row['visible'];
		$titulo = $row['titulo'];
		$texto = $row['texto'];
}	}

if($visible==1){
	$options_visible = '<option value="1" selected="selected">Si</option>';
	$options_visible .= '<option value="2">No</option>';
}else{
	$options_visible = '<option value="1">Si</option>';
	$options_visible .= '<option value="2" selected="selected">No</option>';
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
    <form name="edit" method="post" action="novedades_editar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>visible</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
    	<tr>
        	<th>título</th>
            <td><input type="text" name="titulo" value="<?php echo $titulo; ?>" /></td>
        </tr>
        <tr>
        	<th>texto</th>
            <td><textarea name="texto"><?php echo $texto; ?></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><input type="submit" name="envio" id="envio" value="EDITAR" /></th>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>