<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnn = "srvdat01";
$database_cnn = "almacen";
$username_cnn = "root";
$password_cnn = "Pazzword-007";

$cnn = mysql_pconnect($hostname_cnn, $username_cnn, $password_cnn) or trigger_error(mysql_error(),E_USER_ERROR); 

//Convierto los acentos a HTML
function chao_tilde($entra)
{
$traduce=array( 'á' => '&aacute;' , 'é' => '&eacute;' , 'í' => '&iacute;' , 'ó' => '&oacute;' , 'ú' => '&uacute;' , 'ñ' => '&ntilde;' , 'Ñ' => '&Ntilde;' , 'ä' => '&auml;' , 'ë' => '&euml;' , 'ï' => '&iuml;' , 'ö' => '&ouml;' , 'ü' => '&uuml;');
$sale=strtr( $entra , $traduce );
return $sale;
}




?>