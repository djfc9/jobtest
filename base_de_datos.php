<?php
//esta clave deberia estar seteada en una variable de entorno o algo similar para reducir los riesgos de seguridad
$contraseña = "123456";
$usuario = "dionny";
$nombre_base_de_datos = "jobtest";
try{
	$base_de_datos = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
}catch(Exception $e){
	echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
?>
