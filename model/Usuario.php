<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM persona p, usuario r WHERE p.idpersona=r.idpersona";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email, $imagen, $usuariox, $clavehash, $rol)
	{
		$validacion=$this->comprueba_duplicados($num_documento,0);
		if($validacion==0){

            $sql="INSERT INTO persona (personanombre, personaap, personaam, personatipo_documento, personanum_documento, personadireccion, personaemail, personaimagen)
		    	VALUES ('$nombre','$apellidop','$apellidom','$tipo_documento','$num_documento', '$direccion', '$email', '$imagen') RETURNING idpersona;";
            $idpersona = ejecutarConsulta_retornarID($sql);
            $sqlx="INSERT INTO usuario(usuarionombre, usuarioclave, usuariointentos, usuariocondicion, idrol, idpersona)
            	VALUES ('$usuariox', '$clavehash', '0', '1', '$rol', '$idpersona') RETURNING idusuario";
			return ejecutarConsulta($sqlx);

		}
		else{return 0;}
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre, $apellidop, $apellidom, $tipo_documento,$num_documento,$direccion,$email, $imagen, $usuariox, $clavehash, $rol)
	{
		$validacion=$this->comprueba_duplicados($num_documento,$idusuario);
		if($validacion==0){
            
            $idpersona=$this->idpersona_usuario($idusuario);
            $sql="UPDATE persona SET personanombre='$nombre', personaap='$apellidop', personaam='$apellidom',personatipo_documento='$tipo_documento',personanum_documento='$num_documento',personadireccion='$direccion',personaemail='$email',personaimagen='$imagen' WHERE idpersona='$idpersona'";
			ejecutarConsulta($sql);

            $sqlx="UPDATE usuario SET usuarionombre='$usuariox', usuarioclave='$clavehash', idrol='$rol'
            WHERE idusuario = '$idusuario'";
			return ejecutarConsulta($sqlx);

        }
		else{return 0;}
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET usuariocondicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET usuariocondicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM persona p, usuario r WHERE p.idpersona=r.idpersona AND (r.idusuario='$idusuario')";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function select()
	{
		$sql="SELECT idusuario, usuarionombre FROM usuario 
		WHERE (usuariocondicion=1) ORDER BY usuarionombre ASC";
		return ejecutarConsulta($sql);		
	}

    //Implementar un método para mostrar los datos de un registro a modificar
	public function idpersona_usuario($idusuario)
	{
		$sql="SELECT p.idpersona FROM persona p, usuario c WHERE p.idpersona=c.idpersona AND c.idusuario='$idusuario'";
		$idpersona = ejecutarConsultaSimpleFila($sql);
		return $idpersona["idpersona"];
	}

	//Implementar un método para listar los registros
	public function comprueba_duplicados($nombre,$id)
	{
		$resultado=0;
		$sql="SELECT COUNT(p.idpersona) AS idpersona FROM persona p, usuario u WHERE (p.personanum_documento='$nombre')AND(u.idpersona=p.idpersona) AND (u.idusuario<>$id)";
		$resultado = ejecutarConsultaSimpleFila($sql);
		return $resultado['idpersona'];		
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT p.personaemail, p.personanombre, p.personaap, p.personanum_documento, p.personaimagen, u.idusuario, u.usuariocondicion, u.usuarionombre, u.usuarioclave, 
		r.idrol, r.rolnombre FROM persona p, usuario u, rol r WHERE p.idpersona=u.idpersona AND u.idrol=r.idrol AND 
		u.usuarionombre='$login' AND usuarioclave='$clave' AND u.usuariocondicion='1'"; 
    	return ejecutarConsulta($sql);  
    }

	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT p.idpermiso FROM usuario u, rol r, rol_permiso p WHERE u.idrol=r.idrol AND r.idrol=p.idrol AND u.idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar_intentos($idusuario,$intentos)
	{
		$sql="UPDATE usuario SET usuariointentos='$intentos' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}
	//Función para verificar el acceso al sistema
	public function verificar_intentos($login)
    {
		$sql="SELECT idusuario, usuariointentos FROM usuario WHERE usuarionombre='$login'";
		$resultado = ejecutarConsulta($sql); 
		while ($reg = pg_fetch_assoc($resultado)){
			$idusuario=$reg["idusuario"];
			$num_intentos=(int)$reg["usuariointentos"]+1;
			if($num_intentos>=5){
				$respuesta=$this->editar_intentos($idusuario,$num_intentos);
				$respuesta=$this->desactivar($idusuario);
			}
			else{$respuesta=$this->editar_intentos($idusuario,$num_intentos);}
		}
	}

	public function verificar_usuario($usuarioNombre)
	{
		$sql="SELECT count(idusuario) FROM usuario WHERE usuarionombre = '$usuarioNombre';";
		return ejecutarConsulta($sql);
	}
}

?>