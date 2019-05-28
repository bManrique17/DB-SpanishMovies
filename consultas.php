<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<h1>Consultas</h1>
	</head>
	<body>
	<?php
		if(isset($_POST['boton'])){
			apcu_store('flag', $_POST['boton']);
		}
		$flag = (int)apcu_fetch('flag');		
		
		$db_host="localhost";
		$db_nombre="proyeccion_pelicula";	
		$db_usuario="root";
		$db_contra="";
		
		switch($flag){
			case 1:
				echo "<p>Obtener todas las peliculas en las que el director ha trabajado tambien como actor.</p>";
				break;
			case 2:
				echo "<p>Obtener todos los premios obtenidos por peliculas dirigidas por Isaac Hayes en los oscars.</p>";
				break;
			case 3:
				echo "<p>Obtener los actores que han obtenido ´Oscars´ y cuantos cada uno.</p>";
				break;
			case 4:
				echo "<p>Existe una pelicula en la base de datos con un presupuesto superior al de ´Viaje al centro de la tierra´ y producida en 1995, cual es.</p>";
				break;
			case 5:
				echo "<p>Obtener el nombre y numero de salas que tiene cada cine de Madrid.</p>";
				break;
			case 6:
				echo "<p>Obtener una relacion de los premios que han quedado desiertos en los ´oscars´ de 1997 ¿Qué premio (s)?</p>";
				break;			
			case 7:
				echo "<p>Obtener el titulo y la nacionalidad de aquellas peliculas que han sido proyectadas en dos salas diferentes dentro de un mismo cine.</p>";
				break;
			case 8:
				echo "<p>Obtener el titulo y los actores principales de aquellas peliculas en las cuales han intervenido un mayor numero de actores principales.</p>";
				break;
			case 9:
				echo "<p>Obtener el actor que ha realizado mas peliculas como actor principal.</p>";
				break;
			case 10:
				echo "<p>Obtener el nombre y nacionalidad del ´director´ que ha actuado mas veces como actor, ya sea principal o de otro tipo.</p>";
				break;
		}
		
		echo
		"<br><table class=table>
		  <thead>
			<tr>
			  <th scope=col>#</th>";
		switch($flag){
			case 1:
				echo"<th scope=col>Pelicula</th>
					  <th scope=col>Fecha</th>
					  <th scope=col>Persona</th>";					  
				break;
			case 2:
				echo"<th scope=col>Pelicula</th>
					  <th scope=col>Festival</th>
					  <th scope=col>Año</th>
					  <th scope=col>Premio</th>";					  
				break;
			case 3:
				echo"<th scope=col>Persona</th>
					  <th scope=col>Cantidad</th>";
				break;
			case 4:
				echo"<th scope=col>Pelicula</th>
					  <th scope=col>Fecha de produccion</th>";
				break;
			case 5:
				echo"<th scope=col>Cine</th>
					  <th scope=col>Cantidad de Salas</th>";
				break;
			case 6:
				echo"<th scope=col>Festival</th>
					  <th scope=col>Certamen</th>
					  <th scope=col>Premio</th>";
				break;			
			case 7:
				echo"<th scope=col>Pelicla</th>
					  <th scope=col>Nacionalidad</th>";
				break;
			case 8:
				echo"<th scope=col>Pelicula</th>					  
					  <th scope=col>Persona</th>";
				break;
			case 9:
				echo"<th scope=col>Pelicula</th>
					  <th scope=col>Persona</th>";
				break;
			case 10:
				echo"<th scope=col>Persona</th>
					  <th scope=col>Nacionalidad</th>
					  <th scope=col>Numero de veces</th>";
				break;
		}		
		echo "</tr>
		  </thead>
		  <tbody>";
		//consultas
		switch($flag){
			case 1:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 2:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 3:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 4:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 5:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 6:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;			
			case 7:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 8:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 9:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
			case 10:
				$query='SELECT pelicula.titulo_p,pelicula.ano_produccion,trabajo.Nombre_persona FROM pelicula natural join trabajo
						WHERE (trabajo.Tarea = "Actor Principal" or trabajo.Tarea = "Director" or trabajo.Tarea="Actor Secundario")
						group by Nombre_persona,CIP
						HAVING COUNT(*)>1;';
				break;
		}		
		$resultados=mysqli_query($conexion,$query);			
		$cont = 1;
		while(($fila=mysqli_fetch_row($resultados))){			
			echo "<tr>
					<th scope=row>".$cont."</th>";					
			for ($i = 1; $i <count($fila); $i++) {														
				echo "<td>".$fila[$i]."</td>";						
			}																	
			echo "</tr>";
			$cont++;
		}		
		echo "</tbody></table><br>";
	?>
	<form action="index.php" method="post">
		<button type="submit" name="btn_volver" class="btn btn-primary">Volver</button>					
	</form>	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

