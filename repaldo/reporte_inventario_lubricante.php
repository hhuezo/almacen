<html>

<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />



</head>

<?php
session_start();
//esto se usa para mostrar la letra ñ y tildes
header('Content-Type: text/html; charset=iso-8859-1 utf-8'); 

 ?>
 
 <!-- script para calendario -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="css/botones.css" />
	<script src="js/jquery-1.4.1.js" type="text/javascript"></script>
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui.min.js" type="text/javascript"></script>
    
    
  </script>
  
   <script language="javascript">
jQuery(function($){
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});
   
  $(document).ready(function(){	   
   //$("#datepicker").datepicker();
    $("#fecha").datepicker({
    changeYear: true,
	autoSize: true
    });
	
})
</script>
<section class="container">
<div class="login">

<h1>
<?php include_once('titulo_sistema.html');?>
</h1>

<body>

<center>
<h2>INVENTARIO</h2>

<form name="liquidacion" action="reporte_inventario_lubricante_aceptar.php" method="get">

<table width="60%" border="0" align="center">  
  <tr>
    <td ><div align="right" ><span>Fecha de Inventario</span>:</div></td>   
	<td>
    <input type="text" name="fecha" id="fecha" readonly="readonly" size="12"> </td>    
  </tr>  
  <tr>
    <td height="26" colspan="2"> 
    <br>
        <center><input type="button" name="aceptar" value="Aceptar" onclick="        
        if (liquidacion.fecha.value==''){
        alert('Por favor, no dejar la fecha de inicio en blanco')
        return false;
        }
		else{
			window.open('reporte_inventario_lubricante_aceptar.php?fecha='+liquidacion.fecha.value, 'popup', 1000, 1000, 1, 1, 0, 0, 0, 1, 0); return false;
		}
        "  > <a href="inicio.php"><input type="button" name="btnCancelar" value="Cancelar">
        </center>
    
    </td>
  </tr>
</table>
</body>
</html>