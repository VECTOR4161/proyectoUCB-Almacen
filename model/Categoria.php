<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Categoria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idcategoria, categorianombre, categoriacondicion FROM categoria";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$validacion=$this->comprueba_duplicados($nombre,0);
		if($validacion==0){
			$sql="INSERT INTO categoria (categorianombre)
			VALUES ('$nombre')";
			return ejecutarConsulta($sql);
		}
		else{return 0;}
	}

	//Implementamos un método para editar registros
	public function editar($idcategoria,$nombre)
	{
		$validacion=$this->comprueba_duplicados($nombre,$idcategoria);
		if($validacion==0){
			$sql="UPDATE categoria SET categorianombre='$nombre' 
			WHERE idcategoria='$idcategoria'";
			return ejecutarConsulta($sql);
		}
		else{return 0;}
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcategoria)
	{
		$sql="UPDATE categoria SET categoriacondicion='0' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET categoriacondicion='1' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcategoria)
	{
		$sql="SELECT idcategoria, categorianombre, categoriacondicion FROM categoria WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function select()
	{
		$sql="SELECT idcategoria, categorianombre FROM categoria 
		WHERE (categoriacondicion=1) ORDER BY categorianombre ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function comprueba_duplicados($codigo,$id)
	{
		$resultado=0;
		$sql="SELECT COUNT(idcategoria) AS idcategoria FROM categoria WHERE (categorianombre='$codigo') AND (idcategoria<>$id)";
		$resultado = ejecutarConsultaSimpleFila($sql);
		return $resultado['idcategoria'];		
	}

}

?>