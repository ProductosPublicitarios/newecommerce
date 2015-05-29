<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$conn = conn();
$id = intval($_GET['id']);

$sql = 'SELECT * FROM productos WHERE visible=1 AND id='.$id;
$res = mysql_query($sql);
if( !$res ){
	die('ERROR');
}else{
	$num_rows = mysql_num_rows($res);
	if($num_rows <= 0){
		die('ERROR');
	}else{
		$row = mysql_fetch_array($res);
		$id_categoria = $row['id_categoria'];
		$titulo = ucwords($row['titulo']);
		$codigo = $row['codigo'];
		$minimo = $row['minimo'];
		
		if(trim($codigo!='')){
			$titulo.' ('.$codigo.')';
		}
		
		
		$descripcion = nl2br($row['descripcion']);
		$texto = nl2br($row['texto']);
		$img = "na_big.jpg";
		
		$arrf['big'] = '';
		$arrf['thumb'] = '';
		$sql_foto = "SELECT uri,tipo FROM fotos WHERE tipo!=0 AND id_tipo=$id AND visible=1 ORDER BY id DESC";
		//echo $sql_foto;
		$res_foto = mysql_query($sql_foto);
		if( $res_foto ){
			$num_rows = mysql_num_rows($res_foto);
			if($num_rows > 0){
				while($row_foto = mysql_fetch_array($res_foto)){
					$uri = $row_foto['uri'];
					$tipo = $row_foto['tipo'];
					
					if($tipo == 2){
						$arrf['big'] = $uri;
					}else{
						$arrf['thumb'] = $uri;
					}
				}
				
				$img = $arrf['big']!=''?$arrf['big']:$arrf['thumb'];
				if( $img == ''){
					$img = 'na_big.jpg';
				}
			}
		}
		
		// Colores
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
		$colores = '';
		$sc = "SELECT id_color FROM productos_colores WHERE id_producto=".$id;
		$rc = mysql_query($sc);
		if($rc and  mysql_num_rows($rc)>0){
			while($rowc = mysql_fetch_array($rc)){
				$colores .= '<span title="'.$arr_colores[$rowc['id_color']]['nombre'];
				$colores .= '" style="margin-right:5px; display:block; float:left; width:14px; height:14px; border:1px solid #000; background-color:#'.$arr_colores[$rowc['id_color']]['hex'].';">&nbsp;</span>';
			}
			//$colores = substr($colores,0,-2);
		}
		
		// Relacionados
		$relacionados = array();
		$sc = "SELECT id_producto,id_combo FROM productos_combos WHERE id_producto=".$id." OR id_combo=".$id. " LIMIT 3";
		//echo $sc;
		$rc = mysql_query($sc);
		$i = 0;
		if($rc and  mysql_num_rows($rc)>0){
			while($rowc = mysql_fetch_array($rc)){
				// Cual corresponde.
				$id_rel = $rowc['id_combo']==$id ? $rowc['id_producto'] : $rowc['id_combo'];
				$relacionados[$i]['id'] = $id_rel;
				
				// Titulo.
				$sqlt = "SELECT titulo FROM productos WHERE id=".$id_rel;
				$rest = mysql_query($sqlt);
				if($rest and  mysql_num_rows($rest)>0){
					$rowt = mysql_fetch_array($rest);
					$relacionados[$i]['tit'] = $rowt['titulo'];
				}
				// Foto.
				$sqlt = "SELECT tipo,uri FROM fotos WHERE (tipo=1 OR tipo=2) AND id_tipo=".$id_rel;
				//echo $sqlt.'<br />';
				$rest = mysql_query($sqlt);
				if($rest){
					$cant_f = mysql_num_rows($rest);
					//echo "C:".$cant_f.'<br />';
					if( $cant_f == 0 ){
						$urix = 'na.jpg';
					}elseif( $cant_f == 1 ){
						$rowt = mysql_fetch_array($rest);
						$urix = $rowt['uri'];
					}else{
						while($rowt = mysql_fetch_array($rest)){
							$rowx['uri'][$rowt['tipo']] = $rowt['uri'];
							//echo "T:".$rowt['tipo'].' - URI:'.$rowt['uri'].'<br />';
						}
						//printor($rowx);
						$urix = $rowx['uri'][1]!=''?$rowx['uri'][1]:$rowx['uri'][2];
						//echo $urix.'<br />';
					}
					$relacionados[$i]['uri'] = $urix;
				}
				$i ++;
			}
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
#prod_img,#prod_img img{
	width:300px; float:left; margin-right:20px;
}
#prod_data{
	float:left;
	margin-top:50px;
}
#titulo{
	font-weight:bold;
	display:block;
	margin-bottom:10px;
	font-size:20px;
}
#caract{
	font-weight:normal;
	display:block;
	margin-bottom:10px;
	font-size:13px;
	color:#333;
}
#texto{
	font-size:12px;
	display:block;
	width:260px;
	margin-bottom:10px;
	font-size:12px;
	font-weight:normal;
	line-height:28px;
}
#texto cufon{padding-bottom: 4px;}

#texto_dest{
	font-size:11px;
	display:block;
	width:260px;
	margin-bottom:10px;
	font-weight:bold;
	font-size:12px;
	color:#333;
}
#prod_data img{
	width:168px;
	height:71px;
	/*position:absolute;
	bottom:60px;*/
}
.add{
	background: url("../images/icon7.jpg") no-repeat scroll left top transparent;
    color: #959595;
    display: block;
    float: left;
    font-size: 8px;
    height: 13px;
    line-height: 5px;
    margin: 4px 0 0 4px;
    padding: 0;
    text-indent: 18px;
	
	font-size: 12px;
    line-height: 16px;
}
#carro{
	position:relative;
	bottom:10px;
	width:600px;
	font-size:12px;
	background-color:#086425;
	color:#fff;
	padding:5px;
	height:20px;
}
#carro #tit{
	font-size:12px;
	text-transform:uppercase;
	font-weight:bold;
	width:240px;
	display:block;
	float:left;
	line-height:20px;
}
#carro #quantity{
	font-size:12px;
	display:block;
	width:250px;
	float:left;
}
#carro #quantity i{font-size:11px;}
#carro input{
	border:none;
	padding:1px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	height:18px;
	width:40px;
	text-align:center;
	font-weight:bold;
}
#carro #add_cart{
	background-color:#fff;
	color:#000;
	width:80px;
	height:20px;
	float:right;
	line-height:12px;
}
#carro #add_cart:hover{
	background-color:#7e9b85;
	color:#000;
}
#prod_data{color:#85a28e; max-width:300px}

#prod_rel ul{list-style-type:none;}
#prod_rel ul li{float:left; margin-right:10px; width:30%;}
</style>
<script language="javascript" type="text/javascript">
function addToCart()
{
	var id = <?php echo $id; ?>;
	var xmin = document.getElementById('prod_min').value;
	var cant = document.getElementById('cant').value;
	var name = document.getElementById('prod_name').value;
	
	/*if(parseInt(cant) < parseInt(xmin)){
		alert('La cantidad debe ser mayor o igual al mínimo.');
	}else{*/
		window.parent.addCart(id,cant,name,xmin);
	//}
}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/cufon-fonts.js"></script>
<script type="text/javascript" src="js/cufon-settings.js"></script>
</head>

<body>
<div>
	<div id="prod_img"><img src="images/productos/<?php echo $img; ?>" border="0" style="max-width:400px;" /></div>
    <div id="prod_data">
    	<span id="titulo"><?php echo $titulo; ?></span>
        <span id="caract">Características</span>
        <span id="texto" style="line-height:28px;"><?php echo $descripcion; ?></span>
        <span id="texto_dest"><?php echo $texto; ?></span>
        <div id="colores"><?php echo $colores; ?></div>
        <div class="cfx"></div>
        <img src="images/logo-prod-ver.jpg" width="168" height="71" vspace="10" />
    </div>
    <div class="cfx">&nbsp;</div>
    <div id="carro">
    <span id="tit">Agregar al carro de cotización</span> <span id="quantity">Cantidad: <input type="text" id="cant" size="10" value="" /></span>
    <input type="button" id="add_cart" onclick="addToCart();" value="Agregar" />
    <input type="hidden" name="prod_name" id="prod_name" value="<?php echo $titulo; ?>" /> 
    <input type="hidden" name="prod_min" id="prod_min" value="<?php echo $minimo; ?>" /> 
    </div>
</div>
<?php if( count($relacionados) > 0 ){ ?>
<div class="cfx"></div>
<div id="prod_rel" style="width:600px; ">
	<span id="titulo">Productos Relacionados</span>
    <ul>
    	<?php foreach($relacionados as $k=>$v){ ?>
        <li><a href="ver.php?id=<?php echo $v['id']; ?>" style="color:#000; text-decoration:none;"><span class="texto_tit"><?php echo $v['tit']; ?></span></a><br />
        	<a href="ver.php?id=<?php echo $v['id']; ?>"><img src="images/productos/<?php echo $v['uri']; ?>" width="122" height="121" border="0" /></a>
        </li>
        <?php } ?>
    </ul>
    <div class="cfx"></div>
</div>
<?php } ?>
</body>
</html>