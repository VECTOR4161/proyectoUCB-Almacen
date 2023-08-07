<?php 
session_start();

require_once "../model/Ingreso.php";
$ingreso=new Ingreso();

$idingreso=isset($_POST["idingreso"])? $_POST["idingreso"]:"";
$proveedor=isset($_POST["proveedor"])? $_POST["proveedor"]:"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? $_POST["tipo_comprobante"]:"";
$serie_comprobante=isset($_POST["serie_comprobante"])? $_POST["serie_comprobante"]:"";
$num_comprobante=isset($_POST["num_comprobante"])? $_POST["num_comprobante"]:"";
$fecha_hora=isset($_POST["fecha_hora"])? $_POST["fecha_hora"]:"";
$impuesto=isset($_POST["impuesto"])? $_POST["impuesto"]:"";
$total_compra=isset($_POST["total_compra"])? $_POST["total_compra"]:"";

switch ($_GET["op"]){
	case '0':
		$rspta=$ingreso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){	
            $date = date_create($reg['fecha']);
			$date = date_format($date,"d/m/Y");	
			$data[]=array(
				"0"=>($reg['ingresocondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idingreso'].')"><i class="bx bx-search"></i></button>'.
					'<button class="btn btn-danger" onclick="anular('.$reg['idingreso'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idingreso'].')"><i class="bx bx-search"></i></button>',
                "1"=>$date,
                "2"=>$reg['proveedornombre']." ".$reg['proveedorap']." ".$reg['proveedoram'],
                "3"=>$reg['usuarionombre']." ".$reg['usuarioap']." ".$reg['usuarioam'],
                "4"=>$reg['ingresotipo_comprobante'],
                "5"=>$reg['ingresoserie_comprobante'].'-'.$reg['ingresonumero_comprobante'],
                "6"=>$reg['ingresototal_compra'],
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
		if (empty($idingreso)){
			$rspta=$ingreso->insertar($proveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
			echo $rspta ? "1:Ingreso registrado" : "0:No se pudieron registrar todos los datos del ingreso";
		}
	break;

	case '2':
		$rspta=$ingreso->anular($idingreso);
 		echo $rspta ? "1:Ingreso anulado" : "0:Ingreso no se puede anular";
	break;

	case '3':
		$rspta=$ingreso->mostrar($idingreso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case '4':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ingreso->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';

        while ($reg = pg_fetch_assoc($rspta)){	
					echo '<tr class="filas"><td></td><td>'.$reg['articulonombre'].'</td><td>'.$reg['detalle_ingresocantidad'].'</td><td>'.$reg['detalle_ingresoprecio_compra'].'</td><td>'.$reg['detalle_ingresoprecio_venta'].'</td><td>'.$reg['detalle_ingresoprecio_compra']*$reg['detalle_ingresocantidad'].'</td></tr>';
					$total=$total+($reg['detalle_ingresoprecio_compra']*$reg['detalle_ingresocantidad']);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Bs/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;
}
?>