<?php 
session_start();

require_once "../model/Venta.php";
$venta=new Venta();

$idventa=isset($_POST["idventa"])? $_POST["idventa"]:"";
$cliente=isset($_POST["cliente"])? $_POST["cliente"]:"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? $_POST["tipo_comprobante"]:"";
$serie_comprobante=isset($_POST["serie_comprobante"])? $_POST["serie_comprobante"]:"";
$num_comprobante=isset($_POST["num_comprobante"])? $_POST["num_comprobante"]:"";
$fecha_hora=isset($_POST["fecha_hora"])? $_POST["fecha_hora"]:"";
$impuesto=isset($_POST["impuesto"])? $_POST["impuesto"]:"";
$total_venta=isset($_POST["total_venta"])? $_POST["total_venta"]:"";

switch ($_GET["op"]){
	case '0':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){	
            $date = date_create($reg['fecha']);
			$date = date_format($date,"d/m/Y");	
			$data[]=array(
				"0"=>($reg['ventacondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idventa'].')"><i class="bx bx-search"></i></button>'.
					'<button class="btn btn-danger" onclick="anular('.$reg['idventa'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idventa'].')"><i class="bx bx-search"></i></button>',
                "1"=>$date,
                "2"=>$reg['clientenombre']." ".$reg['clienteap']." ".$reg['clienteam'],
                "3"=>$reg['usuarionombre']." ".$reg['usuarioap']." ".$reg['usuarioam'],
                "4"=>$reg['ventatipo_comprobante'],
                "5"=>$reg['ventaserie_comprobante'].'-'.$reg['ventanum_comprobante'],
                "6"=>$reg['ventatotal_venta'],
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
	case '1':
		if (empty($idventa)){
			$rspta=$venta->insertar($cliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["precio_venta"]);
			echo $rspta ? "1:Venta registrada" : "0:No se pudieron registrar todos los datos del venta";
		}
	break;

	case '2':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "1:Venta anulada" : "0:La Venta no se puede anular";
	break;

	case '3':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case '4':
		//Recibimos el idventa
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

        while ($reg = pg_fetch_assoc($rspta)){	
            echo '<tr class="filas"><td></td><td>'.$reg['articulonombre'].'</td><td>'.$reg['detalle_ventacantidad'].'</td><td>'.$reg['detalle_ventaprecio_venta'].'</td><td>'.$reg['detalle_ventaprecio_venta'].'</td><td>'.$reg['detalle_ventaprecio_venta']*$reg['detalle_ventacantidad'].'</td></tr>';
            $total=$total+($reg['detalle_ventaprecio_venta']*$reg['detalle_ventacantidad']);
		}
		echo '<tfoot>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th><h4 id="total">Bs/.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
            </tfoot>';
	break;
}
?>