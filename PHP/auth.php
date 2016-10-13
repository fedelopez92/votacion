<?php
include "clases/Usuarios.php";
include_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

// $key = "example_key";
// $token = array(
//     "iss" => "http://example.org",
//     "aud" => "http://example.com",
//     "iat" => 1356999524,
//     "nbf" => 1357000000
// );

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */



$DatosDelModeloPorPost=file_get_contents('php://input');
//echo json_encode($DatosDelModeloPorPost);
$user=json_decode($DatosDelModeloPorPost);
//echo json_encode($user);
$usuarioBuscado=Usuario::TraerUnUsuario($user->nombreuser);
//echo json_encode($usuarioBuscado);
if($usuarioBuscado->password == $user->password)
//if($user->email == 'usuario@dominio.com' && $user->password=='claveadmin')
{
	$key="1234";
	$token["iat"]=time();
	$token["exp"]= time()+1800; //el token caduca en media hora

	$token["username"]="usuario";
	$token["tipoUsuario"]="admin";
	//$token es un array
	$jwt = JWT::encode($token, $key);

	$arrayConToken["MiTokenGeneradoEnPHP"]=$jwt;
}
else
{
	$arrayConToken["MiTokenGeneradoEnPHP"] = false;
}
echo json_encode($arrayConToken);



/*$claveDeEncriptacion='estaEsLaClave';
$token['usuario']="unUsuario";
$token['perfil']="admin";
$token['iat']=time();
$token['exp']=time()+20;

$jwt = JWT::encode($token, $claveDeEncriptacion);
$arrayConToken["ElNombreDelToken"]=$jwt;
echo json_encode($arrayConToken);
$array["MiTokenGeneradoEnPHP"]=$jwt;*/

?>