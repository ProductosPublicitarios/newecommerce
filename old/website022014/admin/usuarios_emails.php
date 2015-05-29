<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 5;

$row = false;
$conn = conn();
$emails = $nombres = "";
$s = "SELECT nombre,xusuariox,email FROM usuariosx WHERE admin!=1 AND newsletter=1";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		while($row = mysql_fetch_array($r)){
			$nombre = $row['nombre'];
			$xusuariox = $row['xusuariox'];
			$email = $row['email'];
			
			$emails .= $email.", ";
			$nombres .= $nombre."<$email>, ";
		}
		$emails = substr($emails, 0, -2);
		$nombres = substr($nombres, 0, -2);
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
    <table width="100%" cellpadding="3" cellspacing="1" border="0" class="lft">
    	<tr>
        	<th width="120" valign="top">sólo emails</th>
            <td><textarea><?php echo $emails; ?></textarea></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th valign="top">con nombre</th>
            <td><textarea><?php echo $nombres; ?></textarea></td>
        </tr>
    </table>
    </div>
</div>
</body>
</html>