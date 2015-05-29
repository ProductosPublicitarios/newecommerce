<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$id_cat = intval($_GET['c']);
$cat = $arr_categorias[$id_cat];
$PROD_TEMP = 'productos-listado-s.php';
$conn = conn();


// News.
$sql_news = 'SELECT p.id,p.titulo,p.id_categoria,f.uri,f2.uri big FROM productos p ';
$sql_news.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
$sql_news.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
$sql_news.= 'WHERE p.visible=1 AND p.destacado=1 GROUP BY p.id ORDER BY RAND() LIMIT 2';
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

$word = mysql_real_escape_string($_GET['w'], $conn);
$word = str_replace('+', ' ', $word);
$word = str_replace(',', ' ', $word);
$arr_words = explode(' ', $word);
$qwords = count($arr_words);

// Productos Categoria Actual.
$page_total = 1;
$page_actual = intval($_GET['p']);
if($page_actual==0){$page_actual=1;}
$HAY_MAS = $HAY_MENOS = false;

$SUPER_LIKE = '';
foreach($arr_words as $WORD)
{ // Armo super like
	//t.titulo LIKE '%$words_string%'
	if( trim($WORD) != '' ){
		$SUPER_LIKE .= "t.titulo LIKE '%$WORD%' OR ";
	}
}
$SUPER_LIKE = substr($SUPER_LIKE, 0, -3);
//echo $SUPER_LIKE.'<br />';

//$sql_cat = "SELECT COUNT(t.id) cant FROM tags t LEFT JOIN productos p ON p.id=t.id_producto WHERE p.visible=1 AND t.titulo LIKE '%$word%'";
$sql_cat = "SELECT DISTINCT((p.id)) cant FROM tags t LEFT JOIN productos p ON p.id=t.id_producto WHERE p.visible=1 AND ($SUPER_LIKE)";
//echo $sql_cat;
$res_cat = mysql_query($sql_cat);
if( $res_cat ){
	//$frow = mysql_fetch_row($res_cat);
	$cant_prod = mysql_num_rows($res_cat);
	
	if($cant_prod > 0 ){
		$page_total = ceil($cant_prod / PROD_PER_PAGE);
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
		
		$sql_cat = 'SELECT p.id,p.titulo,p.id_categoria,f.uri,f2.uri big FROM productos p ';
		$sql_cat.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
		$sql_cat.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
		$sql_cat.= 'WHERE p.visible=1 AND p.id_categoria='.$id_cat.' GROUP BY p.id '.$limit;
		
		$sql_cat = 'SELECT p.id,p.titulo,p.id_categoria,f.uri,f2.uri big FROM tags t ';
		$sql_cat.= 'LEFT JOIN productos p ON t.id_producto=p.id ';
		$sql_cat.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
		$sql_cat.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
		$sql_cat.= 'WHERE p.visible=1 AND ('.$SUPER_LIKE.') GROUP BY p.id '.$limit;
		//echo '<br />'.$sql_cat;

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

require('views/layout_prod.php');
?>