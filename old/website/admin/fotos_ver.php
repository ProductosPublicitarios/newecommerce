<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 6;
$id = intval($_GET['id']);
if($id==0){header('Location:fotos.php');}

$row = false;
$FOTO_2_NONE = false;
$conn = conn();
$s = "SELECT * FROM fotos WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($q>0){
		$row = mysql_fetch_array($r);
		$visible = $arr_yn[$row['visible']];
		$referencia = $row['titulo'];
		$id_tipo = $row['id_tipo'];
		$tipo = $row['tipo'];
		$tipo_str = $arr_fotos_tipo[$tipo];
		$foto_uri = $row['uri'];
		
		$producto = '';
		
		if( $tipo != 0 ){
		
			// Producto
			$sql_p = "SELECT titulo,id,codigo,id_categoria FROM productos WHERE id=$id_tipo LIMIT 1";
			$res_p = mysql_query($sql_p);
			if($res_p){
				$q = mysql_num_rows($res_p);
				if($q>0){
					$row_p = mysql_fetch_array($res_p);
					$cat = $arr_categorias[$row_p['id_categoria']];
					$producto = $cat.' -> '.$row_p['titulo'].' ('.$row_p['codigo'].')';
					$foto = removeBS($cat, $arr_bs, $arr_ok).'/'.$foto_uri;
				}
			}
			
			// Otra Foto.
			$s = "SELECT * FROM fotos WHERE id_tipo=$id_tipo AND tipo!=$tipo";
			$r = mysql_query($s);
			if($r){
				$q = mysql_num_rows($r);
				if($q>0){
					$row = mysql_fetch_array($r);
					$visible = $arr_yn[$row['visible']];
					$id2 = $row['id'];
					$referencia2 = $row['titulo'];
					$id_tipo = $row['id_tipo'];
					$tipo2 = $arr_fotos_tipo[$row['tipo']];
					$tipo_str2 = $arr_fotos_tipo[$tipo2];
					$foto_uri2 = $row['uri'];
					$foto2 = removeBS($cat, $arr_bs, $arr_ok).'/'.$foto_uri;
				}else{
					$FOTO_2_NONE = true;
				}
			}else{
				$FOTO_2_NONE = true;
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
    <?php if($tipo == 0){ ?>
    <table width="100%" cellpadding="3" cellspacing="1" border="0" class="lft">
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
        	<th>foto</th>
            <td><img src="../images/slider/<?php echo $foto_uri; ?>" border="0" /></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><a href="fotos_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar esta foto</a></th>
        </tr>
    </table>
    <?php }else{ ?>
    <table width="100%" cellpadding="3" cellspacing="1" border="0" class="lft">
    	<tr>
        	<th colspan="2">Datos de la foto <?php echo $tipo==1?'chica':'grande'; ?> (<a href="fotos_editar.php?id=<?php echo $id; ?>" class="wht" style="text-transform:lowercase;">editar esta foto</a>)</th>
            <td><?php echo $id; ?></td>
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
        	<th>producto</th>
            <td><?php echo $producto; ?></td>
        </tr>
        <tr>
        	<th>referencia</th>
            <td><?php echo $referencia; ?></td>
        </tr>
        <tr>
        	<th>foto</th>
            <td><img src="../images/productos/<?php echo $foto_uri; ?>" border="0" /></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
    	<tr>
        	<th colspan="2">Datos de la foto <?php echo $tipo==1?'grande':'chica'; ?> <?php if( !$FOTO_2_NONE ){ ?>(<a href="fotos_editar.php?id=<?php echo $id2; ?>" class="wht" style="text-transform:lowercase;">editar esta foto</a>)<?php } ?></th>
            <td><?php echo $id; ?></td>
        </tr>
        	<?php if( $FOTO_2_NONE ){ ?>
        <tr>
        	<th>Foto</th>
            <td>Esta foto no ha sido cargada</td>
        </tr>
            <?php }else{ ?>
        <tr>
        	<th>tipo</th>
            <td><?php echo $tipo2; ?></td>
        </tr>
        <tr>
        	<th>referencia</th>
            <td><?php echo $referencia2; ?></td>
        </tr>
        <tr>
        	<th>foto</th>
            <td><img src="../images/productos/<?php echo $foto_uri2; ?>" border="0" /></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
            <?php } ?>
    </table>
    <?php } ?>
    </div>
</div>
</body>
</html>