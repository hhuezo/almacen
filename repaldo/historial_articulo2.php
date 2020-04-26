<?php require_once('conectar/conectar.php'); 
	session_start();
	if (isset($_GET['id_articulo'])){
		$id_articulo = $_GET['id_articulo'];
	} 
	else {$id_articulo ='';}
	
	$sqlAxo="select YEAR(NOW()) as axo";
	mysql_select_db($database_cnn, $cnn);
	$resulAxo = mysql_query($sqlAxo, $cnn) or die(mysql_error());
	$rowAxo=mysql_fetch_array($resulAxo);

 ?>


<html>
<head>
 <meta charset="UTF-8">

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/botones.css" />

	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<script language="javascript">
function consultar(){
	//alert('consultar()');
	buscarAceptar('ajax/historial_articulo_aceptar2.php?modoop=1&id_articulo='+kardex.id_articulo.value,'targetDiv');
}	
</script>	
 
<section class="container">
<div class="login">

<h1>
<?php include_once('titulo_sistema.html');?>
</h1>

<body onLoad="consultar();">
		<center>
<h2>HISTORIAL POR PRODUCTO</h2>	
    

 
 <form name="kardex" method="POST" action="buscar_kardex_aceptar.php" >
 <!-- <form name="kardex" method="GET" action="javascript:buscarAceptar('Ajax/buscar_kardex_aceptar.php?id_art='+kardex.id_art.value,'targetDiv');" >--> 
 										<!-- "javascript:alert('Ajax/buscar_kardex_aceptar.php?id_art='+kardex.id_art.value,'targetDiv');"--> 
 <center>
 <table width="36%" border="0" align="center">
   <tr></tr>
   <tr>
     <td align="right"></td>
     <td><center>
     Articulo	 
		<input type="hidden" name="id_articulo" id="id_articulo" size="50" readonly value="<?php echo $id_articulo;?>">
		<input type="text" name="txt_articulo" id="txt_articulo" size="50" readonly>
		<input type="hidden" name="txt_existencia" id="txt_existencia" size="50" readonly>

			<a href="#" onClick="TINY.box.show({iframe:'articulo_activo_buscar.php',boxid:'frameless',width:750,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
			class="enlacebotonimagen" name="btnBuscar">
			<img src="css/16-Search.ico"></a>
		</center>
	 </td>
   </tr>
      <tr>
     <td align="right"></td>
     <td align="center">
     Año	 
		<select  name="axo" id="axo">
            <option value="<?php echo $rowAxo["axo"]; ?>"><?php echo $rowAxo["axo"]; ?></option>
            <option value="0">TODOS</option>
        </select>

	 </td>
   </tr>
   <tr>
     <td colspan="2"><center>
       <input type="button" name="btnAceptar" value="Aceptar"   size="10" onClick="
			modoop=1;
				sendQueryToAdd('ajax/historial_articulo_aceptar2.php?modoop=1&id_articulo='+kardex.id_articulo.value+
				'&axo='+kardex.axo.value,
			'targetDiv');
			"/>
       <a href="inicio.php">
         <input type="button" name="cancelarbtn" value="Cancelar" />
        </a>
     </center>
     
     <div id="targetDiv"></div>
     </td>
   </tr>
 </table>
</form>
  </center>
</body> 
</div>    
</section>    
   

