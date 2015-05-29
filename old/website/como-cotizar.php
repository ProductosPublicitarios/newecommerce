<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$sexion = 7;
$sexion_name = $arr_sexiones[$sexion];


$texto = '';
$titulo = $sexion_name.' &raquo; En construcción';
$img = '<img src="images/logo-prod-ver.jpg" width="168" height="71" vspace="10" />';

$conn = conn();
$sql = "SELECT titulo,texto,uri FROM secciones WHERE code=$sexion";
$res = mysql_query($sql);
if($res){
	$nr = mysql_num_rows($res);
	if($nr>0){
		$row = mysql_fetch_array($res);
		$titulo = $row['titulo'];
		$texto = stripslashes($row['texto']);
		$img = $row['uri'];
		if($img != ''){
			$img = '<img src="images/secciones/'.$img.'" vspace="10" />';
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>G &amp; L</title>
<style type="text/css">
*{font-family:Arial, Helvetica, sans-serif; font-size:14px;}
.cfx{clear:both;}
#prod_img{
	width:300px; float:left; margin-right:20px;
}
#prod_data{
	margin:auto;
}
#titulo{
	font-weight:bold;
	display:block;
	margin-bottom:10px;
}
#prod_data img{
	/*width:168px;
	height:71px;*/
	max-width:600px;
}
#prod_data .seccion_texto p, #prod_data .seccion_texto a{
	font-size:12px;
}
#prod_data .seccion_texto a{color:#666; text-decoration:underline; font-weight:bold;}
#prod_data .seccion_texto a:hover{color:#333;}
</style>
</head>

<body>
<div>
  <div id="prod_data">
   	  <span id="titulo"><?php echo $titulo; ?></span>
      <div class="seccion_texto"><?php echo $texto; ?></div>
      <?php echo $img; ?>
</div>
    <div class="cfx">&nbsp;</div>
</div>
</body>
</html>