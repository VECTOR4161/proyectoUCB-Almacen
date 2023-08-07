<?php
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Notificacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function listar_notificacion()
	{
			$sql="SELECT titulo, contenido FROM notificacion;";
			return ejecutarConsulta($sql);
	}
	//Implementamos un método para insertar registros
	public function insertar($titulo, $contenido)
	{
			$sql="INSERT INTO notificacion(titulo, contenido, leido)
            VALUES ('$titulo', '$contenido', '1');";
			return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idnotificacion)
	{
		$sql="UPDATE notificacion SET leido='0' WHERE idarticulo='$idnotificacion'";
		return ejecutarConsulta($sql);
	}

    /*
	public function select()
	{
		$sql="SELECT idarticulo, articulonombre FROM articulo 
		WHERE (articulocondicion=1) ORDER BY articulonombre ASC";
		return ejecutarConsulta($sql);		
	}
    */
}

?>