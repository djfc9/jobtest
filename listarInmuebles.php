		<?php
		include_once "base_de_datos.php";


		# Por defecto hacemos la consulta de todos inmuebles activos en la base de datos
		$consulta = "SELECT id, nombre, tipoInmueble.tipo tipoInmueble, estrellas, ubicacion, habitaciones.estilo tipoHabitacion, apartamentos, capacidad, ciudad, provincia FROM inmuebles JOIN tipoInmueble ON tipoInmueble.id_tipo = inmuebles.id_tipo JOIN habitaciones ON habitaciones.id_habitacion = inmuebles.id_habitacion where estatus= true ORDER BY nombre";


		# Vemos si hay búsqueda
		$busqueda = null;
		if (isset($_GET["busqueda"])) {
		    # Y si hay, búsqueda, entonces cambiamos la consulta
		    # Nota: no concateno para prevenir inyecciones SQL
		    $busqueda = $_GET["busqueda"];
		    $consulta = "SELECT id, nombre, tipoInmueble.tipo tipoInmueble, estrellas, ubicacion, habitaciones.estilo tipoHabitacion, apartamentos, capacidad, ciudad, provincia FROM inmuebles JOIN tipoInmueble ON tipoInmueble.id_tipo = inmuebles.id_tipo JOIN habitaciones ON habitaciones.id_habitacion = inmuebles.id_habitacion WHERE nombre LIKE ? AND estatus = true ORDER BY nombre";
		}


		# Preparar sentencia e indicar que vamos a usar un cursor
		$sentencia = $base_de_datos->prepare($consulta, [
		    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
		]);



		# Aquí comprobamos otra vez si hubo búsqueda, ya que tenemos que pasarle argumentos al ejecutar
		# Si no hubo búsqueda, entonces traer a todos los inmuebles
		if ($busqueda === null) {
		    # Ejecutar sin parámetros
		    $sentencia->execute();
		} else {
		    # Ah, pero en caso de que sí, le pasamos la búsqueda
		    # Un arreglo que nomás llevará la búsqueda con % al inicio y al final
		    $parametros = ["%$busqueda%"];
		    $sentencia->execute($parametros);
		}



		# Sin importar si hubo búsqueda o no, se nos habrá devuelto un cursor que iteramos más abajo...
		?>
		<!--Recordemos que podemos intercambiar HTML y PHP como queramos-->
		<!DOCTYPE html>
		<html lang="es">
		<head>
			<meta charset="UTF-8">
			<title>Inmuebles</title>

			<link href="img/favicon.ico" rel="icon" type="image/x-icon" />


			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
			
			<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

			<script src="js/funciones.js"></script>

		</head>
		<body style="margin-top: 30px;">


			<div class="container">
				
		    <!--
		        Un formulario que únicamente permite buscar. Se envía
		        a este mismo script y se hace con GET
		    -->
		    <form id="formulario" action="listarInmuebles.php" method="GET">

		    	<div class="row">
		    		<div class="col-md-4"></div>
		    		<div class="col-md-4">
		    			<div class="input-group mb-3">
		    				<input class="form-control" id="buscar" type="text" placeholder="Buscar por nombre de Inmueble" name="busqueda" aria-label="Buscar por nombre de Inmueble" aria-describedby="basic-addon2" autofocus>
		    				<div class="input-group-append">
		    					<button class="btn btn-outline-secondary" type="submit">Buscar</button>
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-4">
		    		</div>
		    	</div>
		    	<h3 class="float-end badge bg-primary text-wrap">Lista de inmuebles</h3>

		    </form>
		    <table class="table table-striped">
		    	<thead>
		    		<tr>
		    			<th>ID</th>
		    			<th>Nombre</th>
		    			<th>TipoInmueble</th>
		    			<th>Estrellas</th>
		    			<th>Ubicaci&oacute;n</th>
		    			<th>TipoHabitaci&oacute;n</th>
		    			<th>Apartamentos</th>
		    			<th>Capacidad</th>
		    			<th>Editar</th>
		    			<th>Eliminar</th>
		    		</tr>
		    	</thead>
		    	<tbody>
					<!--
						Y aquí usamos el ciclo while y fecthObject, el cuerpo
		                del ciclo queda intacto pero ahora estamos usando
		                cursores :)
		            -->


		            <?php while ($inmueble = $sentencia->fetchObject()) {  ?>

		            	<tr>
		            		<td><?php echo $inmueble->id ?></td>
		            		<td><?php echo $inmueble->nombre ?></td>
		            		<td><?php echo $inmueble->tipoInmueble ?></td>
		            		<td><?php echo $inmueble->estrellas ?></td>
		            		<!--<td><?php //echo $inmueble->ubicacion ?></td>-->
		            		<td><?php echo $inmueble->ciudad.', '.$inmueble->provincia ?></td>
		            		<td><?php echo $inmueble->tipoHabitacion ?></td>
		            		<td><?php if($inmueble->apartamentos){echo $inmueble->apartamentos;}else{echo 'N/A';} ?></td>
		            		<td><?php if($inmueble->capacidad){echo $inmueble->capacidad;}else{echo 'N/A';} ?></td>
		            		<td><a type="button"  class="btn btn-info btn-sm alertas">Editar</a></td>
		            		<td><a type="button"  class="btn btn-danger btn-sm alertas" >Eliminar</a></td>
		            	</tr>
		            <?php }?>
		        </tbody>
		    </table>
			</div>

			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
		</body>
		</html>