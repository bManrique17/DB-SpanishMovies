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
	<form action="index.php" method="post">
		<button type="submit" name="btn_volver" class="btn btn-primary">Volver</button>					
	</form>
	<?php
		if(isset($_POST['boton'])){
			apcu_store('flag', $_POST['boton']);
		}
		$flag = (int)apcu_fetch('flag');		
		
		$db_host="localhost";
		$db_nombre="proyeccion_pelicula";	
		$db_usuario="root";
		$db_contra="";
		
		$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
		mysqli_set_charset($conexion,"utf8");
		
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
				$query="SELECT DISTINCT titulo_p,
						  ano_produccion AS Fecha,
						  nombre_persona
						FROM Trabajo,
						Pelicula
						WHERE Pelicula.cip  =Trabajo.cip
						AND tarea           ='Director'
						AND nombre_persona IN
						  (SELECT nombre_persona
						  FROM Trabajo Tint
						  WHERE tarea <> 'Productor'
						  AND tarea   <> 'Director'
						  AND Tint.cip =Trabajo.cip
						  )";
				break;				
			case 2:
				$query="SELECT distinct titulo_p as Pelicula, festival, ano_produccion as Año, Premio
						FROM (Trabajo natural join Pelicula), Otorgo
						where Nombre_persona='Isaac Hayes' and tarea='director' and Otorgo.cip=Trabajo.cip and festival='Oscars';";
				break;
			case 3:
				$query="SELECT distinct Nombre_Persona,count(festival) as Numero 
						FROM Reconocimiento natural join Trabajo where festival='Oscars' and (Tarea='Actor Principal')
						group by Nombre_persona;";
				break;
			case 4:
				$query="SELECT distinct titulo_p as Titulo,ano_produccion as Fecha_Produccion FROM Pelicula where presupuesto>6000;";
				break;
			case 5:
				$query="SELECT distinct Cine as NombreCine,count(Sala) as NumSalas  
						FROM Cine NATURAL JOIN Sala
						WHERE ciudad_cine='Madrid'
						group by Cine;";
				break;
			case 6:
				$query="select distinct festival,R.premio,Reconocimiento.certamen from Reconocimiento, 
						(select distinct premio,certamen from Reconocimiento where premio='Mejor actriz secundaria' and certamen = '1997') R
						where Festival='Oscars' and Reconocimiento.certamen='1997'";
				break;			
			case 7:
				$query="select distinct titulo_p,nacionalidad
						from (SELECT distinct cine,cip,count(Sala) as Salas
						FROM Proyeccion
						group by cip,cine having Salas>1) E2 natural join Pelicula;";
				break;
			case 8:
				$query="SELECT titulo_p,nombre_persona
						FROM (SELECT cip,count(Nombre_persona) as Contar 
						FROM Trabajo
						where tarea='Actor Principal'
						group by cip having Contar> 2 ) E1 natural join Pelicula natural join Trabajo;";
				break;
			case 9:
				$query="Select titulo_p,nombre_persona
						from (select  nombre_persona, count(tarea) as numero 
						from Trabajo where tarea='Actor Principal'
						group by nombre_persona
						having Numero >3)F natural join Pelicula natural join Trabajo;";
				break;
			case 10:
				$query="SELECT distinct nombre_persona,nacionalidad,veces
						FROM Trabajo, Pelicula,
							(SELECT nombre_persona AS nombre, COUNT(tarea) AS veces FROM Trabajo WHERE tarea LIKE '%Actor%'
							GROUP BY nombre_persona
							) T WHERE Pelicula.cip=Trabajo.cip AND Trabajo.tarea ='Director' AND T.nombre      = Trabajo.nombre_persona
							AND veces>2;";
				break;
		}			
		$resultados=mysqli_query($conexion,$query);			
		$cont = 0;		
		while(($fila=mysqli_fetch_row($resultados))){						
			echo "<tr>
					<th scope=row>".$cont."</th>";					
			for ($i = 0; $i <count($fila); $i++) {														
				echo "<td>".$fila[$i]."</td>";						
			}																	
			echo "</tr>";
			$cont++;
		}		
		echo "</tbody></table><br>";
	?>
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

