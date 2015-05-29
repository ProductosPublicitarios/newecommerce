<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 0;
$id = intval($_GET['id']);
if($id==0){header('Location:index.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$estado = $_POST['estado'];
	$descripcion = mysql_real_escape_string($_POST['descripcion']);
	
	$valores = "estado='$estado', descripcion='$descripcion'";
	$s = "UPDATE pedidos SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'El pedido ha sido editado.';
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT p.*,u.nombre,u.email,u.id id_usuario FROM pedidos p LEFT JOIN usuariosx u ON u.id=p.id_usuario WHERE p.id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$fecha = $row['fecha'];
		$estado = $row['estado'];

		$id_usuario = $row['id_usuario'];
		$usuario = $row['nombre'].' '.$row['apellido'].' - '.$row['email'].' &nbsp; <a href="usuarios_editar.php?id='.$row['id_usuario'].'">&raquo;editar este usuario</a>';
		$descripcion = $row['descripcion'];
}	}


foreach($arr_estado_pedidos as $k=>$v){
	if($estado == $k){$sel="selected='selected'";}else{$sel='';}
	$options_estado .= "<option value='$k' $sel>$v</option>";
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
    <form name="edit" method="post" action="pedidos_editar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>fecha</th>
            <td><?php echo $fecha; ?></td>
        </tr>
    	<tr>
        	<th>estado</th>
            <td><select name="estado"><?php echo $options_estado; ?></select></td>
        </tr>
    	<tr>
        	<th>usuario</th>
            <td><?php echo $usuario; ?></td>
        </tr>
    	<tr>
        	<th>descripción</th>
            <td><textarea name="descripcion"><?php echo $descripcion; ?></textarea></td>
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