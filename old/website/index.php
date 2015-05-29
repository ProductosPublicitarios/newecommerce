<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

$conn = conn();

// Slider.
$img_slider = false;
$sql_slider = 'SELECT uri FROM fotos WHERE visible=1 AND tipo=0';
$res_slider = mysql_query($sql_slider);
if($res_slider){
	$q_slider = mysql_num_rows($res_slider);
	if( $q_slider > 0){
		while($row_slider = mysql_fetch_array($res_slider)){
			$img_slider[] = $row_slider['uri'];
		}
	}
}


// News.
$sql_news = 'SELECT p.id,p.titulo,p.id_categoria,f.uri,f2.uri big FROM productos p ';
$sql_news.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
$sql_news.= 'LEFT JOIN fotos f2 ON f2.id_tipo=p.id AND f2.tipo=2 ';
$sql_news.= 'WHERE p.visible=1 AND p.destacado=1 GROUP BY p.id ORDER BY RAND() LIMIT 3';
//echo $sql_news;
$res_news = mysql_query($sql_news);
if($res_news){
	$q_news = mysql_num_rows($res_news);
	if( $q_news > 0){
		$i = 0;
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
			if($i==2){
				$arr_news['class'][] = ' class="last"';
			}else{
				$arr_news['class'][] = '';
			}
			$i ++;
		}
	}
}
//p($arr_news);

// Catalogo.
$sql_cat = 'SELECT p.id,p.titulo,p.id_categoria,f.uri FROM productos p ';
$sql_cat.= 'LEFT JOIN fotos f ON f.id_tipo=p.id AND f.tipo=1 ';
$sql_cat.= 'WHERE p.visible=1 AND p.destacado!=1 GROUP BY p.id ORDER BY RAND() LIMIT 3';
//echo $sql_cat;
$res_cat = mysql_query($sql_cat);
if($res_cat){
	$q_cat = mysql_num_rows($res_cat);
	if( $q_cat > 0){
		$i = 0;
		while($row_cat = mysql_fetch_array($res_cat)){
			$arr_cat['id'][] = $row_cat['id'];
			$arr_cat['titulo'][] = $row_cat['titulo'];
			if( $row_cat['uri']==''){
				$arr_cat['uri'][] = 'na.jpg';
			}else{
				$arr_cat['uri'][] = $row_cat['uri'];
			}
			if($i==2){
				$arr_cat['class'][] = ' class="last"';
			}else{
				$arr_cat['class'][] = '';
			}
			$i ++;
		}
	}
}


require('views/layout.php');
?>