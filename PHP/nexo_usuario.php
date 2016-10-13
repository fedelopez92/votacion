<?php
	include "clases/Usuarios.php";
	if(isset($_GET['accion']))
		{
			
		}
	else
		{ 
			$DatosPorPost = file_get_contents("php://input");
			$respuesta = json_decode($DatosPorPost);
	//var_dump($respuesta);
			switch($respuesta->datos->accion)
				{
					case "insertar";
					 {
					 	switch ($respuesta->datos->usuario->estado) {
					 		case 'opcion1':
					 			$respuesta->datos->usuario->estado = 'Soltero/a';
					 			break;
					 		case 'opcion2':
					 			$respuesta->datos->usuario->estado = 'Casado/a';
					 			break;
					 		case 'opcion3':
					 			$respuesta->datos->usuario->estado = 'Viudo/a';
					 			break;	
					 		default:
					 			# code...
					 			break;
					 	}
					 	Usuario::InsertarUsuario($respuesta->datos->usuario);
					 	break;
					 }
				}
		} 

?>
