<?php
require("./incl/bdd.php");
require("./incl/varios.php");
require("./incl/functions.php");

$msj = '';
$ss = 1;
$id = intval($_GET['id']);
if($id==0){header('Location:productos.php');}

$row = false;
$conn = conn();
$s = "SELECT * FROM productos WHERE id=$id";
$r = mysql_query($s);
if($r){
	$q = mysql_num_rows($r);
	if($r>0){
		$row = mysql_fetch_array($r);
		$orden = $row['orden'];
		$visible = $arr_yn[$row['visible']];
		$codigo = $row['codigo'];
		$minimo = $row['minimo'];
		$categoria = $arr_categorias[$row['id_categoria']];
		
		$id_subcategoria = $row['id_subcategoria'];
		$subcategoria = '';
		$st = 'SELECT titulo FROM subcategorias WHERE id='.$id_subcategoria;
		$rt = mysql_query($st);
		if($rt and  mysql_num_rows($rt)>0){
			$rowt = mysql_fetch_array($rt);
			$subcategoria = $rowt['titulo'];
		}
		
		$nombre = $row['titulo'];
		$descripcion = $row['descripcion'];
		$destacado = $arr_yn[$row['destacado']];
		$texto = $row['texto'];
		
		$tags = '';
		$st = 'SELECT titulo FROM tags WHERE id_producto='.$id;
		$rt = mysql_query($st);
		if($rt and  mysql_num_rows($rt)>0){
			while($rowt = mysql_fetch_array($rt)){
				$tags .= $rowt['titulo'].', ';
			}
			$tags = substr($tags,0,-2);
		}
		
		
		// Colores.
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
				$colores .= '<span style="display:inline-block; width:14px; height:14px; background-color:#'.$arr_colores[$rowc['id_color']]['hex'].';">&nbsp;</span>&nbsp;';
				$colores .= $arr_colores[$rowc['id_color']]['nombre'].'&nbsp; ';
			}
			$colores = substr($colores,0,-2);
		}
		
		// Relacionados
		$relacionados = '';
		$sc = "SELECT id_producto,id_combo,p1.id_categoria c1, p2.id_categoria c2,p1.titulo t1, p2.titulo t2 ";
		$sc.= "FROM productos_combos pc ";
		$sc.= "LEFT JOIN productos p1 ON p1.id=pc.id_producto ";
		$sc.= "LEFT JOIN productos p2 ON p2.id=pc.id_combo ";
		$sc.= "WHERE id_producto=".$id." OR id_combo=".$id;
		//echo $sc;
		$rc = mysql_query($sc);
		if($rc and  mysql_num_rows($rc)>0){
			while($rowc = mysql_fetch_array($rc)){
				// Cual corresponde.
				$id_combo = $rowc['id_combo'];
				$id_producto = $rowc['id_producto'];
				
				if( $id == $id_combo ){
					$idx = $rowc["id_producto"];
					$titulo = $rowc["t1"];
					$categoria =$arr_categorias[$rowc["c1"]];
				}else{
					$idx = $rowc["id_combo"];
					$titulo = $rowc["t2"];
					$categoria = $arr_categorias[$rowc["c2"]];
				}
				
				$relacionados .= '<a href="productos_ver.php?id='.$idx.'">'.$categoria.' &raquo; '.$titulo.'</a><br />';
			}
			$relacionados = substr($relacionados,0,-6);
		}
}	}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>G &amp; L &nbsp;Admin</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
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
        	<th width="120">id</th>
            <td><?php echo $id; ?></td>
        </tr>
    	<tr>
        	<th>orden</th>
            <td><?php echo $orden; ?></td>
        </tr>
    	<tr>
        	<th>visible</th>
            <td><?php echo $visible; ?></td>
        </tr>
    	<tr>
        	<th>código</th>
            <td><?php echo $codigo; ?></td>
        </tr>
        <!--tr>
        	<th>mínimo</th>
            <td><?php echo $minimo; ?></td>
        </tr-->
        <tr>
        	<th>destacado</th>
            <td><?php echo $destacado; ?></td>
        </tr>
    	<tr>
        	<th>categoría</th>
            <td><?php echo $categoria; ?></td>
        </tr>
        <tr>
        	<th>subcategoría</th>
            <td><?php echo $subcategoria; ?></td>
        </tr>
    	<tr>
        	<th>nombre</th>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
        	<th>descripción</th>
            <td><?php echo $descripcion; ?></td>
        </tr>
        <tr>
        	<th>texto</th>
            <td><?php echo $texto; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>tags</th>
            <td><?php echo $tags; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>colores</th>
            <td><?php echo $colores; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th>relacionados</th>
            <td><?php echo $relacionados; ?></td>
        </tr>
        <tr>
        	<td colspan="2"></td>
        </tr>
        <tr>
        	<th colspan="2"><a href="productos_editar.php?id=<?php echo $id; ?>" class="wht">&raquo; editar este producto</a></th>
        </tr>
    </table>
    </div>
</div>
</body>
</html>