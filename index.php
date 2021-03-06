<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Peliculas Españolas</title>
  </head>
  <body>
    <h1>Cinema Español</h1>
	<h2>Administracion</h2>
	<p>Escoja su opción</p>
	<?php apcu_clear_cache();?>
	<form action="CRUD.php" method="post">						
			<button type="submit" name="boton" value = "1" class="btn btn-primary btn-lg btn-block">Peliculas</button>		
			<button type="submit" name="boton" value = "2" class="btn btn-primary btn-lg btn-block">Personajes</button>				
			<button type="submit" name="boton" value = "3" class="btn btn-primary btn-lg btn-block">Trabajos</button>					  
			<button type="submit" name="boton" value = "4" class="btn btn-primary btn-lg btn-block">Cines</button>								
			<button type="submit" name="boton" value = "5" class="btn btn-primary btn-lg btn-block">Proyecciones</button>
			<button type="submit" name="boton" value = "6" class="btn btn-primary btn-lg btn-block">Premios</button>
			<button type="submit" name="boton" value = "7" class="btn btn-primary btn-lg btn-block">Salas</button>						
    </form>
	<h2>Consultas</h2>
	<p>Escoja su opción</p>
	<form action="consultas.php" method="post">						
			<button type="submit" name="boton" value = "1" class="btn btn-primary btn-lg btn-block">Consulta 1</button>		
			<button type="submit" name="boton" value = "2" class="btn btn-primary btn-lg btn-block">Consulta 2</button>				
			<button type="submit" name="boton" value = "3" class="btn btn-primary btn-lg btn-block">Consulta 3</button>					  
			<button type="submit" name="boton" value = "4" class="btn btn-primary btn-lg btn-block">Consulta 4</button>								
			<button type="submit" name="boton" value = "5" class="btn btn-primary btn-lg btn-block">Consulta 5</button>
			<button type="submit" name="boton" value = "6" class="btn btn-primary btn-lg btn-block">Consulta 6</button>
			<button type="submit" name="boton" value = "7" class="btn btn-primary btn-lg btn-block">Consulta 7</button>						
			<button type="submit" name="boton" value = "8" class="btn btn-primary btn-lg btn-block">Consulta 8</button>
			<button type="submit" name="boton" value = "9" class="btn btn-primary btn-lg btn-block">Consulta 9</button>
			<button type="submit" name="boton" value = "10" class="btn btn-primary btn-lg btn-block">Consulta 10</button>			
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>