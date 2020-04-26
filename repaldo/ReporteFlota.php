
<?php 



	header("Content-Type: application/vnd.ms-excel");

	header("Expires: 0");

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("content-disposition: attachment;filename=ReporteFlota.xls");




	require('clases/conexion.php'); 
	require('conectar/conectar.php'); 
	$conn = odbc_connect( "odbcTaller", "Taller", "Ta11er" )or die ("error EN LA CONEXION");
	$sql="select MAX(s.CodSolicitud) as codigo 
	from SolicitudReparacion s inner join Automovil a on s.Automovil = a.Oid
	where s.Automovil <> '983456C9-46E1-40A9-9C5B-06822E1AB100' and s.FechaEntrada between '01/01/2016' and '31/12/2016'
	group by s.Automovil ";
	$rs = odbc_exec( $conn, $sql);
	
	$i=1;
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="delete from ReporteFlota";
	$objCon->Ejecutar($sql);
	$objCon->Cerrar();
	
	while (odbc_fetch_row($rs))
	{	
		$codigo = odbc_result($rs,"codigo");
		
		$sql="select s.CodSolicitud,a.NumeroEquipo,a.NumeroPlaca,m.MarcaAuto,c.ClaseAuto,a.Axo,
		(select top 1 salida.TrabajoRealizado from SolicitudSalidaVehiculo salida where salida.SalidaVehiculo = s.Oid) as trabajo,
		(select ISNULL(SUM(rep.Cantidad * rep.PrecioAproximado),0) from SolicitudRepuestos rep where rep.SolicitudRepuesto = s.Oid) as CostoAproximado,
		s.CostoEjecucionReal,d.NombreDepartamento,DATEPART(dd,s.FechaEntrada) AS Dia,DATEPART(mm,s.FechaEntrada) AS Mes,DATEPART(yyyy,s.FechaEntrada) AS Anio
		from SolicitudReparacion s 
		inner join Automovil a on s.Automovil=a.Oid 
		inner join AutoMarca m on m.oid = a.AutoMarca
		inner join AutoClase c on c.oid = a.AutoClase
		inner join Departamento d on a.Departamento = d.oid
		where  s.Oid = (select Oid from SolicitudReparacion sol where sol.CodSolicitud = $codigo)";
		//echo $sql.'<br>';
		
		$rsD = odbc_exec( $conn, $sql);
		odbc_fetch_row($rsD);
		$CodSolicitud=odbc_result($rsD, "CodSolicitud");
		$NumeroEquipo=odbc_result($rsD, "NumeroEquipo");
		$NumeroPlaca=odbc_result($rsD, "NumeroPlaca");
		$MarcaAuto=odbc_result($rsD, "MarcaAuto");
		$ClaseAuto=odbc_result($rsD, "ClaseAuto");
		$Axo=odbc_result($rsD, "Axo");
		$trabajo=odbc_result($rsD, "trabajo");
		$CostoAproximado=odbc_result($rsD, "CostoAproximado");
		$CostoEjecucionReal=odbc_result($rsD, "CostoEjecucionReal");
		$NombreDepartamento=odbc_result($rsD, "NombreDepartamento");
		if(odbc_result($rsD, "Mes")<10){$mes = '0'.odbc_result($rsD, "Mes");}else {$mes = odbc_result($rsD, "Mes");}
		if(odbc_result($rsD, "Dia")<10){$Dia = '0'.odbc_result($rsD, "Dia");}else {$Dia = odbc_result($rsD, "Dia");}
		
		$FechaEntrada= $Dia.'/'.$mes.'/'.odbc_result($rsD, "Anio");
		
		$objCon=new Conexion();
		$objCon->Abrir();
		$sql="insert into ReporteFlota (CodSolicitud,NumeroEquipo,NumeroPlaca,MarcaAuto,ClaseAuto,Axo,trabajo,CostoAproximado,CostoEjecucionReal,NombreDepartamento,FechaEntrada)
		values($CodSolicitud,'$NumeroEquipo','$NumeroPlaca','$MarcaAuto','$ClaseAuto','$Axo','$trabajo',$CostoAproximado,$CostoEjecucionReal,'$NombreDepartamento','$FechaEntrada')";
		//echo $sql.'<br>';
		$objCon->Ejecutar($sql);
		$objCon->Cerrar();	
		
	}
	
	
	$sql="select distinct NombreDepartamento from reporteflota order by NombreDepartamento";
	$objCon=new Conexion();
	$objCon->Abrir();
	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){
		  while($rs = $result->fetch_array())
				{
				$Dep=$rs[0];
				}
		}
?>


<table width="80%" border="1" align="center">
<tr>
    <td colspan="10"><div align="center"><strong>INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA</strong></div></td>  </tr>
	<td colspan="10"><div align="center"><strong>TRANSPORTE Y TALLER MECANICO</div></strong></td>  </tr>
	<td colspan="10"><div align="center"><strong> FLOTA VEHICULAR 2017</div></strong></td></tr>
		<td colspan="10"><div align="center">&nbsp; </div></td>
  </tr>

<?php 
	$objCon=new Conexion();
	$objCon->Abrir();
	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){
			while($rs = $result->fetch_array())
			{
				echo '<tr><td colspan="10" align="center"><strong>'.chao_tilde($rs[0]).'</strong></td></tr>';
				echo '<tr>';
					echo '<td>SOLICITUD</td>';
					echo '<td>FECHA</td>';
					echo '<td>EQUIPO</td>';
					echo '<td>PLACA</td>';
					echo '<td>MARCA</td>';
					echo '<td>CLASE</td>';
					echo '<td>A&NtildeO</td>';
					echo '<td>REPARACION REQUERIDA</td>';
					echo '<td>COSTO APROXIMADO</td>';
					echo '<td>VAL. LIBRO</td>';
				echo '</tr>';
				
				$sql2="select * from ReporteFlota where NombreDepartamento = '".$rs[0]."'";
				
				$objCon->RetornarRS($result2, $sql2);
				    if ($objCon->ExisteRegistro($sql2)){
						while($rs2 = $result2->fetch_array())
						{
							echo '<tr>';
								echo '<td>'.$rs2[0].'</td>';
								echo '<td>'.$rs2[10].'</td>';
								echo '<td>'.$rs2[1].'</td>';
								echo '<td>'.$rs2[2].'</td>';
								echo '<td>'.$rs2[3].'</td>';
								echo '<td>'.$rs2[4].'</td>';
								echo '<td>'.$rs2[5].'</td>';
								echo '<td>'.chao_tilde($rs2[6]).'</td>';
								echo '<td align="right">$'.$rs2[7].'</td>';
								echo '<td align="right">$'.$rs2[8].'</td>';
							echo '</tr>';
						}
						echo '<tr><td colspan="10" align="center">&nbsp;</td></tr>';
					}				
			
			}
		}

?>
  
</table>
