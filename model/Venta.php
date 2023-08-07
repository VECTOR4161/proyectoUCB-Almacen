<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
	{
		$sql="INSERT INTO venta (idcliente,idusuario,ventatipo_comprobante,ventaserie_comprobante,ventanum_comprobante,ventafecha_hora,ventaimpuesto,ventatotal_venta,ventacondicion)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','1') RETURNING idventa";
		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,detalle_ventacantidad,detalle_ventaprecio_venta,detalle_ventadescuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	//Implementamos un método para anular categorías
	public function anular($idventa)
	{
		$sql="UPDATE venta SET ventacondicion='0' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT i.idventa,DATE(i.ventafecha_hora) as fecha, i.idcliente,p.personanombre as clientenombre, p.personaap as clienteap, p.personaam as clienteam,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ventatipo_comprobante,i.ventaserie_comprobante,i.ventanum_comprobante,i.ventatotal_venta,i.ventaimpuesto,i.ventacondicion FROM venta i, persona p, cliente r, persona pr, usuario u WHERE i.idcliente=r.idcliente AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND i.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT di.idventa,di.idarticulo,a.articulonombre,di.detalle_ventacantidad,di.detalle_ventaprecio_venta,di.detalle_ventaprecio_venta, di.detalle_ventadescuento FROM detalle_venta di inner join articulo a on di.idarticulo=a.idarticulo where di.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idventa,DATE(i.ventafecha_hora) as fecha, i.idcliente,p.personanombre as clientenombre, p.personaap as clienteap, p.personaam as clienteam,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ventatipo_comprobante,i.ventaserie_comprobante,i.ventanum_comprobante,i.ventatotal_venta,i.ventaimpuesto,i.ventacondicion FROM venta i, persona p, cliente r, persona pr, usuario u WHERE i.idcliente=r.idcliente AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona ORDER BY i.idventa desc";
		return ejecutarConsulta($sql);		
	}
	
	public function ventacabecera($idventa){
		$sql="SELECT i.idventa, i.idcliente,p.personanombre as clientenombre, p.personaap as clienteap, p.personaam as clienteam,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ventatipo_comprobante,i.ventaserie_comprobante,i.ventanum_comprobante,i.ventatotal_venta,i.ventaimpuesto,i.ventacondicion FROM venta i, persona p, cliente r, persona pr, usuario u WHERE i.idcliente=r.idcliente AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND i.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.articulonombre as articulo,a.articulocodigo,d.detalle_ventacantidad,d.detalle_ventaprecio_venta,d.detalle_ventaprecio_venta,(d.detalle_ventacantidad*d.detalle_ventaprecio_venta) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
}

?>