<html>

<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />
<script type="text/javascript" src="js/centeredPopup.js"></script>


<title>LIQUIDACION</title>
</head>

<?php require_once('conectar/conectar.php'); 
session_start();


//esto se usa para mostrar la letra ñ y tildes
header('Content-Type: text/html; charset=iso-8859-1 utf-8'); 

 $sql = "SELECT * FROM agrupacion_operacional";
  mysql_select_db($database_cnn, $cnn);
  $rsagru = mysql_query($sql, $cnn) or die(mysql_error());



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
    $("#fecha_ini").datepicker({
    changeYear: true,
	autoSize: true
    });
	
})
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
    $("#fecha_fin").datepicker({
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
<h2>LIQUIDACION</h2>

<form name="liquidacion" method="get" >

<table width="40%" border="0" align="center">

  <tr>
    <td ><div align="left" ><span>Fecha Inicio</span>:</div></td>
    <td>
    <input type="text" name="fecha_ini" id="fecha_ini" readonly="readonly" size="12"></td>
  </td>
    
  </tr>
  <tr>
    <td ><div align="left">Fecha Fin:</div></td>
    <td>
    
    <input type="text" name="fecha_fin" id="fecha_fin" readonly="readonly" size="12"></td>
    </td>
    
  </tr>
   <tr>
    <td ><div align="left">Correlativo:</div></td>
    <td>
    
    <input type="text" name="correlativo" id="correlativo"  size="12"></td>
    </td>
    
  </tr>
  <tr>
    <td ><div align="left">Observacion:</div></td>
    <td>
	<textarea rows="4" cols="38" name="observacion"></textarea>
    </td>   
  </tr>
   <tr>
  <tr>
    <td height="26" colspan="2"> 
    
        <center><input type="button" name="aceptar" value="Aceptar" onclick="
        
        if (liquidacion.fecha_ini.value==''){
        alert('Por favor, no dejar la fecha de inicio en blanco')
        return false;
        }
       if (liquidacion.fecha_fin.value==''){
        alert('Por favor, no dejarno dejar la fecha final en blanco')
        return false;
        }
		if (liquidacion.correlativo.value==''){
        alert('Por favor, no dejarno dejar el correlativo en blanco')
        return false;
        }
		else{
		window.open('reporte_liquidacion_lubricante_aceptar.php?fecha_ini='+liquidacion.fecha_ini.value+'&fecha_fin='+liquidacion.fecha_fin.value+'&correlativo='+liquidacion.correlativo.value+'&observacion='+liquidacion.observacion.value, 'popup', 1000, 1000, 1, 1, 0, 0, 0, 1, 0); return false;
        }"  > <a href="inicio.php"><input type="button" name="cancelarbtn" value="Cancelar">
        </center>
    
    </td>
  </tr>
</table>
 
</form>

</body>
</html>