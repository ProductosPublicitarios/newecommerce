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
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><a href="vend_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar este vendedor</a></th>
        </tr>
    </table>
    </div>
</div>
</body>
</html>