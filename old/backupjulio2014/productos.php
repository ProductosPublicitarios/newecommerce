<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

//printor($_SESSION);

$id_cat = intval($_GET['c']);
$id_sub = intval($_GET['s']);
$cat = $arr_categorias[$id_cat];
$PROD_TEMP = 'productos-listado.php';
$conn = conn();

// Veo si hay subcategorias.
$subcats = '';
$sqls = "SELECT * FROM subcategorias WHERE id_categoria = $id_cat ORDER BY orden";
//echo $sqls;
$ress = mysql_query($sqls);
if($ress and mysql_num_rows($ress)>0){
	$subcats .= ' &raquo; ';
	while( $rows = mysql_fetch_array($ress) ){
		$arr_subcategorias[$rows['id']] = $rows['titulo'];
		if( $id_sub == $rows['id'] ){
			$subcats .= ucfirst($rows['titulo']).' - ';
		}else{
			$subcats .= "<a style='color:inherit; text-decoration:underline;' href='productos.php?c=".$id_cat."&s=".$rows['id']."'>".ucfirst($rows['titulo']).'</a> - ';
		}
	}
	$subcats = substr($subcats, 0, -3);
}else{
	$arr_subcategorias = false;
}


if( $arr_subcategorias != false and $id_sub == 0 )
{ // Muestro Subs.
	$CONTENTSUB = '';
	//$CONTENTSUB = '<span style="width:400px; display:block; border:1px solid red;">Seleccione la subcategoría que desea visualizar</span><br />';
	foreach($arr_subcategorias as $k => $v )
	{
		$CONTENTSUB .= '<a style="margin-left:40px; margin-bottom:10px" href="productos.php?c='.$id_cat.'&s='.$k.'" class="product subcat" style="width:500px;">&#8226; '.$v.'</a>';
	}
	$PROD_TEMP = 'productos-subs.php';
	$LYT = "layout_sub.php";
	
}else{
	// Productos Categoria Actual.
	$page_total = 1;
	$page_actual = intval($_GET['p']);
	if($page_actual==0){$page_actual=1;}
	$HAY_MAS = $HAY_MENOS = false;
	$PAGES = '';
	if($id_sub != 0){
		$sql_cat = 'SELECT count(id) cant FROM productos WHERE visible=1 AND id_categoria='.$id_cat.' AND id_subcategoria='.$id_sub;
	}else{
		$sql_cat = 'SELECT count(id) cant FROM productos WHERE visible=1 AND id_categoria='.$id_cat;
	}
	//echo $sql_cat.'<br />';
	$res_cat = mysql_query($sql_cat);
	if( $res_cat ){
		$frow = mysql_fetch_row($res_cat);
		$cant_prod = $frow[0];
		
		$PAGES = '';
		if($cant_prod > 0 ){
			$page_total = ceil($cant_prod / PROD_PER_PAGE);
			if( $page_total > 1 ){
				$PAGES = 'Páginas: ';
				for($i=1; $i<=$page_total; $i++){
					if($id_sub != 0){
						if($page_actual == $i){
							$PAGES .= '<span class="sel">'.$i.'</span> - ';
						}else{
							$PAGES .= '<a href="productos.php?c='.$id_cat.'&s='.$id_sub.'&p='.$i.'">'.$i.'</a> - ';
						}
					}else{
						if($page_actual == $i){
							$PAGES .= '<span class="sel">'.$i.'</span> - ';
						}else{
							$PAGES .= '<a href="productos.php?c='.$id_cat.'&p='.$i.'">'.$i.'</a> - ';
						}
					}
				}
				$PAGES = substr($PAGES, 0, -3);
			}
			
			
			// El usuario puede poner pagina 10, sin embargo puede que no exista.
			if($page_actual > $page_total){
				$page_actual = 1;
			}
			if($page_actual > 1){
				$HAY_MENOS = true;
			}
			if($page_actual < $page_total){
				$HAY_MAS = true;
			}
			
			$l_ini = $page_actual!=0?($page_actual-1)*PROD_PER_PAGE:0;
			$limit = "LIMIT $l_ini,".PROD_PER_PAGE;
			
			if($id_sub != 0){
				$sql_cat = 'SELECT p.id,p.titulo,p.id_categoria,MAX(f.uri) uri,MAX(f2.uri) big FROM productos p ';
				$sql_cat.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
				$sql_cat.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
				$sql_cat.= 'WHERE p.visible=1 AND p.id_categoria='.$id_cat.' AND p.id_subcategoria='.$id_sub.' GROUP BY p.id ORDER BY orden ASC, id DESC '.$limit;
			}else{
				$sql_cat = 'SELECT p.id,p.titulo,p.id_categoria,MAX(f.uri) uri,MAX(f2.uri) big FROM productos p ';
				$sql_cat.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
				$sql_cat.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
				$sql_cat.= 'WHERE p.visible=1 AND p.id_categoria='.$id_cat.' GROUP BY p.id ORDER BY orden ASC, id DESC '.$limit;
			}
			//echo $sql_cat.'<br />';
			//echo $sql_cat;
	
			$res_cat = mysql_query($sql_cat);
			if($res_cat){
				$q_cat = mysql_num_rows($res_cat);
				if( $q_cat > 0){
					while($row_cat = mysql_fetch_array($res_cat)){
						$arr_cat['id'][] = $row_cat['id'];
						$arr_cat['titulo'][] = $row_cat['titulo'];
						if( $row_cat['uri']==''){
							if( $row_cat['big']==''){
								$arr_cat['uri'][] = 'na.jpg';
							}else{
								$arr_cat['uri'][] = $row_cat['big'];
							}
						}else{
							$arr_cat['uri'][] = $row_cat['uri'];
						}
						if( $row_cat['big']==''){
							$arr_cat['big'][] = 'na.jpg';
						}else{
							$arr_cat['big'][] = $row_cat['big'];
						}
					}
				}
			}
		}else{
			$PROD_TEMP = 'productos-empty.php';
		}
	}else{
		$PROD_TEMP = 'productos-empty.php';
	}
	
	$LYT = "layout_prod.php";
}



// News.
$sql_news = 'SELECT p.id,p.titulo,p.id_categoria,f.uri,f2.uri big FROM productos p ';
$sql_news.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
$sql_news.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
$sql_news.= 'WHERE p.visible=1 AND p.destacado=1 GROUP BY p.id ORDER BY RAND() LIMIT 2';
//$sql_news.= 'WHERE p.visible=1 AND p.destacado=1 GROUP BY p.id LIMIT 2';
//echo $sql_news;
$res_news = mysql_query($sql_news);
if($res_news){
	$q_news = mysql_num_rows($res_news);
	if( $q_news > 0){
		while($row_news = mysql_fetch_array($res_news)){
			$arr_news['id'][] = $row_news['id'];
			$arr_news['titulo'][] = $row_news['titulo'];
			if( $row_news['uri']==''){
				if( $row_news['big']==''){
					$arr_news['uri'][] = 'na.jpg';
				}else{
					$arr_news['uri'][] = $row_news['big'];
				}
			}else{
				$arr_news['uri'][] = $row_news['uri'];
			}
		}
	}
}

require('views/'.$LYT);
?>


