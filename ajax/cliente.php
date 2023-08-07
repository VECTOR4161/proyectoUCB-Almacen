<?php
session_start();
require_once "../model/Cliente.php";
$cliente=new cliente();

$idcliente=isset($_POST["idcliente"])? $_POST["idcliente"]:"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../file/clientes/" . $imagen);
			}
		}

		if (empty($idcliente)){
			$rspta=$cliente->insertar($nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen);
			echo $rspta ? "1:Cliente registrado" : "0:No se pudieron registrar todos los datos del cliente";
		}
		else {
			$rspta=$cliente->editar($idcliente,$nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen);
			echo $rspta ? "1:Cliente actualizado" : "0:cliente no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$cliente->desactivar($idcliente);
 		echo $rspta ? "1:Cliente Desactivado" : "0:cliente no se puede desactivar";
	break;

	case '3':
		$rspta=$cliente->activar($idcliente);
 		echo $rspta ? "1:Cliente activado" : "0:cliente no se puede activar";
	break;

	case '4':
		$rspta=$cliente->mostrar($idcliente);
 		echo json_encode($rspta);
	break;

	case '0':
		$rspta=$cliente->listar();
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
				"0"=>($reg['clientecondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idcliente'].')"><i class="bx bx-pencil"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg['idcliente'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idcliente'].')"><i class="bx bx-pencil"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg['idcliente'].')"><i class="bx bxs-check-square"></i></button>',
				"1"=>$reg['personanombre']." ".$reg['personaap']." ".$reg['personaam'],
				"2"=>$tipo_documento,
				"3"=>$reg['personanum_documento'],
				"4"=>$reg['personaemail'],
				"5"=>"<img src='../file/clientes/".$reg['personaimagen']."' height='50px' width='50px' >",
				"6"=>($reg['clientecondicion'])?'<span class="badge bg-primary">Activado</span>':
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
		$rspta = $cliente->select();
		while ($reg = pg_fetch_assoc($rspta))
		{
			echo '<option value=' . $reg['idcliente'] . '>' . $reg['personanombre']. " " . $reg['personaap']. " " . $reg['personaam'] . '</option>';
		}
		break;	
}
?>