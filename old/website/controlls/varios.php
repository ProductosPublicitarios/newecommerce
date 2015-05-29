<?php
session_start();
$_SESSION['prods'][0] = '';
$_SESSION['prods_name'][0] = '';

define('PROD_PER_ROW', 3);
define('PROD_PER_PAGE', 6);
define('MAIL_SITE', 'ventas@gylenterprise.com.ar');
//define('MAIL_SITE', 'cotizacionesgyl@gmail.com');

$arr_categorias[1] = 'Banderas';
$arr_categorias[2] = 'Bolígrafos';
$arr_categorias[3] = 'Botones y Pins';
$arr_categorias[4] = 'Buzos';
$arr_categorias[5] = 'Artículos de dama';
$arr_categorias[6] = 'Camperas y Capas';
$arr_categorias[7] = 'Chalecos';
$arr_categorias[8] = 'Chombas';
$arr_categorias[9] = 'Escritorio';
$arr_categorias[10] = 'Gorros';
$arr_categorias[11] = 'Imanes';
$arr_categorias[12] = 'Jarros';
$arr_categorias[13] = 'Llaveros';
$arr_categorias[14] = 'Marroquiner&iacute;a';
$arr_categorias[15] = 'Mouse Pad';
$arr_categorias[16] = 'Paraguas';
$arr_categorias[17] = 'Remeras';
$arr_categorias[18] = 'Sombreros';
$arr_categorias[19] = 'Varios';

$arr_bs = array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
$arr_ok = array('a','e','i','o','u','n','A','E','I','O','U','N');
$arr_char = array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z',1,2,3,4,5,6,7,8,9);

$arr_sexiones[1] = 'Empresa';
$arr_sexiones[2] = 'Servicios';
$arr_sexiones[3] = 'Novedades';
$arr_sexiones[4] = 'Como llegar';
$arr_sexiones[5] = 'Preguntas Frecuentes';
$arr_sexiones[6] = 'Ubicación';
?>