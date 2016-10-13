<?php
require_once"accesoDatos.php";
class Usuario
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $nombreuser;
  	public $dni;
  	public $password;
  	public $tipo;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	
	public function Getnombreuser()
	{
		return $this->nombreuser;
	}
	
	public function GetDni()
	{
		return $this->dni;
	}
	
	
	public function GetPassword()
	{
		return $this->password;
	}

	public function GetTipo()
	{
		return $this->tipo;
	}
	
	
	public function SetId($valor)
	{
		$this->id = $valor;
	}
	
	public function Setnombreuser($valor)
	{
		$this->nombreuser = $valor;
	}
	
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	
	public function SetPassword($valor)
	{
		$this->password = $valor;
	}

	public function Settipo($valor)
	{
		$this->tipo = $valor;
	}
	
	
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($id=NULL)
	{
		if($id != NULL){
			$obj = nombreuser::TraerUnUsuario($id);
			
			$this->nombreuser = $obj->nombreuser;
			$this->dni = $dni;
			$this->id = $obj->id;
			$this->password = $obj->password;
			$this->tipo = $obj->tipo;

		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->apellido."-".$this->nombreuser."-".$this->dni."-".$this->sexo."-".$this->estado_civil
	  	."-".$this->fecha_nac."-".$this->correo."-".$this->password."-".$this->lenguaje_prog;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	
	public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasUsuarios() ");
		$consulta->execute();			
		$arrUsuarios= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrUsuarios;
	}

	public static function TraerUnUsuario($nombreUsuario) 
	{	

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where nombreuser =:nombreuser");
		$consulta->bindValue(':nombreuser', $nombreUsuario, PDO::PARAM_STR);
		$consulta->execute();
		$nombreuserBuscado= $consulta->fetchObject('usuario');
		return $nombreuserBuscado;	
					
	}

//--------------------------------------------------------------------------------//

	public static function InsertarUsuario($usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombreuser,dni,password,tipo)
															values(:nombreuser,:dni,:password,:tipo)");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL InsertarPersona (:nombreuser,:apellido,:dni,:foto)");
		$consulta->bindValue(':nombreuser',$usuario->nombreuser, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $usuario->dni, PDO::PARAM_INT);
		$consulta->bindValue(':password', $usuario->password, PDO::PARAM_STR);
		$consulta->bindValue(':tipo', $usuario->tipo, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}

	public static function BorrarUsuario($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from usuarios WHERE id=:id");	
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL Borrarnombreuser(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}

	public static function ModificarUsuario($usuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuarios 
				set nombreuser=:nombreuser,
				dni=:dni,
				password=:password,
				tipo=:tipo
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			//$consulta =$objetoAccesoDato->RetornarConsulta("CALL Modificarnombreuser(:id,:dni,:fechavotacion,:foto)");
			$consulta->bindValue(':id',$usuario->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombreuser',$usuario->dni, PDO::PARAM_STR);
			$consulta->bindValue(':dni', $usuario->fechavotacion, PDO::PARAM_INT);
			$consulta->bindValue(':password', $usuario->foto, PDO::PARAM_STR);
			$consulta->bindValue(':tipo', $usuario->foto, PDO::PARAM_STR);
			return $consulta->execute();
	}


//--------------------------------------------------------------------------------//


}
