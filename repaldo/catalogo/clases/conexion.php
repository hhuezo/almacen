<?php
//session_start();
/**********************************************************************************
ARCHIVO:		CONEXION.PHP
PROPOSITO:		- Conectar y Cerrar la base de datos
**********************************************************************************/
// ** Inicio: Definición de Clase
class Conexion{
	//Variables Publicas
	public $errorBD;

	//Variables Privadas
	private $objMySQL;

	function __construct(){
		$this->_servidor = 'SRVDAT01';
		$this->_usuario = 'root';
		$this->_clave = 'Pazzword-007';
		$this->_basedatos = 'almacen';
	}

	//Función que nos indica si la conexión a la BD ha sido correcta.
	public function Abrir(){
		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if (mysqli_connect_errno()){
			$this->errorBD="<b>AccesoBD->Abrir: </b>".mysqli_connect_error();
			echo $this->errorBD;
		}
	}

	//Función que nos devuelve True si existe un registro.
	public function ExisteRegistro($sql){
		$contador=0;
		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if ($sentenciaSQL = $objMySQL->query($sql)){
			while ($fila = $sentenciaSQL->fetch_assoc()) {
				$contador=1;
			}
			if ($contador == 1){
				return true;
			}else{
				return false;
			}
		}
	}

	//Devuelve Registros a partir de una sentencia sql
	public function RetornarRS(&$rs, $sql){
  		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if (!$sentenciaSQL = $objMySQL->query($sql)){
			$this->errorBD = "<b>AccesoBD->RetornarRS: </b>".$objMySQL->error;
			echo $this->errorBD;
		}
		$rs = $sentenciaSQL;
	}
	
	//Devuelve Registros a partir de una sentencia sql
	public function RetornarNumeroRegistrosRS(&$num_reg, $sql){
  		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if (!$sentenciaSQL = $objMySQL->query($sql)){
			$this->errorBD = "<b>AccesoBD->RetornarRS: </b>".$objMySQL->error;
			echo $this->errorBD;
		}
		$rs = $sentenciaSQL;
		$num_reg = $rs->num_rows;
	}		

	//Ejecuta una sentencia sql
	public function Ejecutar($sql){
  		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if (!$sentenciaSQL = $objMySQL->query($sql)){
			$this->errorBD = "<b>AccesoBD->Ejecutar: </b>".$objMySQL->error;
			echo $this->errorBD;
		}
	}
	
    //Cierra conexion a BD
	public function Cerrar(){
  		$objMySQL = new mysqli($this->_servidor, $this->_usuario,
                               $this->_clave, $this->_basedatos);
		if(!$objMySQL->close()){
			$this->errorBD = "<b>AccesoBD->Cerrar: </b>".$objMySQL->error;
			echo $this->errorBD;
		}
	}
}
// ** Fin: Definición de Clase
?>
