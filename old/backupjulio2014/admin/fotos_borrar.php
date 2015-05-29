<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 6;
$id = intval($_GET['id']);
if($id==0){header('Location:fotos.php');}

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$s = "DELETE FROM fotos WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La fotos ha sido borrada.';
		header("Location: fotos.php?m=$msj");
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT f.*,p.id_categoria,p.codigo,p.titulo prodtit FROM fotos f LEFT JOIN productos p ON f.id_tipo=p.id WHERE f.id=$id";
echo $s;
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$visible = $arr_yn[$row['visible']];
		$referencia = $row['titulo'];
		$id_tipo = $row['id_tipo'];
		$tipo = $row['tipo'];
		$tipo_str = $arr_fotos_tipo[$tipo];
		$foto_uri = $row['uri'];
		
		
		if($tipo != 0){
			$cat = $arr_categorias[$row['id_categoria']];
			$producto = $cat.' -> '.$row['prodtit'].' ('.$row['codigo'].')';
		}else{
			$producto = "";
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
    <form name="edit" method="post" action="fotos_borrar.php?id=<?php echo $id; ?>">
    	<tr>
        	<th colspan="2">¿Está seguro de eliminar la foto? 
            <input type="submit" name="envio" id="envio" value="Si" />
            <input type="button" name="cancel" id="cancel" value="No" onclick="window.location='fotos.php'" />
            </th>
        </tr>
        <tr>
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
        <tr>
        	<th>tipo</th>
            <td><?php echo $tipo_str; ?></td>
        </tr>
        <tr>
        	<th>referencia</th>
            <td><?php echo $referencia; ?></td>
        </tr>
        <tr>
        	<th>producto</th>
            <td><?php echo $producto; ?></td>
        </tr>
        <?php if($tipo == 0 ){ ?>
        <tr>
        	<th>foto</th>
            <td><img src="../images/slider/<?php echo $foto_uri; ?>" border="0" /></td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<th>foto</th>
            <td><img src="../images/productos/<?php echo $foto_uri; ?>" border="0" /></td>
        </tr>
        <?php } ?>
    </form>
    </table>
    </div>
</div>
</body>
</html>