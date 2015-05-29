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
$s = "SELECT u.*,v.id idv, v.nombre vendedor FROM usuariosx u ";
$s.= "LEFT JOIN vc ON vc.id_cliente=u.id ";
$s.= "LEFT JOIN vendedores v ON v.id=vc.id_vendedor WHERE u.id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$visible = $arr_yn[$row['visible']];
		$f_creacion = $row['f_creacion'];
		$nombre = $row['nombre'];
		$empresa = $row['empresa'];
		$telefono = $row['telefono'];
		$newsletter = $row['newsletter']==1?'Si':'No';
		$detalles = $row['detalles'];
		$email = $row['email'];
		$vendedor = $row['vendedor'];
		$vendedor_id = $row['idv'];
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
        	<th width="120">Vendedor</th>
            <td><?php echo $vendedor; ?> -> <a target="_blank" href="vend_ver.php?id=<?php echo $vendedor_id; ?>">Ver</a></td>
        </tr>
        <tr>
        	<th width="120">F. Registro</th>
            <td><?php echo $f_creacion; ?></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
        	<th>empresa</th>
            <td><?php echo $empresa; ?></td>
        </tr>
        <tr>
        	<th>email</th>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
        	<th>telefono</th>
            <td><?php echo $telefono; ?></td>
        </tr>
        <tr>
        	<th>newsletter</th>
            <td><?php echo $newsletter; ?></td>
        </tr>
        <tr>
        	<th>detalles</th>
            <td><?php echo $detalles; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><a href="usuarios_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar este usuario</a></th>
        </tr>
    </table>
    </div>
</div>
</body>
</html>