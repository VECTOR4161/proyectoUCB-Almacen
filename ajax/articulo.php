<?php 
require_once "../model/Articulo.php";



$articulo=new Articulo();

// Clonacion de la instancia
$articulo2 = $articulo->clonar();
$articulo3 = $articulo->clonar();


$idarticulo=isset($_POST["idarticulo"])? $_POST["idarticulo"]:"";
$nombre=isset($_POST["nombre"])? mb_strtoupper($_POST["nombre"]):"";
$categoria=isset($_POST["categoria"])? $_POST["categoria"]:"";
$stock=isset($_POST["stock"])? $_POST["stock"]:"";
$descripcion=isset($_POST["descripcion"])? mb_strtoupper($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? $_POST["imagen"]:"";
$codigo=isset($_POST["codigo"])? $_POST["codigo"]:"";

switch ($_GET["op"]){
	case '0':
		$rspta=$articulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){			
			$data[]=array(
				"0"=>($reg['articulocondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idarticulo'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idarticulo'].')"><i class="fa fa-print"></i></button>'.
					'<button class="btn btn-danger" onclick="desactivar('.$reg['idarticulo'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idarticulo'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idarticulo'].')"><i class="fa fa-print"></i></button>'.
					'<button class="btn btn-primary" onclick="activar('.$reg['idarticulo'].')"><i class="bx bxs-check-square"></i></button>',
				"1"=>$reg['articulonombre'],
                "2"=>$reg['categorianombre'],
                "3"=>$reg['articulocodigo'],
                "4"=>$reg['articulostock'],
                "5"=>'<img src="../file/articulos/'.$reg['articuloimagen'].'" alt="" class="rounded avatar-lg">',
				"6"=>($reg['articulocondicion'])?'<span class="badge bg-primary">Activado</span>':
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
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../file/articulos/" . $imagen);
			}
		}
		if (empty($idarticulo)){
			$rspta=$articulo->insertar($nombre, $categoria, $stock, $descripcion, $imagen, $codigo);
			echo $rspta ? "1:El Artículo fué registrado" : "0:El Artículo no fué registrado";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$nombre, $categoria, $stock, $descripcion, $imagen, $codigo);
			echo $rspta ? "1:El Artículo fué actualizado" : "0:El Artículo no fué actualizado";
		}
	break;

	case '2':
		$rspta=$articulo->desactivar($idarticulo);
 		echo $rspta ? "1:El Artículo fué Desactivado" : "0:El Artículo no fué Desactivado";
	break;

	case '3':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "1:El Artículo fué Activado" : "0:El Artículo no fué Activado";
	break;

	case '4':
		$rspta=$articulo->mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case '5':
		$rspta = $articulo->select();
		while ($reg = pg_fetch_assoc($rspta))
		{
			echo '<option value=' . $reg['idarticulo'] . '>' . $reg['articulonombre'] . '</option>';
		}
	break;
	case '6':
		$rspta=$articulo->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta))
		{
 			$data[]=array(
				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg['idarticulo'].',\''.$reg['articulonombre'].'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg['articulonombre'],
 				"2"=>$reg['categoria'],
 				"3"=>$reg['articulocodigo'],
 				"4"=>$reg['articulostock'],
 				"5"=>"<img src='../file/articulos/".$reg['articuloimagen']."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case '7':
		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta))
		{
 			$data[]=array(
				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg['idarticulo'].',\''.$reg['articulonombre'].'\',\''.$reg['precio_venta'].'\',\''.$reg['articulostock'].'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg['articulonombre'],
 				"2"=>$reg['categoria'],
 				"3"=>$reg['articulocodigo'],
 				"4"=>$reg['articulostock'],
				"5"=>$reg['precio_venta'],
 				"6"=>"<img src='../file/articulos/".$reg['articuloimagen']."' height='50px' width='50px' >"
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