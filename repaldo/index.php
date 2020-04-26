<html>
<?php
session_start();
require_once('conectar/conectar.php'); 

if (isset($_SESSION['username'])){ 
	header("Location: inicio.php"); 
	exit();
}
?>

<head>
<title>Almacen</title>
<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>


<section class="container">
<div class="login">
<h1>Acceso al Sistema</h1>
<form name="login" method="post">
<table align='center'>
<body onload="document.getElementById('username').focus()">
<tr>
<td>
Usuario
</td>
<td>
<input  type="text" name="username" id="username" size="12"/>
</td>
</tr>

<tr>
<td>
Clave
</td>
<td>
<input type="password" name="password" size="12"/>
</td>
</tr>
<tr>
<td colspan='2' align='center'>
&nbsp;
</td>
</tr>

<tr>
<td colspan='2' align='center'>
<input type="submit" value="Aceptar" name="btnAceptar" />
</td>
</tr>

</table>
<br />
<?php 

if (isset($_POST['btnAceptar'])){

	$usuario = $_POST['username'];
	$clave = $_POST['password'];
	
	
$sql="SELECT * FROM usuarios WHERE username='$usuario' and password='$clave' and estado = '1'";

mysql_select_db($database_cnn, $cnn);
	  $result = mysql_query($sql, $cnn) or die(mysql_error());

if($row=mysql_fetch_array($result)){
			$_SESSION['id_usuario']=$row['id_usuario'];
			$_SESSION['username']=$row['username'];
			$_SESSION['password']=$row['password'];
			$_SESSION['id_tipo']=$row['id_tipo'];
			header("Location: inicio.php"); 
		}
		else{
			unset($_SESSION['username']);
			//echo "<center>Usuario o Clave NO Valido</center>";
			
		echo "<p class='remember_me'>
          <label>
		  <center>
            Usuario o Clave NO Valido
          </center>
		  </label>
        </p>";
			
			
		}

	mysql_close($cnn); //cierro la conexion 
}

 
	?>  
</form>
</div>
</section>	

</body>
</html>



		
		
