<?php
session_start();
require_once('conectar/conectar.php');

if (!isset($_SESSION['username'])){ 
	header("Location: index.php"); 
	exit();
	}
	$rol=$_SESSION['id_tipo'];
	//esto se usa para mostrar la letra ñ y tildes
	header('Content-Type: text/html; charset=iso-8859-1 utf-8'); 


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>inicio</title>
<link rel="stylesheet" href="css/style_form.css" />
</head>

<section class="container">
<div class="login">
<h1>
<?php include_once('titulo_sistema.html');?>
</h1>

<body>
<center>
<?php
//Rol de administrador
		if ($rol==1){
			include_once('menu_admin.html');
		}
		else if($rol==2){
			include_once('menu_almacen.html');
		}
		else if($rol==3){
			include_once('menu_taller.html');
		}
		else if($rol==4){
			include_once('menu_conta.html');
		}
		else if($rol==5){
			include_once('menu_consulta.html');
		}
?>
</body>

</div>
</section>
<h1>
Usuario: <?php echo ' '.$_SESSION['username'];?>
</h1>

</html>