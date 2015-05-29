<?php
require('controlls/bdd.php');
require('controlls/varios.php');
require('controlls/functions.php');

require('controlls/conexion.php');

$login_usuario=$_POST['login_usuario'];

$login_clave = md5(md5($_POST['login_clave']));

$query="
		SELECT * FROM usuariosx
		WHERE xusuariox = '$login_usuario'
		AND
		xclavex = '$login_clave'
		";
	///consulta

	$comprobacion = mysqli_query($conexion, $query);

if ($comprobacion===false){
	echo "Ha ocurrido un error. Contacte al administrador del sistema";
	}else{
		if(mysqli_num_rows($comprobacion) == 0 ){
			echo "los datos ingresados son incorrectos";
		}else{
				session_start();
				$fila = mysqli_fetch_array($comprobacion);
				$_SESSION['id'] = $fila['id'];
				//header("location:index.php");	
				$_SESSION['logged'] = true;
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name'] = $nombre.' '.$apellido;
				$_SESSION['user_email'] = $_POST['login_usuario'];//el usuario es el mail de la persona
				$out = $nombre.' '.$apellido;
				header('Location: index.php');
		}
	}

?>