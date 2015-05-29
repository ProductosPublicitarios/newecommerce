<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$conn = conn();
$msj = '';
$ss = 14;

if( isset($_POST['envio']) ){
	$visible = $_POST['visible'];
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$email = mysql_real_escape_string($_POST['email']);
	$detalles = mysql_real_escape_string($_POST['detalles']);
	$clientes = $_POST['clientes'];

	$valores = "'$nombre', '$email', '$visible', '$detalles'";
	$s = "INSERT INTO vendedores(nombre,email,visible,detalles) VALUES($valores)";
	$r = mysql_query($s);
	if($r){
		// Clientes
		$id = mysql_insert_id($conn);
		
		if( is_array($clientes) ){
			$valoresx = "";
			foreach($clientes as $v){
				$valoresx .= "($v,$id), ";
			}
			$valoresx = substr($valoresx, 0, -2);
			$s = "INSERT INTO vc (id_cliente,id_vendedor) VALUES $valoresx";
			$r = mysql_query($s);
		}
		$msj = 'El vendedor ha sido cargado.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$options_visible = '<option value="1" selected="selected">Si</option>';
$options_visible .= '<option value="2">No</option>';

// Clientes.
$wh = '';
$clientes = '';
$s = "SELECT id_cliente FROM vc";
$r = mysql_query($s);
if($r){
	$n = mysql_num_rows($r);
	if($n>0){
		while( $row = mysql_fetch_assoc($r) )
		{
			$id_cliente = $row['id_cliente'];
			$wh .= " id!=".$id_cliente." AND ";
		}
		$wh = substr($wh, 0, -4);
	}
}

$s = "SELECT id,nombre,empresa FROM usuariosx WHERE $wh";
$r = mysql_query($s);
if($r){
	$n = mysql_num_rows($r);
	if($n>0){
		while( $row = mysql_fetch_assoc($r) )
		{
			$id = $row['id'];
			$str = $row['nombre'] . '('.$row['empresa'].') ';
			$clientes .= "<label style='width:220px; display:block'>";
			$clientes .= " <input style='width:20px;' type='checkbox' name='clientes[]' value='$id' /> $str</label>";
		}
	}
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
    <form name="edit" method="post" action="vend_cargar.php">
    	<tr>
        	<th>activo</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="nombre" /></td>
        </tr>
        <tr>
        	<th>email</th>
            <td><input type="text" name="email" /></td>
        </tr>
        <tr>
        	<th>detalles</th>
            <td><textarea name="detalles"></textarea></td>
        </tr>
        <tr>
        	<th>clientes</th>
            <td><?php echo $clientes; ?></td>
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