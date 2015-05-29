<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 2;
$conn = conn();
if( isset($_POST['envio']) ){
	$orden = mysql_real_escape_string($_POST['orden']);
	$visible = $_POST['visible'];
	$codigo = mysql_real_escape_string($_POST['codigo']);
	$minimo = intval($_POST['minimo']);
	$id_categoria = $_POST['id_categoria'];
	$id_subcategoria = $_POST['id_subcategoria'];
	$titulo = mysql_real_escape_string($_POST['titulo']);
	$descripcion = mysql_real_escape_string($_POST['descripcion']);
	$destacado = $_POST['destacado'];
	$texto = mysql_real_escape_string($_POST['texto']);
	
	$tags = mysql_real_escape_string($_POST['tags']);
	

	$valores = "'$orden', '$visible', '$codigo', '$titulo', '$id_categoria', '$id_subcategoria', '$descripcion', '$destacado', '$texto'";
	$s = "INSERT INTO productos(orden,visible,codigo,titulo,id_categoria,id_subcategoria,descripcion,destacado,texto) VALUES($valores)";
	$r = mysql_query($s);
	if($r){
		$id = mysql_insert_id($conn);
		$msj = 'El producto ha sido cargado.';
		
		if($tags!=''){
			$tags_fields = '';
			$arr_tags = explode(',', $tags);
			foreach($arr_tags as $val){
				$tag = trim($val);
				$tags_fields .= "($id, '$tag'), ";
			}
			$tags_fields = substr($tags_fields, 0, -2);
			$sat = 'INSERT INTO tags (id_producto,titulo) VALUES'.$tags_fields;
			$rat = mysql_query($sat);
		}
		
		// Colores
		if(is_array($_POST['col'])){
			$col_values = '';
			foreach($_POST['col'] as $k=>$v){
				$col_values .= "($id, $k), ";
			}
			$col_values = substr($col_values, 0, -2);
			$sc = 'INSERT INTO productos_colores (id_producto,id_color) VALUES '.$col_values;
			$rc = mysql_query($sc);
		}
		
		// Relacionados
		// delete all
		if(is_array($_POST['rel'])){
			$col_values = '';
			foreach($_POST['rel'] as $k=>$v){
				if( intval($v) != 0 ){
					$col_values .= "($id, $v), ";
				}
			}
			$col_values = substr($col_values, 0, -2);
			$sc = 'INSERT INTO productos_combos (id_producto,id_combo) VALUES '.$col_values;
			//echo $sc.'<br />';
			$rc = mysql_query($sc);
		}
	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$options_visible = '<option value="1" selected="selected">Si</option>';
$options_visible .= '<option value="2">No</option>';

$options_destacado = '<option value="1" selected="selected">Si</option>';
$options_destacado .= '<option value="2">No</option>';

if( isset($_GET['idc']) ){
	$idcat = intval($_GET['idc']);
}else{
	$idcat = $categoria;
}
$arr_subcategorias[0] = 'Ninguna';
if( $idcat != 0 ){
	$sqls = "SELECT * FROM subcategorias WHERE id_categoria = $idcat";
	//echo $sqls;
	$ress = mysql_query($sqls);
	if($ress and mysql_num_rows($ress)>0){
		while( $rows = mysql_fetch_array($ress) ){
			$arr_subcategorias[$rows['id']] = $rows['titulo'];
		}
	}
}
foreach($arr_subcategorias as $k=>$v){
	if($id_subcategoria == $k){$sel="selected='selected'";}else{$sel='';}
	$options_subcategoria .= "<option value='$k' $sel>$v</option>";
}

foreach($arr_categorias as $k=>$v){
	if($idcat == $k){$sel="selected='selected'";}else{$sel='';}
	$options_categoria .= "<option value='$k' $sel>$v</option>";
}


$options_relacionados_1 = $options_relacionados_2 = $options_relacionados_3 = '<option value="0">Ninguno</option>';
$s = "SELECT id,id_categoria,titulo,codigo FROM productos ORDER BY id_categoria,orden,id";
$r = mysql_query($s);
if($r and mysql_num_rows($r)>0 ){
	while( $row = mysql_fetch_array($r) ){
		$ss1 = $ss2 = $ss3 = '';
		$idx = $row['id'];
		
		if( $idx == $arr_rel[0] ){
			$ss1 = ' selected="selected"';
		}
		if( $idx == $arr_rel[1] ){
			$ss2 = ' selected="selected"';
		}
		if( $idx == $arr_rel[2] ){
			$ss3 = ' selected="selected"';
		}
		
		$nombre = $arr_categorias[$row['id_categoria']].' >> ('.$row['codigo'].') '.$row['titulo'];
		
		$options_relacionados_1 .= '<option value="'.$idx.'"'.$ss1.'>'.$nombre.'</option>';
		$options_relacionados_2 .= '<option value="'.$idx.'"'.$ss2.'>'.$nombre.'</option>';
		$options_relacionados_3 .= '<option value="'.$idx.'"'.$ss3.'>'.$nombre.'</option>';
	}
}else{
	$options_relacionados_1 = '<option value="0" selected="selected">No hay productos para destacar</option>';
	$options_relacionados_2 = $options_relacionados_3 = $options_relacionados_1;
}



// Colores.
$arr_colores = false;
$sql_colores = "SELECT id,hex,nombre FROM colores";
$res_colores = mysql_query($sql_colores);
if($res_colores){
	$nr_colores = mysql_num_rows($res_colores);
	if($nr_colores > 0){
		$i = 0;
		while($row_colores = mysql_fetch_array($res_colores) ){
			$arr_colores[$row_colores['id']]['nombre'] = $row_colores['nombre'];
			$arr_colores[$row_colores['id']]['hex'] = $row_colores['hex'];
		}
	}
}

$arr_cols = array();
$sc = "SELECT id_color FROM productos_colores WHERE id_producto=".$id;
$rc = mysql_query($sc);
if($rc and  mysql_num_rows($rc)>0){
	while($rowc = mysql_fetch_array($rc)){
		$arr_cols[] = $rowc['id_color'];
	}
}


if(is_array($arr_colores)){
foreach($arr_colores as $kk=>$vv){
	if( in_array($kk, $arr_cols) ){
		$ckd = "checked='checked'";
	}else{
		$ckd = '';
	}
	$colores .= "<label for='col[".$kk."]' style='width:180px;'><input type='checkbox' name='col[".$kk."]' id='col[".$kk."]' class='cbx' style='float:left;' $ckd />";
	$colores .= "";
	$colores .= '<span style="display:inline-block; width:14px; height:14px; background-color:#'.$vv['hex'].';">&nbsp;</span>&nbsp;';
	$colores .= $vv['nombre']."</label> &nbsp;";
}}else{
	$colores = 'No hay colores disponibles.';	
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
    <form name="edit" method="post" action="productos_cargar.php">
    	<tr>
        	<th>orden</th>
            <td><input type="text" name="orden" class="xs" /></td>
        </tr>
    	<tr>
        	<th>visible</th>
            <td><select name="visible"><?php echo $options_visible; ?></select></td>
        </tr>
    	<tr>
        	<th>código</th>
            <td><input type="text" name="codigo" class="xs" /></td>
        </tr>
        <tr>
        	<th>destacado</th>
            <td><select name="destacado"><?php echo $options_destacado; ?></select></td>
        </tr>
    	<tr>
        	<th>categoría</th>
            <td><select name="id_categoria" onchange="window.location='productos_cargar.php?idc='+this.value"><?php echo $options_categoria; ?></select></td>
        </tr>
        <tr>
        	<th>subcategoría</th>
            <td><select name="id_subcategoria"><?php echo $options_subcategoria; ?></select></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><input type="text" name="titulo" /></td>
        </tr>
        <tr>
        	<th>descripción</th>
            <td><textarea name="descripcion"></textarea></td>
        </tr>
        <tr>
        	<th>texto destacado</th>
            <td><textarea name="texto"></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>tags</th>
            <td><textarea name="tags" id="tags"><?php echo $tags; ?></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>colores</th>
            <td><?php echo $colores; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>relacionados</th>
            <td>
            	<select name="rel[]"><?php echo $options_relacionados_1; ?></select><br /><br />
                <select name="rel[]"><?php echo $options_relacionados_2; ?></select><br /><br />
                <select name="rel[]"><?php echo $options_relacionados_3; ?></select>
            </td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><input type="submit" name="envio" id="envio" value="CARGAR" /></th>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>