<?php 
require_once "../model/Categoria.php";

$categoria=new Categoria();

$idcategoria=isset($_POST["idcategoria"])? $_POST["idcategoria"]:"";
$nombre=isset($_POST["nombre"])? mb_strtoupper($_POST["nombre"]):"";

switch ($_GET["op"]){
	case '0':
		$rspta=$categoria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){			
			$data[]=array(
				"0"=>($reg['categoriacondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idcategoria'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idcategoria'].')"><i class="fa fa-print"></i></button>'.
					'<button class="btn btn-danger" onclick="desactivar('.$reg['idcategoria'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idcategoria'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idcategoria'].')"><i class="fa fa-print"></i></button>'.
					'<button class="btn btn-primary" onclick="activar('.$reg['idcategoria'].')"><i class="bx bxs-check-square"></i></button>',
				"1"=>$reg['categorianombre'],
				"2"=>($reg['categoriacondicion'])?'<span class="badge bg-primary">Activado</span>':
					'<span class="badge bg-danger">Desactivado</span>'
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
		if (empty($idcategoria)){
			$rspta=$categoria->insertar($nombre);
			echo $rspta ? "1:La acción para la Hoja de Ruta fué registrada" : "0:a acción para la Hoja de Ruta no fué registrada";
		}
		else {
			$rspta=$categoria->editar($idcategoria,$nombre);
			echo $rspta ? "1:a acción para la Hoja de Ruta fué actualizada" : "0:a acción para la Hoja de Ruta no fué actualizada";
		}
	break;

	case '2':
		$rspta=$categoria->desactivar($idcategoria);
 		echo $rspta ? "1:a acción para la Hoja de Ruta fué Desactivada" : "0:a acción para la Hoja de Ruta no fué Desactivada";
	break;

	case '3':
		$rspta=$categoria->activar($idcategoria);
 		echo $rspta ? "1:a acción para la Hoja de Ruta fué Activada" : "0:a acción para la Hoja de Ruta no fué Activada";
	break;

	case '4':
		$rspta=$categoria->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case '5':
		$rspta = $categoria->select();
		while ($reg = pg_fetch_assoc($rspta))
		{
			echo '<option value=' . $reg['idcategoria'] . '>' . $reg['categorianombre'] . '</option>';
		}
	break;
}
?>