<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$p = intval($_GET['p']);
$ss = 3;

$rows = false;
$conn = conn();

$page_total = 1;
$order = 'ORDER BY id DESC';
$w = 'WHERE destacado=1 ';

$s = 'SELECT count(id) tot FROM productos '.$w;
#echo $s.'<br />';
$r = mysql_query($s);
if($r){
	$row = mysql_fetch_row($r);
	$q = $row[0];
	$page_total = ceil($q / Q);
	$l_ini = $p!=0?($p-1)*Q:0;
	$limit = "LIMIT $l_ini,".Q;
	$s = "SELECT * FROM productos $w $order $limit";
	#echo $s.'<br />';
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
    	Pagina <select id="page" onchange="changePage('destacados');"><?php echo $options_page; ?></select> de <?php echo $page_total; ?>
    </div>
    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
        	<th align="center" width="50">Id</th>
            <th align="center" width="50">Orden</th>
            <th align="center" width="50">Visible</th>
            <th align="center">Código</th>
            <th>Categoría</th>
            <th>Nombre</th>
            <th align="center" width="140">borrar destacado</th>
        </tr>
        <?php if(!is_array($rows)){ ?>
        <tr>
        	<td colspan="20">No hay items.</td>
        </tr>
        <?php }else{ foreach($rows as $v){ ?>
        <tr class="data">
        	<td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['orden']; ?></td>
            <td align="center"><?php echo $arr_yn[$v['visible']]; ?></td>
            <td align="center"><?php echo $v['codigo']; ?></td>
            <td><?php echo $arr_categorias[$v['id_categoria']]; ?></td>
            <td><?php echo $v['titulo']; ?></td>
            <td align="center"><a href="destacados_borrar.php?id=<?php echo $v['id']; ?>">borrar destacado</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>