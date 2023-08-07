<?php 
session_start();
require_once "../model/Usuario.php";
$usuario=new usuario();

require_once "seguridad.php";
$seguridad=new seguridad();

$idusuario=isset($_POST["idusuario"])? $_POST["idusuario"]:"";
$nombre=isset($_POST["nombre"])? mb_strtoupper($_POST["nombre"]):"";
$apellidop=isset($_POST["apellidop"])? mb_strtoupper($_POST["apellidop"]):"";
$apellidom=isset($_POST["apellidom"])? mb_strtoupper($_POST["apellidom"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? $_POST["tipo_documento"]:"";
$num_documento=isset($_POST["num_documento"])? mb_strtoupper($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? mb_strtoupper($_POST["direccion"]):"";
$email=isset($_POST["email"])? $_POST["email"]:"";
$imagen=isset($_POST["imagen"])? $_POST["imagen"]:"";
$rol=isset($_POST["rol"])? mb_strtoupper($_POST["rol"]):"";
$login=isset($_POST["login"])? $_POST["login"]:"";
$clave=isset($_POST["clave"])? $_POST["clave"]:"";

switch ($_GET["op"]){
	case '0':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg = pg_fetch_assoc($rspta)){

            if(empty($reg['personaimagen'])){
			    $imagen_perfil = "../file/imagen/noimagen.png";
			}
			else{
				$imagen_perfil = "../file/usuarios/".$reg['personaimagen'];
			}

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
				"0"=>($reg['usuariocondicion'])?'<button class="btn btn-warning" onclick="mostrar('.$reg['idusuario'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idusuario'].')"><i class="bx bx-printer"></i></button>'.
					'<button class="btn btn-danger" onclick="desactivar('.$reg['idusuario'].')"><i class="bx bx-trash"></i></button>':
					'<button class="btn btn-warning" onclick="mostrar('.$reg['idusuario'].')"><i class="bx bx-pencil"></i></button>'.
					'<button class="btn btn-info" onclick="reporte_detalle('.$reg['idusuario'].')"><i class="bx bx-printer"></i></button>'.
					'<button class="btn btn-primary" onclick="activar('.$reg['idusuario'].')"><i class="bx bx-check"></i></button>',
                "1"=>$reg['personanombre']." ".$reg['personaap']." ".$reg['personaam'],
                "2"=>$tipo_documento,
                "3"=>$reg['personanum_documento'],
                "4"=>$reg['personaemail'],
                "5"=>$reg['usuarionombre'],
                "6"=>'<a href="'.$imagen_perfil.'" class="image-popup">                
                <img src="'.$imagen_perfil.'" alt="" class="rounded avatar-lg"></a>',
				"7"=>($reg['usuariocondicion'])?'<span class="badge rounded-pill bg-success">Activado</span>':
                '<span class="badge rounded-pill bg-danger">Desactivado</span>'
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../file/usuarios/" . $imagen);
			}
		}
        //Hash SHA256 en la contraseña
		$clavehash=$seguridad->stringEncryption('encrypt', $clave);
		if (empty($idusuario)){
			$rspta=$usuario->insertar($nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen,$login,$clavehash,$rol);
			echo $rspta ? "1:El usuario fué registrado" : "0:El usuario no fué registrado";
		}
		else {
			$rspta=$usuario->editar($idusuario, $nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email,$imagen,$login,$clavehash,$rol);
			echo $rspta ? "1:El usuario fué actualizado" : "0:El usuario no fué actualizado";
		}
	break;

	case '2':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "1:El usuario fué Desactivado" : "0:El usuario no fué Desactivado";
	break;

	case '3':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "1:El usuario fué Activado" : "0:El usuario no fué Activado";
	break;

	case '4':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case '5':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];
	    //Hash SHA256 en la contraseña
		$clavehash=$seguridad->stringEncryption('encrypt', $clavea);

		$rspta=$usuario->verificar($logina, $clavehash);
		$contador=0;
		while ($fetch= pg_fetch_assoc($rspta)){
			$contador+=1;
			//Declaramos las variables de sesión
	        $_SESSION['idusuario']=$fetch['idusuario'];
	        $_SESSION['personanombre']=$fetch['personanombre']." ".$fetch['personaap']." ".$fetch['personaam'];
	        $_SESSION['personaimagen']=$fetch['personaimagen'];
			$_SESSION['personaemail']=$fetch['personaemail'];
	        $_SESSION['usuarionombre']=$fetch['usuarionombre'];
			$_SESSION['idrol']=$fetch['idrol'];
			$_SESSION['rolnombre']=$fetch['rolnombre'];
	        //Obtenemos los permisos del usuario
	    	$marcados = $usuario->listarmarcados($fetch['idusuario']);

	    	//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();

			//Almacenamos los permisos marcados en el array
			while ($per = pg_fetch_assoc($marcados))
				{
					array_push($valores, $per['idpermiso']);
				}

			//Determinamos los accesos del usuario
			in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
			in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
			in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
			in_array(6,$valores)?$_SESSION['consulta_compras']=1:$_SESSION['consulta_compras']=0;
			in_array(7,$valores)?$_SESSION['consulta_ventas']=1:$_SESSION['consulta_ventas']=0;
			$reseteo = $usuario->editar_intentos($fetch['idusuario'],0);

		}
		if ($contador>0)
	    {
	        
	    }
		else{
			$rspta=$usuario->verificar_intentos($logina);
		}
	    echo $contador;
	break;


    case "6":		
		$prueba=$seguridad->stringEncryption('decrypt', $clave);
		echo $prueba;
	break;

	case '7':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
	break;
	case '8':
		$rspta=$usuario->verificar_usuario($login);
        while ($reg = pg_fetch_assoc($rspta))
        {			
			$data[]=array
            (
				"0"=>$reg['count'],
			);
		}
        echo json_encode($data);
	break;
}
?>