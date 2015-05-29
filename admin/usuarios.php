<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$p = intval($_GET['p']);
$k = intval($_GET['k']);
$ss = 5;

$w1 = $w2 = ' WHERE admin!=1';
$rows = false;
$conn = conn();
if($k==1){
	$w1.= ' AND newsletter=1';
	$w2 = $w1;
}elseif($k==2){
	$w1.= ' AND newsletter!=1';
	$w2 = $w1;
}elseif($k==3){
	$w2.= ' AND v.nombre IS NOT NULL';
}elseif($k==4){
	$w2.= ' AND v.nombre IS NULL';
}

$page_total = 1;
$order = 'ORDER BY id DESC';

$s = 'SELECT count(id) tot FROM usuariosx '.$w1;
$r = mysql_query($s);
if($r){
	$row = mysql_fetch_row($r);
	$q = $row[0];
	$page_total = ceil($q / Q);
	$l_ini = $p!=0?($p-1)*Q:0;
	$limit = "LIMIT $l_ini,".Q;
	$s = "SELECT u.*,v.nombre vend, v.id idv FROM usuariosx u LEFT JOIN vc ON vc.id_cliente=u.id ";
	$s.= "LEFT JOIN vendedores v ON vc.id_vendedor=v.id $w2 $order $limit";
	
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

$arr_usuarios_ver[0] = 'Todos';
$arr_usuarios_ver[1] = 'Suscriptos al newsletter';
$arr_usuarios_ver[2] = 'No suscriptos';
$arr_usuarios_ver[3] = 'Con Vendedor';
$arr_usuarios_ver[4] = 'Sin Vendedor';
$options_ver = "";
foreach($arr_usuarios_ver as $kk=>$vv){
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
    	Pagina <select id="page" onchange="changePage('usuarios');"><?php echo $options_page; ?></select> de <?php echo $page_total; ?>
        <span id="ver_solo"><a href="usuarios_emails.php">Ver listado de emails</a> &nbsp;-&nbsp; Ver sólo <select id="ver" onchange="changeVer('usuarios');"><?php echo $options_ver; ?></select></span>
    </div>
    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
        	<th align="center" width="50">Id</th>
            <th align="center" width="50">activo</th>
             <th align="center" width="80">newsletter</th>
            <th width="130">F.Registro</th>
            <th align="left">Vendedor</th>
            <th align="left">Nombre</th>
            <th>Email</th>
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
             <td align="center"><?php echo $arr_yn[$v['newsletter']]; ?></td>
            <td align="center"><?php echo $v['f_creacion']; ?></td>
            <td><?php echo $v['vend']; ?></td>
            <td><?php echo $v['nombre']; ?></td>
            <td align="center"><?php echo $v['email']; ?></td>
            <td align="center"><a href="usuarios_ver.php?id=<?php echo $v['id']; ?>">ver</a></td>
            <td align="center"><a href="usuarios_editar.php?id=<?php echo $v['id']; ?>">editar</a></td>
            <td align="center"><a href="usuarios_borrar.php?id=<?php echo $v['id']; ?>">borrar</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>