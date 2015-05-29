<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$k = intval($_GET['k']);
$idk = intval($_GET['idk']);
$p = intval($_GET['p']);
$ss = 6;

if($k==1){
	$w = 'WHERE tipo=0';
}else{
	$w = 'WHERE tipo!=0';
}
if($idk != 0){
	$w = 'WHERE p.id_categoria='.$idk;
}
$rows = false;
$conn = conn();

$page_total = 1;
$order = 'ORDER BY id DESC';

if($idk == 0){
	$s = 'SELECT count(id) tot FROM fotos $w';
}else{
	$s = 'SELECT count(f.id) tot FROM fotos f LEFT JOIN productos p ON f.id_tipo=p.id '.$w;
}
$r = mysql_query($s);
if($r){
	$row = mysql_fetch_row($r);
	$q = $row[0];
	$page_total = ceil($q / Q);
	$l_ini = $p!=0?($p-1)*Q:0;
	$limit = "LIMIT $l_ini,".Q;
	if($k==1){
		$s = "SELECT * FROM fotos $w $order $limit";
	}else{
		$order = 'ORDER BY p.id DESC, id DESC';
		$s = "SELECT f.*,p.titulo producto,p.id idprod,p.codigo FROM fotos f LEFT JOIN productos p ON f.id_tipo=p.id $w $order $limit";
	}

	$r = mysql_query($s);
	if($r){
		$q = mysql_num_rows($r);
		if($r>0){
			while($row = mysql_fetch_array($r) ){	$rows[] = $row; }
	}	}
}

$arr_pages = range(1,$page_total);
$options_page = '';
foreach($arr_pages as $pp){
	$sel = $p==$pp?" selected='selected'":'';
	$options_page .= "<option value='$pp'$sel>$pp</option>";
}

$options_cats = '<option value="0">-Seleccione Categoria-</option>';
foreach($arr_categorias as $k=>$v){
	if( $k == $idk ){
		$options_cats .= '<option value="'.$k.'" selected="selected">'.$v.'</option>';
	}else{
		$options_cats .= '<option value="'.$k.'">'.$v.'</option>';
	}
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script language="javascript" type="text/javascript" src="js/funciones.js"></script>
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
    <div id="submenu">
    	Pagina <select id="page" onchange="changePageF('fotos');"><?php echo $options_page; ?></select> de <?php echo $page_total; ?>
        <span id="ver_solo"><a href="fotos.php">Fotos de Productos</a> - <a href="fotos.php?k=1">Fotos de Home</a> <select name="idk" id="idk" onchange="changePageF2('fotos');"><?php echo $options_cats; ?></select></span>
    </div>
    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
        	<th align="center" width="50">Id</th>
            <th align="center" width="50">Visible</th>
            <th align="center" width="90">Tipo</th>
            <th align="left">Producto</th>
            <th align="left">Referencia</th>
            <th align="center" width="60">ver</th>
            <th align="center" width="60">editar</th>
            <th align="center" width="60">borrar</th>
        </tr>
        <?php if(!is_array($rows)){ ?>
        <tr>
        	<td colspan="20">No hay items.</td>
        </tr>
        <?php }else{ foreach($rows as $v){ ?>
        <tr>
        	<td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $arr_yn[$v['visible']]; ?></td>
            <td align="center"><?php echo $arr_fotos_tipo[$v['tipo']]; ?></td>
            <td><?php echo $v['producto'].' ('.$v['codigo'].')'; ?></td>
            <td><?php echo $v['titulo']; ?></td>
            <td align="center"><a href="fotos_ver.php?id=<?php echo $v['id']; ?>">ver</a></td>
            <td align="center"><a href="fotos_editar.php?id=<?php echo $v['id']; ?>">editar</a></td>
            <td align="center"><a href="fotos_borrar.php?id=<?php echo $v['id']; ?>">borrar</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>