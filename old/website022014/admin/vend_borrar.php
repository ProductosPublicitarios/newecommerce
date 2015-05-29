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
	$s = "DELETE FROM vendedores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$s = "DELETE FROM vc WHERE id_vendedor=$id";
		$r = mysql_query($s);
		
		$msj = 'El vendedor ha sido borrado.';
		header("Location: vend.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM vendedores WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($q>0){
		$row = mysql_fetch_array($r);
		$visible = $arr_yn[$row['visible']];
		$nombre = $row['nombre'];
		$detalles = $row['detalles'];
		$email = $row['email'];
		
		$clientes = '-';
		$s = "SELECT u.id idu, nombre,empresa,email FROM vc LEFT JOIN usuariosx u ON u.id=vc.id_cliente WHERE vc.id_vendedor=$id";
		$r = mysql_query($s);
		if($r){
			$q = mysql_num_rows($r);
			if($q>0){
				$clientes = '';
				while( $row = mysql_fetch_array($r) )
				{
					$clientes .= "<a href='usuarios_ver.php?id=".$row['idu']."' target='_blank'>".$row['nombre'].' ('.$row['empresa'].')</a><br />';
				}
			}
		}
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
    <form name="edit" method="post" action="vend_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar el vendedor? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='vend.php'" />
            </th>
        </tr>
    	<tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
        <tr>
        	<th width="120">activo</th>
            <td><?php echo $visible; ?></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
        	<th>email</th>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
        	<th>clientes</th>
            <td><?php echo $clientes; ?></td>
        </tr>
        <tr>
        	<th>detalles</th>
            <td><?php echo $detalles; ?></td>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>