<?php
require_once('../conexion/conexion_usuario.php');
if (isset($_GET["Articulo"])) {
    $Articulo = $_GET["Articulo"];
    $IdArticulo = $_GET["IdArticulo"];
} else {
    $Articulo = "";
    $IdArticulo = "";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>entrada</title>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../style_tinybox.css" />
        <script type="text/javascript" src="../tinybox.js"></script>
        <!--FIN para ventana modal js-->

        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/botones.css" />         

        <!--  select 2 -->
        <script src="../select2/jquery.js" type="text/javascript"></script>
        <script src="../select2/select2.min.js" type="text/javascript"></script>
        <link href="../select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- // select 2 -->


    </head>
    <body>
        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                <h2>HISTORIAL POR PRODUCTO</h2>

                <form name="kardex" method="post" >

                    <table height="106" border="1">

                        <tr>
                            <td >Articulo</td>
                            <td> 
                                <input type="hidden" value="<?php echo $IdArticulo; ?>"  id="IdArticulo" style="width: 350px" readonly>
                                <input type="text" value="<?php echo $Articulo; ?>" id="Articulo" style="width: 400px; height: 27px" readonly>
                                <input type="hidden"  id="Existencia" style="width: 350px" readonly>
                            </td>
                            <td>
                                <a href="#" onClick="TINY.box.show({iframe: 'articulo_activo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="../css/16-Search.ico"></a>
                            </td>

                        </tr>


                        <tr>
                            <td>Año</td>
                            <td>
                                <select id="Axo" style="width: 400px; height: 27px">
                                    <option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
                                    <option value="0">Todos</option>
                                </select>	   
                            </td>
                        </tr>


                        <tr align='center'>
                            <td height="22" colspan="2">
                                <input type="button" id="btn_aceptar" value="Aceptar"> 
                                <a href="../inicio.php"> <input type="button"  value="Cancelar"> </a>
                            </td>

                        </tr>

                    </table>
                    <div id="targetDiv"  ></div>
                </form>


            </div>
        </section>
    </body>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>


    <script type="text/javascript">
        $(document).ready(function () {

            if (document.getElementById('Articulo').value != "")
            {
                consultar();

            }

            $('#btn_aceptar').click(function () {

                if (document.getElementById('Articulo').value.trim() == '') {
                    alert('Error!, debe elegir un articulo');
                    return false;
                }

                consultar();


            });
        });

        function consultar()
        {
            $.get('kardex_aceptar.php',
                    {
                        Axo: document.getElementById('Axo').value,
                        Articulo: document.getElementById('IdArticulo').value,
                    },
                    function (data, status) {
                        $('#targetDiv').html(data);
                        // alert(data);
                    });
        }


    </script>

</html>
<?php
mysqli_close($cn);
?>