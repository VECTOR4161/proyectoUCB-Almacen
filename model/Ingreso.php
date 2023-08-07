<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Ingreso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
	{
		$sql="INSERT INTO ingreso (idproveedor,idusuario,ingresotipo_comprobante,ingresoserie_comprobante,ingresonumero_comprobante,ingresofecha_hora,ingresoimpuesto,ingresototal_compra,ingresocondicion)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','1') RETURNING idingreso";
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo,detalle_ingresocantidad,detalle_ingresoprecio_compra,detalle_ingresoprecio_venta) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	//Implementamos un método para anular categorías
	public function anular($idingreso)
	{
		$sql="UPDATE ingreso SET ingresocondicion='0' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idingreso)
	{
		$sql="SELECT i.idingreso,DATE(i.ingresofecha_hora) as fecha, i.idproveedor,p.personanombre as proveedornombre, p.personaap as proveedorap, p.personaam as proveedoram,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ingresotipo_comprobante,i.ingresoserie_comprobante,i.ingresonumero_comprobante,i.ingresototal_compra,i.ingresoimpuesto,i.ingresocondicion FROM ingreso i, persona p, proveedor r, persona pr, usuario u WHERE i.idproveedor=r.idproveedor AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND i.idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT di.idingreso,di.idarticulo,a.articulonombre,di.detalle_ingresocantidad,di.detalle_ingresoprecio_compra,di.detalle_ingresoprecio_venta FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idingreso,DATE(i.ingresofecha_hora) as fecha, i.idproveedor,p.personanombre as proveedornombre, p.personaap as proveedorap, p.personaam as proveedoram,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ingresotipo_comprobante,i.ingresoserie_comprobante,i.ingresonumero_comprobante,i.ingresototal_compra,i.ingresoimpuesto,i.ingresocondicion FROM ingreso i, persona p, proveedor r, persona pr, usuario u WHERE i.idproveedor=r.idproveedor AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);		
	}
	
	public function ingresocabecera($idingreso){
		$sql="SELECT i.idingreso, i.idproveedor,p.personanombre as proveedornombre, p.personaap as proveedorap, p.personaam as proveedoram,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ingresotipo_comprobante,i.ingresoserie_comprobante,i.ingresonumero_comprobante,i.ingresototal_compra,i.ingresoimpuesto,i.ingresocondicion FROM ingreso i, persona p, proveedor r, persona pr, usuario u WHERE i.idproveedor=r.idproveedor AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND i.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}

	public function ingresodetalle($idingreso){
		$sql="SELECT a.articulonombre as articulo,a.articulocodigo,d.detalle_ingresocantidad,d.detalle_ingresoprecio_compra,d.detalle_ingresoprecio_venta,(d.detalle_ingresocantidad*d.detalle_ingresoprecio_compra) as subtotal FROM detalle_ingreso d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}
}

?>