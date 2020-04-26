<html>
<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />
</head>

<script language="JavaScript">
//var modoop=0;


function change_option(parametro){
         switch(parametro){
         case 'btnSalir': document.catalogo_unidad.action="../index.php"; break;
}
document.catalogo_unidad.submit();
}

function LimpiarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_unidad.elements.length;i++){
		if(document.forms.catalogo_unidad.elements[i].type == "text"){
           document.forms.catalogo_unidad.elements[i].value='';
        }
		if(document.forms.catalogo_unidad.elements[i].type == "checkbox"){
           document.forms.catalogo_unidad.elements[i].value=0;
        }
	}
}

function DeshabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_unidad.elements.length;i++){
		if(document.forms.catalogo_unidad.elements[i].type != "button"){
           document.forms.catalogo_unidad.elements[i].disabled=true;
        }
	}
}

function HabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_unidad.elements.length;i++){
		if(document.forms.catalogo_unidad.elements[i].type != "button"){
           document.forms.catalogo_unidad.elements[i].disabled=false;
        }
	}
}

function IniciarBotones(){
catalogo_unidad.btnBuscar.disabled=false;
catalogo_unidad.btnAgregar.disabled=false;
catalogo_unidad.btnModificar.disabled=true;
catalogo_unidad.btnEliminar.disabled=true;
catalogo_unidad.btnGuardar.disabled=true;
catalogo_unidad.btnCancelar.disabled=true;
catalogo_unidad.btnSalir.disabled=false;
}

function IniciarBotonAgregar(){
catalogo_unidad.btnBuscar.disabled=true;
catalogo_unidad.btnAgregar.disabled=true;
catalogo_unidad.btnModificar.disabled=true;
catalogo_unidad.btnEliminar.disabled=true;
catalogo_unidad.btnGuardar.disabled=false;
catalogo_unidad.btnCancelar.disabled=false;
catalogo_unidad.btnSalir.disabled=true;
}

function IniciarBotonModificar(){
catalogo_unidad.btnBuscar.disabled=true;
catalogo_unidad.btnAgregar.disabled=true;
catalogo_unidad.btnModificar.disabled=true;
catalogo_unidad.btnEliminar.disabled=true;
catalogo_unidad.btnGuardar.disabled=false;
catalogo_unidad.btnCancelar.disabled=false;
catalogo_unidad.btnSalir.disabled=true;
}


function IniciarBotonBuscar(){
catalogo_unidad.btnBuscar.disabled=false;
catalogo_unidad.btnAgregar.disabled=true;
catalogo_unidad.btnModificar.disabled=false;
catalogo_unidad.btnEliminar.disabled=false;
catalogo_unidad.btnGuardar.disabled=true;
catalogo_unidad.btnCancelar.disabled=false;
catalogo_unidad.btnSalir.disabled=false;
}



</script>

<section class="container">
<div class="login">

<h1>
<?php include_once('titulo_sistema.html');?>
</h1>

<body onLoad="DeshabilitarTodo(); 
IniciarBotones() ">

<center>
<h2>MANTENIMIENTO DE UNIDAD DE MEDIDA</h2>

<br />
<form name="catalogo_unidad" method="post">

<table>

<tr>
<td>
Unidad
</td>
<td>
<input type="hidden" name="id_unidad" id="id_unidad" size="5" />
<input type="text" name="txt_unidad" id="txt_unidad" size="50" 
 onBlur="this.value=this.value.toUpperCase();" />

    
<input type="button" onClick="TINY.box.show({iframe:'catalogo_unidad_buscar.php' 
	,boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}});
	" name="btnBuscar" value="Buscar" title="Buscar unidad" />    
    
</td>

</tr>

</table>



<table border="0">

  <tr>
    <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_unidad.txt_unidad.focus(); modoop=1; document.getElementById('targetDiv').innerHTML=''"/></td>
    
    <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
	if (catalogo_unidad.txt_unidad.value=='' && catalogo_unidad.txt_unidad.value==''){
    	alert('Por favor, Buscar registro a Modificar')
        }
    else{
    	HabilitarTodo(); IniciarBotonModificar(); modoop=2
    }"/>
</td>

    <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
    if (catalogo_unidad.id_unidad.value!='') {
    if(confirm('Esta seguro que desea Eliminar este Registro?')) {sendQueryToDelete('catalogo_unidad_eliminar.php?id_unidad='+catalogo_unidad.id_unidad.value, 'targetDiv'); catalogo_unidad.txt_unidad.value='';}
    }
    else alert('Por favor, Buscar registro a Eliminar')"/>
</td>
  </tr>
  <tr>
    <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
    if (modoop==1)
sendQueryToAdd('catalogo_unidad_guardar.php?modoop=1&txt_unidad='+catalogo_unidad.txt_unidad.value,
'targetDiv');
    if (modoop==2)
sendQueryToEdit('catalogo_unidad_guardar.php?modoop=2&txt_unidad='+catalogo_unidad.txt_unidad.value+
'&id_unidad='+catalogo_unidad.id_unidad.value,
'targetDiv');
IniciarBotones();
"/>
	</td>
    <td><input type="button" name="btnCancelar" value="Cancelar"   size="10" onClick="DeshabilitarTodo(); IniciarBotones()"/></td>
    <td><input type="button" name="btnSalir" value="     Salir    "   size="10" onClick="change_option('btnSalir')"/></td>
  </tr>

</table>

<div id="targetDiv"></div>

</form>

</center>

</body>

</div>
</section>

</html>

