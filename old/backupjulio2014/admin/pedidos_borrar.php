<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 1;
$id = intval($_GET['id']);
if($id==0){header('Location:index.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$s = "DELETE FROM pedidos_productos WHERE id_pedido=$id";
	$r = mysql_query($s);
	$s = "DELETE FROM pedidos WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'El pedido ha sido borrado.';
		header("Location: index.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT p.*,u.nombre,u.apellido,u.email,u.id id_usuario FROM pedidos p LEFT JOIN usuariosx u ON u.id=p.id_usuario WHERE p.id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$fecha = $row['fecha'];
		$estado = $arr_estado_pedidos[$row['estado']];

		$id_usuario = $row['id_usuario'];
		$usuario = $row['nombre'].' '.$row['apellido'].' - '.$row['email'].' &nbsp; <a href="usuarios_ver.php?id='.$row['id_usuario'].'">&raquo;ver mas sobre este usuario</a>';
		$descripcion = $row['descripcion'];
		
		$sp = "SELECT pp.id_producto,pp.cantidad,p.titulo,p.codigo,p.id_categoria FROM pedidos_productos pp LEFT JOIN productos p ON p.id=pp.id_producto WHERE id_pedido=".$id;
		$rp = mysql_query($sp);
		if($rp){
			$qp = mysql_num_rows($rp);
			if($rp>0){
				$productos = "<tr>";
				$productos .= "<th width='80'>Cantidad</th>";
				$productos .= "<th>Categoria</th>";
				$productos .= "<th>Codigo</th>";
				$productos .= "<th>Nombre</th>";
				$productos .= "<th>Ver</th>";
				$productos .= "</tr>";
				while($rowp = mysql_fetch_array($rp))
				{
					$productos .= "<tr>";
					$productos .= "<td align='center'>".$rowp['cantidad']."</td>";
					$productos .= "<td align='center'>".$arr_categorias[$rowp['id_categoria']]."</td>";
					$productos .= "<td align='center'>".$rowp['codigo']."</td>";
					$productos .= "<td>".$rowp['titulo']."</td>";
					$productos .= '<td align="center"><a href="productos_ver.php?id='.$rowp['id_producto'].'">ver</a></td>';
					$productos .= "</tr>";
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
    <form name="edit" method="post" action="pedidos_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar el pedido? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='index.php'" />
            </th>
        </tr>
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
            <td><?php echo $estado; ?></td>
        </tr>
    	<tr>
        	<th>usuario</th>
            <td><?php echo $usuario; ?></td>
        </tr>
        <tr>
        	<th>descripción</th>
            <td><?php echo $descripcion; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
    </form>
    </table>
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<?php echo $productos; ?>
        <tr>
        	<td colspan="20"></td>
        </tr>
        <tr>
        	<th colspan="20"><a href="pedidos_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar este pedido</a></th>
        </tr>
    </table>
    </div>
</div>
</body>
</html>