<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$k = intval($_GET['k']);
$p = intval($_GET['p']);
$ss = 11;

$w = '';
$rows = false;
$conn = conn();
if($k!=0){	$w = 'WHERE id_categoria='.$k; }

$page_total = 1;
$order = 'ORDER BY orden DESC,id DESC';

$s = 'SELECT count(id) tot FROM subcategorias '.$w;
$r = mysql_query($s);
if($r){
	$row = mysql_fetch_row($r);
	$q = $row[0];
	$page_total = ceil($q / Q);
	$l_ini = $p!=0?($p-1)*Q:0;
	$limit = "LIMIT $l_ini,".Q;
	$s = "SELECT * FROM subcategorias $w $order $limit";
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
$options_ver = "<option value=''>Todos</option>";
foreach($arr_categorias as $kk=>$vv){
		$sel = $k==$kk?" selected='selected'":'';
		$options_ver .= "<option value='$kk'$sel>$vv</option>";
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
    	Pagina <select id="page" onchange="changePage('subcategorias');"><?php echo $options_page; ?></select> de <?php echo $page_total; ?>
        <span id="ver_solo">Ver sólo <select id="ver" onchange="changeVer('subcategorias');"><?php echo $options_ver; ?></select></span>
    </div>
    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
        	<th align="center" width="50">Id</th>
            <th align="center" width="50">Orden</th>
            <th>Categoría</th>
            <th align="left">Nombre</th>
            <th align="center" width="60">ver</th>
            <th align="center" width="60">editar</th>
            <th align="center" width="60">borrar</th>
        </tr>
        <?php if(!is_array($rows)){ ?>
        <tr>
        	<td colspan="20">No hay items.</td>
        </tr>
        <?php }else{ foreach($rows as $v){ ?>
        <tr class="data">
        	<td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['orden']; ?></td>
            <td align="center"><?php echo $arr_categorias[$v['id_categoria']]; ?></td>
            <td><?php echo $v['titulo']; ?></td>
            <td align="center"><a href="subcategorias_ver.php?id=<?php echo $v['id']; ?>">ver</a></td>
            <td align="center"><a href="subcategorias_editar.php?id=<?php echo $v['id']; ?>">editar</a></td>
            <td align="center"><a href="subcategorias_borrar.php?id=<?php echo $v['id']; ?>">borrar</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>