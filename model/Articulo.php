<?php
require_once "../config/Conexion.php";

interface Prototype
{
    public function clonar();
}

Class Articulo implements Prototype
{

	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function clonar()
    {
        $clon = clone $this;
        return $clon;
    }


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idarticulo, a.articulonombre, c.categorianombre, a.articulostock, a.articuloimagen, a.articulocodigo, a.articulocondicion
        FROM articulo a, categoria c
        WHERE(a.idcategoria=c.idcategoria);";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $categoria, $stock, $descripcion, $imagen, $codigo)
	{
		$validacion=$this->comprueba_duplicados($codigo,0);
		if($validacion==0){
			$sql="INSERT INTO articulo(articulonombre, idcategoria, articulostock, articulodescripcion, articuloimagen, articulocodigo, articulocondicion)
            VALUES ('$nombre', '$categoria', '$stock', '$descripcion', '$imagen', '$codigo', '1');";
			return ejecutarConsulta($sql);
		}
		else{return 0;}
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$nombre, $categoria, $stock, $descripcion, $imagen, $codigo)
	{
		$validacion=$this->comprueba_duplicados($codigo,$idarticulo);
		if($validacion==0){
			$sql="UPDATE articulo SET articulonombre='$nombre', idcategoria='$categoria', articulostock='$stock', articulodescripcion='$descripcion', articuloimagen='$imagen', articulocodigo='$codigo' 
			WHERE idarticulo='$idarticulo'";
			return ejecutarConsulta($sql);
		}
		else{return 0;}
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET articulocondicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET articulocondicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT a.idarticulo, a.articulonombre, a.articulodescripcion, c.idcategoria, a.articulostock, a.articuloimagen, a.articulocodigo, a.articulocondicion
        FROM articulo a, categoria c
        WHERE(a.idcategoria=c.idcategoria) AND (idarticulo='$idarticulo')";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function select()
	{
		$sql="SELECT idarticulo, articulonombre FROM articulo 
		WHERE (articulocondicion=1) ORDER BY articulonombre ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function comprueba_duplicados($codigo,$id)
	{
		$resultado=0;
		$sql="SELECT COUNT(idarticulo) AS idarticulo FROM articulo WHERE (articulocodigo='$codigo') AND (idarticulo<>$id)";
		$resultado = ejecutarConsultaSimpleFila($sql);
		return $resultado['idarticulo'];			
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo, a.idcategoria, c.categorianombre as categoria, a.articulocodigo, a.articulonombre, a.articulostock, a.articulodescripcion, a.articuloimagen, a.articulocondicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.articulocondicion='1'";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.categorianombre as categoria,a.articulocodigo,a.articulonombre,a.articulostock,(SELECT detalle_ingresoprecio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 1) as precio_venta,a.articulodescripcion,a.articuloimagen,a.articulocondicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.articulocondicion='1'";
		return ejecutarConsulta($sql);		
	}

	

}

?>