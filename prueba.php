<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once('conexion/conexion.php');
       // require_once('conexion/conexion_taller.php');
        
        
         $rs = mysqli_query($cn, "select distinct(Orden) as Orden,a from kardex where Orden <> 4");
          while ($row = mysqli_fetch_array($rs)) {
              $sql="update orden set Agrupacion = ".$row["a"]." where Id = ".$row["Orden"];
             // mysqli_query($cn, $sql);
              echo $sql.'<br>';
              
              //echo $row["Equipo"].' '.$row["Placa"].'<br>';
              
             /*  $stmt = sqlsrv_query($conn, "SELECT     dbo.Automovil.Oid, dbo.Automovil.NumeroEquipo, dbo.Automovil.NumeroPlaca, dbo.AutoMarca.MarcaAuto, dbo.AutoClase.ClaseAuto, dbo.AutoModelo.Modelo
                FROM         dbo.Automovil left JOIN
                                      dbo.AutoMarca ON dbo.Automovil.AutoMarca = dbo.AutoMarca.Oid LEFT JOIN
                                      dbo.AutoClase ON dbo.Automovil.AutoClase = dbo.AutoClase.Oid LEFT JOIN
                                      dbo.AutoModelo ON dbo.Automovil.AutoModelo = dbo.AutoModelo.Oid
                      where dbo.Automovil.NumeroPlaca = '".$row["Placa"]."' or dbo.Automovil.NumeroEquipo = '".$row["Equipo"]."'  ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
               
              
               
               if(sqlsrv_num_rows($stmt)>0)
               {
                   $row_sql = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                   $sql="update vehiculo set Oid = '".$row_sql["Oid"]."', Equipo = '".$row_sql["NumeroEquipo"]."',Placa = '".$row_sql["NumeroPlaca"]."',Marca = '".$row_sql["MarcaAuto"]."',"
                           . "Descripcion = '".$row_sql["ClaseAuto"]." - ".$row_sql["Modelo"]."' where Id = ".$row["Id"]."";
                   
                   echo $sql.'<br>';
                   mysqli_query($cn, $sql);
               }*/
          }
        ?>
    </body>
</html>
