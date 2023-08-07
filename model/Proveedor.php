<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proveedor
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
		$sqlp="INSERT INTO proveedor (idpersona) VALUES ('$idpersona')";
		return ejecutarConsulta($sqlp);
	}

	//Implementamos un método para editar registros
	public function editar($idproveedor,$nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen)
	{
		$idpersona=$this->idpersona_proveedor($idproveedor);
		$sql="UPDATE persona SET personanombre='$nombre', personaap='$apellidop', personaam='$apellidom',personatipo_documento='$tipo_documento',personanum_documento='$num_documento',personadireccion='$direccion',personaemail='$email',personaimagen='$imagen' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idproveedor)
	{
		$sql="UPDATE proveedor SET proveedorcondicion='0' WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idproveedor)
	{
		$sql="UPDATE proveedor SET proveedorcondicion='1' WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproveedor)
	{
		$sql="SELECT * FROM persona p, proveedor r WHERE p.idpersona=r.idpersona AND idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM persona p, proveedor r WHERE p.idpersona=r.idpersona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function idpersona_proveedor($idproveedor)
	{
		$sql="SELECT p.idpersona FROM persona p, proveedor c WHERE p.idpersona=c.idpersona AND c.idproveedor='$idproveedor'";
		$idpersona = ejecutarConsultaSimpleFila($sql);
		return $idpersona["idpersona"];
	}

	public function select()
	{
		$sql="SELECT c.idproveedor, p.personanombre, p.personaap, p.personaam FROM persona p, proveedor c WHERE p.idpersona=c.idpersona AND(c.proveedorcondicion=1) ORDER BY p.personaap, p.personaam, p.personanombre ASC";
		return ejecutarConsulta($sql);		
	}

}

?>