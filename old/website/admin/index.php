<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$p = intval($_GET['p']);
$ss = 0;

$w = '';
$rows = false;
$conn = conn();

$page_total = 1;
$order = 'ORDER BY id DESC';

$s = 'SELECT count(id) tot FROM pedidos';
$r = mysql_query($s);
if($r){
	$row = mysql_fetch_row($r);
	$q = $row[0];
	$page_total = ceil($q / Q);
	$l_ini = $p!=0?($p-1)*Q:0;
	$limit = "LIMIT $l_ini,".Q;
	$s = "SELECT p.*,u.nombre,u.email FROM pedidos p LEFT JOIN usuariosx u ON p.id_usuario=u.id ";
	$s.= "$w $order $limit";
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
    	Pagina <select id="page" onchange="changePage('index');"><?php echo $options_page; ?></select> de <?php echo $page_total; ?>
    </div>
    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
        	<th align="center" width="50">Id</th>
            <th width="140">Fecha</th>
            <th width="140">Estado</th>
            <th align="left">Usuario</th>
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
            <td align="center"><?php echo $v['fecha']; ?></td>
            <td align="center"><?php echo $arr_estado_pedidos[$v['estado']]; ?></td>
            <td><?php echo $v['nombre'].' - '.$v['email']; ?></td>
            <td align="center"><a href="pedidos_ver.php?id=<?php echo $v['id']; ?>">ver</a></td>
            <td align="center"><a href="pedidos_editar.php?id=<?php echo $v['id']; ?>">editar</a></td>
            <td align="center"><a href="pedidos_borrar.php?id=<?php echo $v['id']; ?>">borrar</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>