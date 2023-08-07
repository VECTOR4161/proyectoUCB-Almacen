<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idpermiso, permisonombre FROM permiso ORDER BY permisonombre ASC";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT idpermiso, permisonombre FROM permiso ORDER BY permisonombre ASC";
		return ejecutarConsulta($sql);		
	}

	public function listarmarcados($idrol)
	{
		$sql="SELECT p.idpermiso, p.permisonombre FROM rol_permiso r, permiso p WHERE r.idpermiso=p.idpermiso AND idrol='$idrol'";
		return ejecutarConsulta($sql);
	}
}

?>