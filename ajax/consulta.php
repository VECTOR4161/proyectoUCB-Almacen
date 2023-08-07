<?php 
session_start();

require_once "../model/Consultas.php";

$consulta=new Consultas();


switch ($_GET["op"]){
	case '0':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){
			$date = date_create($reg['fecha']);
			$date = date_format($date,"d/m/Y");	
 			$data[]=array(
 				"0"=>$date,
 				"1"=>$reg['proveedornombre']." ".$reg['proveedorap']." ".$reg['proveedoram'],
 				"2"=>$reg['usuarionombre']." ".$reg['usuarioap']." ".$reg['usuarioam'],
 				"3"=>$reg['ingresotipo_comprobante'],
 				"4"=>$reg['ingresoserie_comprobante'].' '.$reg['ingresonumero_comprobante'],
 				"5"=>$reg['ingresototal_compra'],
 				"6"=>$reg['ingresoimpuesto'],
 				"7"=>($reg['ingresocondicion']=='1')?'<span class="badge bg-primary">Aceptado</span>':
 				'<span class="badge bg-danger">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case '1':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$cliente=$_REQUEST["cliente"];

		$rspta=$consulta->ventasfechacliente($fecha_inicio,$fecha_fin,$cliente);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){
			$date = date_create($reg['fecha']);
			$date = date_format($date,"d/m/Y");	
 			$data[]=array(
 				"0"=>$date,
 				"1"=>$reg['clientenombre']." ".$reg['clienteap']." ".$reg['clienteam'],
 				"2"=>$reg['usuarionombre']." ".$reg['usuarioap']." ".$reg['usuarioam'],
 				"3"=>$reg['ventatipo_comprobante'],
 				"4"=>$reg['ventaserie_comprobante'].' '.$reg['ventanum_comprobante'],
 				"5"=>$reg['ventatotal_venta'],
 				"6"=>$reg['ventaimpuesto'],
 				"7"=>($reg['ventacondicion']=='1')?'<span class="badge bg-primary">Aceptado</span>':
 				'<span class="badge bg-danger">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>