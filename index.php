<html>
    <?php
    session_start();
    require_once('conexion/conexion.php');

    if (isset($_SESSION['Usuario'])) {
        header("Location: inicio.php");
        exit();
    }
    ?>

    <head>
        <title>Almacen</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
    </head>


    <section class="container">
        <div class="login">
            <h1>Acceso al Sistema</h1>
            <form name="login" method="post">
                <table align='center'>
                    <body>
                    <tr>
                        <td>Usuario </td>
                        <td><input  type="text" name="username" id="username" size="12"/></td>
                    </tr>

                    <tr>
                        <td>Clave</td>
                        <td><input type="password" name="password" size="12"/> </td>
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
                if (isset($_POST['btnAceptar'])) {

                    $Usuario = $_POST['username'];
                    $Clave = $_POST['password'];

                    $rs = mysqli_query($cn, "SELECT * FROM usuario WHERE Usuario='$Usuario' and Clave='$Clave' and Activo = '1'");

                    if (mysqli_num_rows($rs) > 0) {
                        $row = mysqli_fetch_array($rs);
                        $_SESSION['IdUsuario'] = $row['Id'];
                        $_SESSION['Usuario'] = $row['Usuario'];
                        $_SESSION['Rol'] = $row['Rol'];
                        header("Location: inicio.php");
                    } else {
                        unset($_SESSION['Usuario']);
                        echo "<p class='remember_me'>
                            <label>
                                <center> Usuario o Clave NO Valido</center>
                            </label>
                                </p>";
                    }

                    mysqli_close($cn); //cierro la conexion 
                }
                ?>  
            </form>
        </div>
    </section>	

</body>
</html>





