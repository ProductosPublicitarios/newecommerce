<?php
session_start();
if( $_SESSION['logged'] !== true ){
	header("Location: login.php");
}

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

$arr_yn[0] = 'No';
$arr_yn[1] = 'Si';
$arr_yn[2] = 'No';
/*
$arr_estado_pedidos[0] = 'Sin estado';
$arr_estado_pedidos[1] = 'Revisado';
$arr_estado_pedidos[2] = 'Confirmado';
$arr_estado_pedidos[3] = 'En proceso';
$arr_estado_pedidos[4] = 'Pausado';
$arr_estado_pedidos[5] = 'Despachado';
$arr_estado_pedidos[6] = 'Cancelado';
*/
$arr_estado_pedidos[0] = 'Sin estado';
$arr_estado_pedidos[1] = 'Leido-Cliente';
$arr_estado_pedidos[2] = 'Enviado';
$arr_estado_pedidos[3] = 'En proceso';
$arr_estado_pedidos[4] = 'Comprado';
$arr_estado_pedidos[5] = 'Cerrado';


$arr_fotos_tipo[0] = 'Home';
$arr_fotos_tipo[1] = 'foto chica';
$arr_fotos_tipo[2] = 'foto grande';

$arr_bs = array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ');
$arr_ok = array('a','e','i','o','u','n','A','E','I','O','U','N');

$arr_sexiones[1] = 'Empresa';
$arr_sexiones[2] = 'Servicios';
$arr_sexiones[3] = 'Novedades';
$arr_sexiones[4] = 'Como Llegar';
$arr_sexiones[5] = 'Preguntas Frecuentes';
$arr_sexiones[6] = 'Ubicación';
$arr_sexiones[7] = 'Como cotizar';

define('ACT',' class="activo"');
define('Q', 50);
?>