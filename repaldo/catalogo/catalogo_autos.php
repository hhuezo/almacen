<html>
<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/botones.css" />
</head>

<script language="JavaScript">
var modoop=0;


function change_option(parametro){
         switch(parametro){
         case 'btnSalir': document.catalogo_autos.action="../index.php"; break;
}
document.catalogo_autos.submit();
}

function LimpiarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_autos.elements.length;i++){
		if(document.forms.catalogo_autos.elements[i].type == "text"){
           document.forms.catalogo_autos.elements[i].value='';
        }
		if(document.forms.catalogo_autos.elements[i].type == "checkbox"){
           document.forms.catalogo_autos.elements[i].value=0;
        }
	}
}

function DeshabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_autos.elements.length;i++){
		if(document.forms.catalogo_autos.elements[i].type != "button"){
           document.forms.catalogo_autos.elements[i].disabled=true;
        }
	}
}


function HabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_autos.elements.length;i++){
		if(document.forms.catalogo_autos.elements[i].type != "button"){
           document.forms.catalogo_autos.elements[i].disabled=false;
        }
	}
}

function IniciarBotones(){
catalogo_autos.btnBuscar.disabled=false;
catalogo_autos.btnAgregar.disabled=false;
catalogo_autos.btnModificar.disabled=true;
catalogo_autos.btnEliminar.disabled=true;
catalogo_autos.btnGuardar.disabled=true;
catalogo_autos.btnCancelar.disabled=true;
catalogo_autos.btnSalir.disabled=false;
}

function IniciarBotonAgregar(){
catalogo_autos.btnBuscar.disabled=true;
catalogo_autos.btnAgregar.disabled=true;
catalogo_autos.btnModificar.disabled=true;
catalogo_autos.btnEliminar.disabled=true;
catalogo_autos.btnGuardar.disabled=false;
catalogo_autos.btnCancelar.disabled=false;
catalogo_autos.btnSalir.disabled=true;
}

function IniciarBotonModificar(){
catalogo_autos.btnBuscar.disabled=true;
catalogo_autos.btnAgregar.disabled=true;
catalogo_autos.btnModificar.disabled=true;
catalogo_autos.btnEliminar.disabled=true;
catalogo_autos.btnGuardar.disabled=false;
catalogo_autos.btnCancelar.disabled=false;
catalogo_autos.btnSalir.disabled=true;
}


function IniciarBotonBuscar(){
catalogo_autos.btnBuscar.disabled=false;
catalogo_autos.btnAgregar.disabled=true;
catalogo_autos.btnModificar.disabled=false;
catalogo_autos.btnEliminar.disabled=false;
catalogo_autos.btnGuardar.disabled=true;
catalogo_autos.btnCancelar.disabled=false;
catalogo_autos.btnSalir.disabled=true;
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
<h2>MANTENIMIENTO DE AUTOMOVILES</h2>

<br />
<form name="catalogo_autos" method="post">

<table>

  <tr>
     <td >Automovil</td><td > 
		 
		 <input type="hidden" name="id_auto" id="id_auto" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
		 <input type="text" name="txt_auto" id="txt_auto" size="35" onKeyUp="this.value = this.value.toUpperCase();">
		<input type="button" onClick="TINY.box.show({iframe:'catalogo_autos_buscar.php' 
		,boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}});
		" name="btnBuscar" value="Buscar" title="Buscar articulos" />    		 
	     
		 </td>
    
  </tr>
  <tr>
    <td >Equipo</td>
    <td><input type="text" name="equipo" id="equipo"></td>
  </tr> 
  <tr>
    <td >Placa</td>
  <td><input type="text" name="placa" id="placa"> </td>
  </tr>  
 <tr>
 <td >Marca</td><td>
 <input type="hidden" name="id_marca" id="id_marca" size="5" readonly="true">
 <input type="text" name="txt_marca" id="txt_marca" size="35" readonly="true">
 
   		 <a href="#" onClick="TINY.box.show({iframe:'catalogo_marca_buscar.php',boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
         class="enlacebotonimagen" name="btnBuscar">
		 <img src="css/16-Search.ico"></a>  
    </td>
 </tr>
<tr>
<td>
Departamento
</td>
<td>
<input type="hidden" name="id_departamento" id="id_departamento" size="5" />
<input type="text" name="txt_departamento" id="txt_departamento" size="50" 
 onBlur="this.value=this.value.toUpperCase();" />    
 <a href="#" onClick="TINY.box.show({iframe:'catalogo_departamentos_buscar.php',boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
         class="enlacebotonimagen" name="btnBuscar">
		 <img src="css/16-Search.ico"></a>     
    
</td>
</tr>
</table>



<table border="0">

  <tr>
    <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="modoop=1; HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_autos.txt_auto.focus(); document.getElementById('targetDiv').innerHTML=''"/></td>
    
    <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
	if (catalogo_autos.id_auto.value==''){
    	alert('Por favor, Buscar registro a Modificar')
        }
    else{
    	HabilitarTodo(); IniciarBotonModificar(); modoop=2
    }"/>
</td>

    <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
    if (catalogo_autos.id_auto.value!='') {
    if(confirm('Esta seguro que desea Eliminar este Registro?')) {sendQueryToDelete('catalogo_autos_eliminar.php?id_auto='+catalogo_autos.id_auto.value, 'targetDiv'); LimpiarTodo();}
    }
    else alert('Por favor, Buscar registro a Eliminar')"/>
</td>
  </tr>
  <tr>
    <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
//	alert(modoop);
    if (modoop==1)
sendQueryToAdd('catalogo_autos_guardar.php?modoop=1&txt_auto='+catalogo_autos.txt_auto.value+'&equipo='+catalogo_autos.equipo.value+'&placa='+catalogo_autos.placa.value+'&id_marca='+catalogo_autos.id_marca.value+'&txt_marca='+catalogo_autos.txt_marca.value+'&id_departamento='+catalogo_autos.id_departamento.value,
'targetDiv');
    if (modoop==2)
sendQueryToEdit('catalogo_autos_guardar.php?modoop=2&txt_auto='+catalogo_autos.txt_auto.value+'&equipo='+catalogo_autos.equipo.value+'&placa='+catalogo_autos.placa.value+'&id_marca='+catalogo_autos.id_marca.value+'&txt_marca='+catalogo_autos.txt_marca.value+'&id_auto='+catalogo_autos.id_auto.value+'&id_departamento='+catalogo_autos.id_departamento.value,
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

