<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 11;
$id = intval($_GET['id']);
if($id==0){header('Location:subcategorias.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$orden = mysql_real_escape_string($_POST['orden']);
	//$visible = $_POST['visible'];
	$id_categoria = $_POST['id_categoria'];
	$titulo = mysql_real_escape_string($_POST['titulo']);
	
	$valores = "orden='$orden', titulo='$titulo', id_categoria='$id_categoria'";
	$s = "UPDATE subcategorias SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La subcategoria ha sido editada.';
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
		//$visible = $row['visible'];
		$categoria = $row['id_categoria'];
		$titulo = $row['titulo'];
}	}

if($visible==1){
	$options_visible = '<option value="1" selected="selected">Si</option>';
	$options_visible .= '<option value="2">No</option>';
}else{
	$options_visible = '<option value="1">Si</option>';
	$options_visible .= '<option value="2" selected="selected">No</option>';
}

foreach($arr_categorias as $k=>$v){
	if($categoria == $k){$sel="selected='selected'";}else{$sel='';}
	$options_categoria .= "<option value='$k' $sel>$v</option>";
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
    <form name="edit" method="post" action="subcategorias_editar.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>orden</th>
            <td><input type="text" name="orden" value="<?php echo $orden; ?>" class="xs" /></td>
        </tr>
    	<tr>
        	<th>categoría</th>
            <td><select name="id_categoria"><?php echo $options_categoria; ?></select></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="titulo" value="<?php echo $titulo; ?>" /></td>
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