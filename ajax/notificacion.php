<?php 
require_once "../model/Notificacion.php";


$notificacion = new Notificacion();

//$idnotificacion=isset($_POST["idnotificacion"])? $_POST["idnotificacion"]:"";
$titulo=isset($_POST["titulo"])? mb_strtoupper($_POST["titulo"]):"";
$contenido=isset($_POST["contenido"])? $_POST["contenido"]:"";



switch ($_GET["op"])
{
    case 0:
        $rspta=$notificacion->listar_notificacion();
        
        while ($reg = pg_fetch_assoc($rspta))
        {			
			$data[]=array
            (
				"0"=>$reg['titulo'],
                "1"=>$reg['contenido']
			);
		}

        echo json_encode($data);          
        break;
    case 1:
        $rspta=$notificacion->insertar($titulo, $contenido);
	    echo $rspta;
        break;
}





/*
function listar_notificaciones()
{
    
}

function guardar()
{
    $rspta=$articulo->insertar($nombre, $categoria, $stock, $descripcion, $imagen, $codigo);
	echo $rspta ? "1:El Artículo fué registrado" : "0:El Artículo no fué registrado";
}
*/


?>