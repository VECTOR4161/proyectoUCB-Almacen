<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT i.idingreso,DATE(i.ingresofecha_hora) as fecha, i.idproveedor,p.personanombre as proveedornombre, p.personaap as proveedorap, p.personaam as proveedoram,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ingresotipo_comprobante,i.ingresoserie_comprobante,i.ingresonumero_comprobante,i.ingresototal_compra,i.ingresoimpuesto,i.ingresocondicion FROM ingreso i, persona p, proveedor r, persona pr, usuario u WHERE i.idproveedor=r.idproveedor AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND DATE(i.ingresofecha_hora)>='$fecha_inicio' AND DATE(i.ingresofecha_hora)<='$fecha_fin'";
		return ejecutarConsulta($sql);		
	}

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		$sql="SELECT i.idventa,DATE(i.ventafecha_hora) as fecha, i.idcliente,p.personanombre as clientenombre, p.personaap as clienteap, p.personaam as clienteam,u.idusuario,pr.personanombre as usuarionombre, pr.personaap as usuarioap, pr.personaam as usuarioam,i.ventatipo_comprobante,i.ventaserie_comprobante,i.ventanum_comprobante,i.ventatotal_venta,i.ventaimpuesto,i.ventacondicion FROM venta i, persona p, cliente r, persona pr, usuario u WHERE i.idcliente=r.idcliente AND r.idpersona=p.idpersona AND u.idusuario=i.idusuario AND u.idpersona=pr.idpersona AND DATE(i.ventafecha_hora)>='$fecha_inicio' AND DATE(i.ventafecha_hora)<='$fecha_fin' AND i.idcliente='$idcliente'";
		return ejecutarConsulta($sql);		
	}

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(ingresototal_compra),0) as total_compra FROM ingreso WHERE DATE(ingresofecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(ventatotal_venta),0) as total_venta FROM venta WHERE DATE(ventafecha_hora)=curdate()";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(ingresofecha_hora),'-',MONTH(ingresofecha_hora)) as fecha,SUM(ingresototal_compra) as total FROM ingreso GROUP by ingresofecha_hora ORDER BY ingresofecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(ventafecha_hora,'%M') as fecha, SUM(ventatotal_venta) as total FROM venta GROUP by MONTH(ventafecha_hora) ORDER BY ventafecha_hora DESC limit 0,10";
		return ejecutarConsulta($sql);
	}
}

?>