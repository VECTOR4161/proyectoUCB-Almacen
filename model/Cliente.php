<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cliente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen)
	{
		$sql="INSERT INTO persona (personanombre, personaap, personaam, personatipo_documento, personanum_documento, personadireccion, personaemail, personaimagen)
		VALUES ('$nombre','$apellidop','$apellidom','$tipo_documento','$num_documento', '$direccion', '$email', '$imagen') RETURNING idpersona;";
		$idpersona = ejecutarConsulta_retornarID($sql);
		$sqlp="INSERT INTO cliente (idpersona) VALUES ('$idpersona')";
		return ejecutarConsulta($sqlp);
	}

	//Implementamos un método para editar registros
	public function editar($idcliente,$nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen)
	{
		$idpersona=$this->idpersona_cliente($idcliente);
		$sql="UPDATE persona SET personanombre='$nombre', personaap='$apellidop', personaam='$apellidom',personatipo_documento='$tipo_documento',personanum_documento='$num_documento',personadireccion='$direccion',personaemail='$email',personaimagen='$imagen' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcliente)
	{
		$sql="UPDATE cliente SET clientecondicion='0' WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcliente)
	{
		$sql="UPDATE cliente SET clientecondicion='1' WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcliente)
	{
		$sql="SELECT * FROM persona p, cliente r WHERE p.idpersona=r.idpersona AND idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM persona p, cliente r WHERE p.idpersona=r.idpersona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function idpersona_cliente($idcliente)
	{
		$sql="SELECT p.idpersona FROM persona p, cliente c WHERE p.idpersona=c.idpersona AND c.idcliente='$idcliente'";
		$idpersona = ejecutarConsultaSimpleFila($sql);
		return $idpersona["idpersona"];
	}

	public function select()
	{
		$sql="SELECT c.idcliente, p.personanombre, p.personaap, p.personaam FROM persona p, cliente c WHERE p.idpersona=c.idpersona AND(c.clientecondicion=1) ORDER BY p.personaap, p.personaam, p.personanombre ASC";
		return ejecutarConsulta($sql);		
	}

}

?>