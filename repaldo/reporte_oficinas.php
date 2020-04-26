<html>
<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="css/botones.css" />
	<script src="js/jquery-1.4.1.js" type="text/javascript"></script>
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui.min.js" type="text/javascript"></script>
	

</head>


<?php require_once('conectar/conectar.php'); 
session_start();


//esto se usa para mostrar la letra ñ y tildes
header('Content-Type: text/html; charset=iso-8859-1 utf-8'); 

 $sql = "SELECT * FROM agrupacion_operacional";
  mysql_select_db($database_cnn, $cnn);
  $rsagru = mysql_query($sql, $cnn) or die(mysql_error());



 ?>


  
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
<h2>REPORTE POR OFICINA</h2>	


<form name="reporte_oficina" action="reporte_oficinas_aceptar.php" method="post">

<table>
<!--
  <tr>
    <td width="31%" height="75" class="texto"><div align="left">Departamento:</div></td>
    <td><input type="hidden" name="id_dto" id="id_dto" size="50" readonly>
	
	<input type="text" name="txt_nombre_dto" id="txt_nombre_dto" size="30" readonly  >
	<a href="#" onClick=		   "TINY.box.show({iframe:'buscar_dto.php',boxid:'frameless',width:750,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
        	    class="enlacebotonimagen" name="btnBuscar"><img src="css/16-Search.ico"></a>
				</td>
  </tr> -->
  <tr>
    <td height="35"  class="texto"><div align="left" ><span>Fecha Inicio</span>:</div></td>
    <td>
    <input type="text" name="fecha_ini" id="fecha_ini" readonly="readonly" size="12"></td>
    <!-- <td><?php //echo "<input name='fecha_liqui' id='fecha_liqui' value='$fecha' type='text' size='25'>"?>formato aaaa-mm-dd</td> -->
    <!--se crea un cuadro de texto con php para capturar la variable fecha-->
 
    </td>
    
  </tr> 
  <tr>
    <td height="35"  class="texto"><div align="left">Fecha Fin</div></td>
    <td>
    
    <input type="text" name="fecha_fin" id="fecha_fin" readonly="readonly" size="12"></td>
    <!-- <td><?php //echo "<input name='fecha_liqui' id='fecha_liqui' value='$fecha' type='text' size='25'>"?>formato aaaa-mm-dd</td> -->
    <!--se crea un cuadro de texto con php para capturar la variable fecha-->
    
    
    
    </td>
    
  </tr>
  <tr>
    <td height="26" colspan="2"> 
    
        <center><input type="submit" name="aceptar" value="Aceptar" onClick="
         
        if (reporte_oficina.fecha_ini.value==''){
        alert('Por favor, no dejar la fecha de inicio en blanco')
        return false;
        }
       if (reporte_oficina.fecha_fin.value==''){
        alert('Por favor, no dejarno dejar la fecha final en blanco')
        return false;
        }
       
        "  > <a href="inicio.php"><input type="button" name="btncancelar" value="Cancelar">
        </center>
    
    </td>
  </tr>
</table>


<div id="targetDiv"></div>
</center>

</body>
</div>
</section>

</html>
