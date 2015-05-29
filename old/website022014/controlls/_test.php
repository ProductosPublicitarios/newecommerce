<?php

function add_cart()
{
	$q = intval($_POST['q']);
	$id = intval($_POST['id']);
	
	if( $q!=0 and $id!=0 ){
		if( array_key_exists($id, $_SESSION['prods_ids']) ){
			//$cant_actual = $_SESSION['prods'][$id];
			$_SESSION['prods'][$id] += $q;
		}else{
			$_SESSION['prods'][$id] = $q;
		}
		print_r($_SESSION['prods']);
	}else{
		die(false);
	}
}

session_start();
print_r($_SESSION['prods']);
$_SESSION['prods'][0] = '';

$q = intval($_GET['q']);
$id = intval($_GET['id']);

if( $q!=0 and $id!=0 ){
	if( array_key_exists($id, $_SESSION['prods']) ){
		//$cant_actual = $_SESSION['prods'][$id];
		$_SESSION['prods'][$id] += $q;
		echo "EXISTE<br />";
	}else{
		$_SESSION['prods'][$id] = $q;
		echo "NO EXISTE<br />";
	}
}else{
	die(false);
}

print_r($_SESSION['prods']);
?>