<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 8;
$id = intval($_GET['id']);
if($id==0){header('Location:secciones.php');}
$max_size = "1000000";

$row = false;
$conn = conn();

if( isset($_POST['envio']) ){
	$titulo = mysql_real_escape_string($_POST['titulo']);
	$texto = mysql_real_escape_string($_POST['texto']);
	
	$foto_1 = '';
	if( isset($_FILES['urix']) and $_FILES['urix']['name'] != ''){
		$img_tipo = $_FILES['urix']['type'];
		$img_name = $_FILES['urix']['name'];
		$img_tmpname = $_FILES['urix']['tmp_name'];
		$img_size = $_FILES['urix']['size'];
		$img_xts = '.jpg';
		$img_prename = time();
		$img_path = '../images/secciones/';
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
					$MSJ = "Ha ocurrido un error al cargar la foto";
					$foto_1 = '';
				}
			}else{
				$MSJ = "La foto debe ser menor a 1mb.";
				$foto_1 = '';
			}			
		}else{
			$MSJ = "La foto debe ser del formato JPG.";
			$foto_1 = '';
		}
	}else{
		$MSJ = "NO FOTO";
	}
	
	
	$valores = "titulo='$titulo', texto='$texto'";
	if($foto_1!=''){
		$valores.= ",uri='$foto_1'";
	}
	$s = "UPDATE secciones SET $valores WHERE id=$id LIMIT 1";
	$r = mysql_query($s);
	if($r){
		$msj = 'La sección ha sido editada.';

	}else{
		$msj = 'Error, por favor intente nuevamente.';
	}
}


$s = "SELECT * FROM secciones WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$sexion = $arr_sexiones[$row['code']];
		$titulo = $row['titulo'];
		$texto = stripslashes($row['texto']);
}	}


?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
<script language="javascript" type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
	editor_selector : "mceSimple",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
    theme_advanced_buttons1 : "bold,italic,separator,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,removeformat",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : ""
});
</script>
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
    <form name="edit" method="post" action="secciones_editar.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    	<tr>
        	<th>sección</th>
            <td><?php echo $sexion; ?></td>
        </tr>
    	<tr>
        	<th>título</th>
            <td><input type="text" name="titulo" value="<?php echo $titulo; ?>" /></td>
        </tr>
    	<tr>
        	<th>texto</th>
            <td><textarea name="texto" id="texto" class="mceSimple ta_big"><?php echo $texto; ?></textarea></td>
        </tr>
        <tr>
        	<th>foto</th>
            <td><input type="file" name="urix" id="urix" class="file" /></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><input type="submit" name="envio" id="envio" value="EDITAR" /></th>
        </tr>
    </form>
    </table>
    </div>
</div>
</body>
</html>