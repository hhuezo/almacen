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
         case 'btnSalir': document.catalogo_usuario.action="../index.php"; break;
}
document.catalogo_usuario.submit();
}

function LimpiarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_usuario.elements.length;i++){
		if(document.forms.catalogo_usuario.elements[i].type == "text"){
           document.forms.catalogo_usuario.elements[i].value='';
        }
		if(document.forms.catalogo_usuario.elements[i].type == "checkbox"){
           document.forms.catalogo_usuario.elements[i].value=0;
        }
	}
}

function DeshabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_usuario.elements.length;i++){
		if(document.forms.catalogo_usuario.elements[i].type != "button"){
           document.forms.catalogo_usuario.elements[i].disabled=true;
        }
	}
}


function HabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_usuario.elements.length;i++){
		if(document.forms.catalogo_usuario.elements[i].type != "button"){
           document.forms.catalogo_usuario.elements[i].disabled=false;
        }
	}
}

function IniciarBotones(){
catalogo_usuario.btnBuscar.disabled=false;
catalogo_usuario.btnAgregar.disabled=false;
catalogo_usuario.btnModificar.disabled=true;
catalogo_usuario.btnEliminar.disabled=true;
catalogo_usuario.btnGuardar.disabled=true;
catalogo_usuario.btnCancelar.disabled=true;
catalogo_usuario.btnSalir.disabled=false;
}

function IniciarBotonAgregar(){
catalogo_usuario.btnBuscar.disabled=true;
catalogo_usuario.btnAgregar.disabled=true;
catalogo_usuario.btnModificar.disabled=true;
catalogo_usuario.btnEliminar.disabled=true;
catalogo_usuario.btnGuardar.disabled=false;
catalogo_usuario.btnCancelar.disabled=false;
catalogo_usuario.btnSalir.disabled=true;
}

function IniciarBotonModificar(){
catalogo_usuario.btnBuscar.disabled=true;
catalogo_usuario.btnAgregar.disabled=true;
catalogo_usuario.btnModificar.disabled=true;
catalogo_usuario.btnEliminar.disabled=true;
catalogo_usuario.btnGuardar.disabled=false;
catalogo_usuario.btnCancelar.disabled=false;
catalogo_usuario.btnSalir.disabled=true;
}


function IniciarBotonBuscar(){
catalogo_usuario.btnBuscar.disabled=false;
catalogo_usuario.btnAgregar.disabled=true;
catalogo_usuario.btnModificar.disabled=false;
catalogo_usuario.btnEliminar.disabled=false;
catalogo_usuario.btnGuardar.disabled=true;
catalogo_usuario.btnCancelar.disabled=false;
catalogo_usuario.btnSalir.disabled=true;
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
<h2>MANTENIMIENTO DE USUARIOS</h2>

<br />
<form name="catalogo_usuario" method="post">

<table>

  <tr>
     <td >Usuario</td><td > 
		 
		 <input type="hidden" name="id_usuario" id="id_usuario" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
		 <input type="text" name="txt_usuario" id="txt_usuario" size="35" onKeyUp="this.value = this.value.toUpperCase();">
		<input type="button" onClick="TINY.box.show({iframe:'catalogo_usuario_buscar.php' 
		,boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}});
		" name="btnBuscar" value="Buscar" title="Buscar articulos" />    		 
	     
		 </td>    
  </tr>
  <tr>
    <td >Clave</td>
    <td><input type="text" name="txt_clave" id="txt_clave"></td>
  </tr>   
 <tr>
	<td >Rol</td><td>
		<input type="hidden" name="id_rol" id="id_rol" size="5" readonly="true">
		<input type="text" name="txt_rol" id="txt_rol" size="35" readonly="true">
	 
		<a href="#" onClick="TINY.box.show({iframe:'catalogo_rol_buscar.php',boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
		class="enlacebotonimagen" name="btnBuscar">
		<img src="css/16-Search.ico"></a>  
    </td>
 </tr>
   <tr>
	<td>Estado</td>
	<td>
		<select name="cmb_estado">
		<option value="1">Activo</option>
		<option value="0">Inactivo</option>
		</select>	   
	</td>
  </tr>
</table>

<table border="0">

  <tr>
    <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="modoop=1; HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_usuario.txt_usuario.focus(); document.getElementById('targetDiv').innerHTML=''"/></td>
    
    <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
	if (catalogo_usuario.id_usuario.value==''){
    	alert('Por favor, Buscar registro a Modificar')
        }
    else{
    	HabilitarTodo(); IniciarBotonModificar(); modoop=2
    }"/>
</td>

    <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
    if (catalogo_usuario.id_usuario.value!='') {
    if(confirm('Esta seguro que desea Eliminar este Registro?')) {sendQueryToDelete('catalogo_usuario_eliminar.php?id_usuario='+catalogo_usuario.id_usuario.value, 'targetDiv'); LimpiarTodo();}
    }
    else alert('Por favor, Buscar registro a Eliminar')"/>
</td>
  </tr>
  <tr>
    <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
//	alert(modoop);
    if (modoop==1)
sendQueryToAdd('catalogo_usuario_guardar.php?modoop=1&id_usuario='+catalogo_usuario.id_usuario.value+'&txt_usuario='+catalogo_usuario.txt_usuario.value+'&txt_clave='+catalogo_usuario.txt_clave.value+'&id_rol='+catalogo_usuario.id_rol.value+'&cmb_estado='+catalogo_usuario.cmb_estado.value,
'targetDiv');
    if (modoop==2)
sendQueryToEdit('catalogo_usuario_guardar.php?modoop=2&id_usuario='+catalogo_usuario.id_usuario.value+'&txt_usuario='+catalogo_usuario.txt_usuario.value+'&txt_clave='+catalogo_usuario.txt_clave.value+'&id_rol='+catalogo_usuario.id_rol.value+'&cmb_estado='+catalogo_usuario.cmb_estado.value,
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

