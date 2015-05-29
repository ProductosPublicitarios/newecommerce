<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = $_GET['m']?$_GET['m']:'';
$ss = 8;

$w = '';
$rows = false;
$conn = conn();



$s = "SELECT id,code,titulo FROM secciones";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		while($row = mysql_fetch_array($r) ){	$rows[] = $row; }
}	}
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

    <br />
    <table width="100%" cellpadding="3" cellspacing="1" border="0">
    	<tr>
            <th align="left" width="150">Sección</th>
            <th align="left">Título</th>
            <th align="center" width="60">editar</th>
        </tr>
        <?php if(!is_array($rows)){ ?>
        <tr>
        	<td colspan="20">No hay items.</td>
        </tr>
        <?php }else{ foreach($rows as $v){ ?>
        <tr class="data">
            <td align="left"><?php echo $arr_sexiones[$v['code']]; ?></td>
            <td align="left"><?php echo $v['titulo']; ?></td>
            <td align="center"><a href="secciones_editar.php?id=<?php echo $v['id']; ?>">editar</a></td>
        </tr>
        <?php }} ?>
    </table>
    </div>
</div>
</body>
</html>