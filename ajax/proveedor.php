<?php
session_start();
require_once "../model/Proveedor.php";
$proveedor=new proveedor();

$idproveedor=isset($_POST["idproveedor"])? $_POST["idproveedor"]:"";
$nombre=isset($_POST["nombre"])? mb_strtoupper($_POST["nombre"]):"";
$apellidop=isset($_POST["apellidop"])? mb_strtoupper($_POST["apellidop"]):"";
$apellidom=isset($_POST["apellidom"])? mb_strtoupper($_POST["apellidom"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? $_POST["tipo_documento"]:"";
$num_documento=isset($_POST["num_documento"])? mb_strtoupper($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? mb_strtoupper($_POST["direccion"]):"";
$email=isset($_POST["email"])? $_POST["email"]:"";
$imagen=isset($_POST["imagen"])? $_POST["imagen"]:"";

switch ($_GET["op"]){
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../file/proveedores/" . $imagen);
			}
		}

		if (empty($idproveedor)){
			$rspta=$proveedor->insertar($nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen);
			echo $rspta ? "1:Proveedor registrado" : "0:No se pudieron registrar todos los datos del proveedor";
		}
		else {
			$rspta=$proveedor->editar($idproveedor,$nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen);
			echo $rspta ? "1:Proveedor actualizado" : "0:proveedor no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$proveedor->desactivar($idproveedor);
 		echo $rspta ? "1:Proveedor Desactivado" : "0:proveedor no se puede desactivar";
	break;

	case '3':
		$rspta=$proveedor->activar($idproveedor);
 		echo $rspta ? "1:Proveedor activado" : "0:proveedor no se puede activar";
	break;

	case '4':
		$rspta=$proveedor->mostrar($idproveedor);
 		echo json_encode($rspta);
	break;

	case '0':
		$rspta=$proveedor->listar();
		//Vamos a declarar un array
		$data= Array();

		while ($reg = pg_fetch_assoc($rspta)){			
			$tipo_documento="";
			switch ($reg['personatipo_documento']){
				case '1':
					$tipo_documento="DNI";
					break;
				case '2':
					$tipo_documento="PASAPORTE";
					break;
				case '3':
					$tipo_documento="CEDULA DE IDENTIDAD";
					break;
			}
			$data[]=array(
				"0"=>($reg['proveedorcondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idproveedor'].')"><i class="bx bx-pencil"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg['idproveedor'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idproveedor'].')"><i class="bx bx-pencil"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg['idproveedor'].')"><i class="bx bxs-check-square"></i></button>',
				"1"=>$reg['personanombre']." ".$reg['personaap']." ".$reg['personaam'],
				"2"=>$tipo_documento,
				"3"=>$reg['personanum_documento'],
				"4"=>$reg['personaemail'],
				"5"=>"<img src='../file/proveedores/".$reg['personaimagen']."' height='50px' width='50px' >",
				"6"=>($reg['proveedorcondicion'])?'<span class="badge bg-primary">Activado</span>':
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
	case '5':
		$rspta = $proveedor->select();
		while ($reg = pg_fetch_assoc($rspta))
		{
			echo '<option value=' . $reg['idproveedor'] . '>' . $reg['personanombre']. " " . $reg['personaap']. " " . $reg['personaam'] . '</option>';
		}
		break;	
}
?>