<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 5;
$id = intval($_GET['id']);
if($id==0){header('Location:usuarios.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$visible = $_POST['visible'];
	$newsletter = $_POST['newsletter'];
	$id_vendedor = $_POST['id_vendedor'];
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$apellido = mysql_real_escape_string($_POST['apellido']);
	$email = mysql_real_escape_string($_POST['email']);
	$empresa = mysql_real_escape_string($_POST['empresa']);
	$telefono = mysql_real_escape_string($_POST['telefono']);
	$detalles = mysql_real_escape_string($_POST['detalles']);
	
	$valores = "visible='$visible', nombre='$nombre', email='$email',empresa='$empresa',";
	$valores.= "newsletter='$newsletter',telefono='$telefono',detalles='$detalles'";
	$s = "UPDATE usuariosx SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$s = "UPDATE vc SET id_vendedor = $id_vendedor WHERE id_cliente = $id";
		$r = mysql_query($s);
		$msj = 'El usuario ha sido editado.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


//$s = "SELECT * FROM usuariosx WHERE id=$id";
$s = "SELECT u.*,v.id idv FROM usuariosx u ";
$s.= "LEFT JOIN vc ON vc.id_cliente=u.id ";
$s.= "LEFT JOIN vendedores v ON v.id=vc.id_vendedor WHERE u.id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$visible = $row['visible'];
		$f_creacion = $row['f_creacion'];
		$nombre = $row['nombre'];
		$empresa = $row['empresa'];
		$telefono = $row['telefono'];
		$newsletter = $row['newsletter'];
		$detalles = $row['detalles'];
		$email = $row['email'];
		$vendedor_id = $row['idv'];
}	}

if($visible==1){
	$options_visible = '<option value="1" selected="selected">Si</option>';
	$options_visible .= '<option value="2">No</option>';
}else{
	$options_visible = '<option value="1">Si</option>';
	$options_visible .= '<option value="2" selected="selected">No</option>';
}
if($newsletter==1){
	$options_newsletter = '<option value="1" selected="selected">Si</option>';
	$options_newsletter .= '<option value="2">No</option>';
}else{
	$options_newsletter = '<option value="1">Si</option>';
	$options_newsletter .= '<option value="2" selected="selected">No</option>';
}

$options_vendedor = '';
$s = "SELECT id,nombre FROM vendedores";
$r = mysql_query($s);
if($r){
	while($row = mysql_fetch_assoc($r) ){
		$v_id = $row['id'];
		$v_nombre = $row['nombre'];
		if($vendedor_id == $v_id){
			$options_vendedor .= '<option value="'.$v_id.'" selected="selected">'.$v_nombre.'</option>';
		}else{
			$options_vendedor .= '<option value="'.$v_id.'">'.$v_nombre.'</option>';
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
    <form name="edit" method="post" action="usuarios_editar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
        <tr>
        	<th width="120">F. Registro</th>
            <td><?php echo $f_creacion; ?></td>
        </tr>
    	<tr>
        	<th>activo</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
        <tr>
        	<th>vendedor</th>
            <td><select name="id_vendedor"><?php echo $options_vendedor; ?></select></td>
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
        	<th>empresa</th>
            <td><input type="text" name="empresa" value="<?php echo $empresa; ?>" /></td>
        </tr>
        <tr>
        	<th>telefono</th>
            <td><input type="text" name="telefono" value="<?php echo $telefono; ?>" /></td>
        </tr>
        <tr>
        	<th>newsletter</th>
            <td><select name="newsletter"><?php echo $options_newsletter; ?></select></td>
        </tr>
        <tr>
        	<th>detalles</th>
            <td><textarea name="detalles"><?php echo $detalles; ?></textarea></td>
        </tr>        <tr>
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