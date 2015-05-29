<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 13;
$id = intval($_GET['id']);
if($id==0){header('Location:vend.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$visible = $_POST['visible'];
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$email = mysql_real_escape_string($_POST['email']);
	$detalles = mysql_real_escape_string($_POST['detalles']);
	$clientes = $_POST['clientes'];
	
	$valores = "visible='$visible', nombre='$nombre', email='$email',detalles='$detalles'";
	$s = "UPDATE vendedores SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		
		$s = "DELETE FROM vc WHERE id_vendedor='$id'";
		$r = mysql_query($s);
		
		if( is_array($clientes) ){
			$valoresx = "";
			foreach($clientes as $v){
				$valoresx .= "($v,$id), ";
			}
			$valoresx = substr($valoresx, 0, -2);
			$s = "INSERT INTO vc (id_cliente,id_vendedor) VALUES $valoresx";
			$r = mysql_query($s);
		}
		
		$msj = 'El vendedor ha sido editado.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM vendedores WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$visible = $row['visible'];
		$nombre = $row['nombre'];
		$detalles = $row['detalles'];
		$email = $row['email'];
		
		$clientes = '-';
}	}

if($visible==1){
	$options_visible = '<option value="1" selected="selected">Si</option>';
	$options_visible .= '<option value="2">No</option>';
}else{
	$options_visible = '<option value="1">Si</option>';
	$options_visible .= '<option value="2" selected="selected">No</option>';
}


// Clientes.
$arr_actuales = array();
$s = "SELECT id_cliente FROM vc WHERE id_vendedor=$id";
$r = mysql_query($s);
if($r){
	$n = mysql_num_rows($r);
	if($n>0){
		while( $row = mysql_fetch_assoc($r) )
		{
			$arr_actuales[] = $row['id_cliente'];
		}
	}
}

$wh = '1 ';
$clientes = '';
$s = "SELECT id_cliente FROM vc";
$r = mysql_query($s);
if($r){
	$n = mysql_num_rows($r);
	if($n>0){
		while( $row = mysql_fetch_assoc($r) )
		{
			$id_cliente = $row['id_cliente'];
			if( !in_array($id_cliente, $arr_actuales) ){
				$wh .= "AND id!=".$id_cliente." ";
			}
		}
//		$wh = substr($wh, 0, -4);
	}
}

$s = "SELECT id,nombre,empresa FROM usuariosx WHERE $wh";
//echo $s;
$r = mysql_query($s);
if($r){
	$n = mysql_num_rows($r);
	if($n>0){
		while( $row = mysql_fetch_assoc($r) )
		{
			$idx = $row['id'];
			$str = $row['nombre'] . '('.$row['empresa'].') ';

			$check = '';
			if( in_array($idx, $arr_actuales) ){
				$check = " checked='checked'";
			}
			
			$clientes .= "<label style='width:320px; display:block'>";
			$clientes .= " <input style='width:20px;' type='checkbox' name='clientes[]' value='$idx'$check /> $str</label>";
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
    <form name="edit" method="post" action="vend_editar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>activo</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="nombre" value="<?php echo $nombre; ?>" /></td>
        </tr>
        <tr>
        	<th>email</th>
            <td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
        </tr>
        <tr>
        	<th>detalles</th>
            <td><textarea name="detalles"><?php echo $detalles; ?></textarea></td>
        </tr>
        <tr>
        	<th>clientes</th>
            <td><?php echo $clientes; ?></td>
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