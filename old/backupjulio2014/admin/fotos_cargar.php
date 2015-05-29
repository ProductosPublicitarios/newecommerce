<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 7;

$row = false;
$conn = conn();
$max_size = "2000000";

if( isset($_POST['envio']) ){
	$tipo = $_POST['tipo'];
	$referencia = mysql_real_escape_string($_POST['referencia']);
	$campos = "titulo,tipo";
	$valores = "'$referencia','$tipo'";
	
	if($tipo!=0){
		$id_tipo = $_POST['prods'];
		$campos .= ",id_tipo";
		$valores .= ",'$id_tipo'";
	}
	
	$foto_1 = '';
	if( isset($_FILES['urix']) and $_FILES['urix']['name'] != ''){
		$img_tipo = $_FILES['urix']['type'];
		$img_name = $_FILES['urix']['name'];
		$img_tmpname = $_FILES['urix']['tmp_name'];
		$img_size = $_FILES['urix']['size'];
		$img_xts = '.jpg';
		$img_prename = time();
		if($tipo!=0){
			$img_path = '../images/productos/';
		}else{
			$img_path = '../images/slider/';
		}
		//$img_path_thumb = PATH_FOTOS.'thumbs/';
		$img_final_name = $img_path . $img_prename . $img_xts;
		//$img_final_name_thumb = $img_path_thumb . $img_prename . $img_xts;
		$uri_to_db = $img_prename . $img_xts;
		
		if($img_tipo == 'image/jpeg' or $img_tipo == 'image/jpg' or $img_tipo == 'image/pjpeg' or $img_tipo == 'image/pjpg' 
		 or $img_tipo == 'image/ppng' or $img_tipo == 'image/pneg' or $img_tipo == 'image/png' ){
			if($img_size <= $max_size){
				if( move_uploaded_file($img_tmpname, $img_final_name) ){
					$foto_1 = $uri_to_db;
					$MSJ = "oka";
				}else{
					$MSJ = "Ha ocurrido un error al crear la $SEXION_S";
					$foto_1 = '';
				}
			}else{
				$MSJ = "La foto debe ser menor a 1mb.";
				$foto_1 = '';
			}			
		}else{
			$MSJ = "La foto debe ser del formato JPG o PNG.";
			$foto_1 = '';
		}
	}else{
		$MSJ = "NO FOTO";
	}
	
	if( $foto_1 != '' ){
		$campos .= ",uri";
		$valores.= ",'$uri_to_db'";
		$s = "INSERT INTO fotos ($campos) VALUES($valores)";
		$r = mysql_query($s);
		if($r){
			$msj = 'La foto ha sido cargada.';
		}else{
			$msj = 'Error, por favor intente nuevamente.';
		}
	}else{
		$msj = 'Error: '. $MSJ;
	}
}

$options_tipo = '';
foreach($arr_fotos_tipo as $k=>$v){
	$options_tipo .= '<option value="'.$k.'">'.$v.'</option>';
}

$options_prods = '';
$s = "SELECT id,id_categoria,titulo,codigo FROM productos ORDER BY id_categoria,orden,id";
$r = mysql_query($s);
if($r and mysql_num_rows($r)>0 ){
	while( $row = mysql_fetch_array($r) ){
		$xid = $row['id'];
		if($xid == $id_tipo){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		
		$nombre = $arr_categorias[$row['id_categoria']].' >> ('.$row['codigo'].') '.$row['titulo'];
		$options_prods .= '<option value="'.$xid.'"'.$sel.'>'.$nombre.'</option>';
	}
}else{
	$options_prods = '<option value="0" selected="selected">No hay productos</option>';
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
    <form name="cargar" method="post" action="fotos_cargar.php" enctype="multipart/form-data">
        <tr>
        	<th>tipo</th>
            <td><select name="tipo"><?php echo $options_tipo; ?></select></td>
        </tr>
    	<tr>
        	<th>producto</th>
            <td><select name="prods"><?php echo $options_prods; ?></select></td>
        </tr>
        <tr>
        	<th>referencia</th>
            <td><input type="text" name="referencia" id="referencia" /></td>
        </tr>
        <tr>
        	<th>foto</th>
            <td><input type="file" name="urix" id="urix" value="Seleccione Foto" style="height:20px; width:220px; background-color:#fff; border:1px solid grey; float:left;" /><span style="float:left; line-height:22px;">(300px * 300px)</span></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<td colspan="2"><input type="submit" name="envio" id="envio" value="CARGAR" /></td>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>