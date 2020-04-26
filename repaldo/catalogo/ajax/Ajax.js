function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}


      function sendQueryToSelect(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource);
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }		  

	        function sendQueryToText(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource);
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.value = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }		  
	  
      function sendQueryToAdd(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource); 
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }		  

      function sendQueryToEdit(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource); 
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }	

      function sendQueryToDelete(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource); 
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }

      function buscarAceptar(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource);
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }

      function sendQueryToShow(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource); 
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }		 

      function anularAceptar(dataSource, divID)
      {
        // Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();

        if(ajax) {
          var obj = document.getElementById(divID);
//alert(dataSource); 
          ajax.open("GET", dataSource);

          ajax.onreadystatechange = function()
          {
            if (ajax.readyState == 4 &&
              ajax.status == 200) {
                obj.innerHTML = ajax.responseText;
            }
          }

          ajax.send(null);
        }
      }		  