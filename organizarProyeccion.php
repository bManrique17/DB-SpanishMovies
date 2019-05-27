<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
    <h1>Administracion</h1>
  </head>
  <body> 
  
  <!-- Variables globales  -->
  <?php		

	$idFestival_CA=0;
	
	$db_host="localhost";
	$db_nombre="proyeccion_pelicula";	
	$db_usuario="root";
	$db_contra="";
	
	$arrayProyecciones[][]=array();
	$arraySalas[][]=array();
	$arrayPeliculas[][]=array();
	$arrayProyecciones[0][0]=1;	
	
	$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
	mysqli_set_charset($conexion,"utf8");
	
	//CARGAR PELICULAS
	$query="SELECT * FROM pelicula";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayPeliculas[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay peliculas");
			window.location.href="index.php";
			</script>';
	}

	//CARGAR SALAS
	$query="SELECT * FROM sala";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arraySalas[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay salas");
			window.location.href="index.php";
			</script>';
	}
	
	$query="SELECT * FROM proyeccion";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayProyecciones[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
			
  ?>
  
  <!-- Titulo principal -->
  
  <h1>Organizar Proyecciones</h1>  
  <p>
	En esta seccion podra crear proyeccion y asignarlos con la pelicula a su respectiva sala, tambien modificar y eliminar 
	proyecciones. Tome en cuenta que no se puede modificar la pelicula y la sala a la que pertenece por cuestiones de seguridad,
	si desea hacerlo, elimine la proyeccion y creela de nuevo con su nueva sala y su nueva pelicula.
  </p>	
	
	
  <h1 class="display-3"></h1>
  	<br>	
			<form method="post">		
        	<div class="container">
            	<section class="main row">
                    <div class="col-md-3">
						<?php
			
							for ($i = 0; $i < count($arraySalas); $i++) {						
								if(isset($_POST[((string)$i)."s"])){									
									apcu_store('idSala', $arraySalas[$i][0]);																																
									break;
								}							
							}
							for ($i = 0; $i < count($arrayPeliculas); $i++) {						
								if(isset($_POST[((string)$i)."p"])){									
									apcu_store('idPelicula', $arrayPeliculas[$i][0]);																																
									break;
								}							
							}
							
							if(isset($_POST['Crear'])){									
								$p1 = "null";
								$p2 = (int)apcu_fetch('idSala');
								$p3 = (int)apcu_fetch('idPelicula');
								$p4 = $_POST['a'];								
								$p5 = (int)$_POST['b'];								
								$p6 = (int)$_POST['c'];								
								$p7 = (int)$_POST['d'];								
								$query = "CALL insertarProyeccion($p1,$p2,$p3,$p4,$p5,$p6,$p7);";
								mysqli_query($conexion,$query);	
							}
							if(isset($_POST['Modificar'])){									
								$p1 = $arrayProyecciones[(int)apcu_fetch('posActual')][0];
								$p2 = $arrayProyecciones[(int)apcu_fetch('posActual')][1];
								$p3 = $arrayProyecciones[(int)apcu_fetch('posActual')][2];
								$p4 = $_POST['a'];								
								$p5 = (int)$_POST['b'];								
								$p6 = (int)$_POST['c'];								
								$p7 = (int)$_POST['d'];							
								$query = "CALL modificarProyeccion($p1,$p2,$p3,$p4,$p5,$p6,$p7);";
								mysqli_query($conexion,$query);	
							}
							if(isset($_POST['Eliminar'])){																	
								$p1 = $arrayProyecciones[(int)apcu_fetch('posActual')][0];							
								$query = "CALL eliminarProyeccion($p1);";
								mysqli_query($conexion,$query);	
							}						
						?>
                        <h2>Peliculas</h2>
                        <p>Seleccione la pelicula a proyecctar.
                        </p>                                                
						<?php
							for ($i = 0; $i <count($arrayPeliculas); $i++) {																																		
								echo "<input type=submit name=".$i."p"." value=".$arrayPeliculas[$i][1]." class=list-group-item list-group-item-action>";								
							}									
						?>							
                                             
                    </div>
                    <div class="col-md-3">
						
                        <h2>Salas</h2>
                        <p>Seleccione la sala a usar. 
							<?php	
						
								for ($i = 0; $i <count($arraySalas); $i++) {																																		
									echo "<input type=submit name=".$i."s"." value=".$arraySalas[$i][1]." class=list-group-item list-group-item-action>";								
								}									
						
							?> 
						
                        
							
                    </div>
                    <div class="col-md-3">
						
                        <h2>Proyecciones</h2>
                        <p>Seleccione la proyeccion para ver su informacion. 
							<?php	
								if($arrayProyecciones[0][0] != 1){
									for ($i = 0; $i <count($arrayProyecciones); $i++) {																																				
										echo "<input type=submit name=".$i." value=".$arrayProyecciones[$i][1]." class=list-group-item list-group-item-action>";										
									}
								}
							?> 
	
                    </div>
			
					<div class="col-md-3">	
						<?php					
							$posActual = 0;
							for ($i = 0; $i <count($arrayProyecciones); $i++) {	
								if(isset($_POST[(string)$i])){								
									$posActual = $i;
									apcu_store('posActual',$posActual);
									break;
								}								
							}
							if($arrayProyecciones[0][0] == 1){
								for ($i = 0; $i <10; $i++) {	
									$arrayProyecciones[$posActual][$i] = "-Seleccione-";
								}
							}
																		
							$query='SELECT `Titulo` FROM `pelicula` WHERE `IdPelicula`='.$arrayProyecciones[$posActual][2].';';							
							$titulo = mysqli_query($conexion,$query);

							$query='SELECT `NombreSala` FROM `sala` WHERE `IdSala`='.$arrayProyecciones[$posActual][1].';';							
							$nombreSala = mysqli_query($conexion,$query);
							
							$query2='SELECT `NombreCine` FROM `sala` WHERE `IdSala`='.$arrayProyecciones[$posActual][1].';';							
							$query22 = mysqli_query($conexion,$query2);
														
							
							$query='SELECT `NombreCine` FROM `cine` WHERE `IdCine`='.(int)(mysqli_fetch_row($query22))[0].';';							
							$nombreCine = mysqli_query($conexion,$query);									
							
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Nombre de la Sala</span>										
									<input type=text name=a2 value=".(mysqli_fetch_row($nombreCine))[0]." class=form-control aria-describedby=basic-addon1>										
								</div>";								
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Nombre de la Sala</span>										
									<input type=text name=a2 value=".(mysqli_fetch_row($nombreSala))[0]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Titulo de la pelicula</span>										
									<input type=text name=a1 value=".(mysqli_fetch_row($titulo))[0]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Fecha de estreno</span>										
									<input type=text name=a value=".$arrayProyecciones[$posActual][3]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Dias de estreno</span>										
									<input type=text name=b value=".$arrayProyecciones[$posActual][4]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Numero de espectadores</span>										
									<input type=text name=c value=".$arrayProyecciones[$posActual][5]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Recaudacion</span>										
									<input type=text name=d value=".$arrayProyecciones[$posActual][6]." class=form-control aria-describedby=basic-addon1>										
								</div>";								
						?>   
						
                    </div>
					
                </section>

            </div>																		
				<br>
				
				<section class="main row">
					<div class="col-md-2">
					</div>
					<div class="col-md-2">
					</div>
					<div class="col-md-2">
					</div>
					<div class="col-md-2">									
						<input type="submit" name="Crear" value= "Crear" class="btn btn-secondary">
					</div>									
					<div class="col-md-2">	
						<input type="submit" name="Modificar" value= "Modificar" class="btn btn-secondary">
					</div>	
					<div class="col-md-2">		
						
						<input type="submit" name="Eliminar" value= "Eliminar" class="btn btn-secondary">
						
					</div>	
				</section>
				
			</form>
			<br>
			<?php
				if(isset($_POST["Crear"])){	
					echo '
					<div class="alert alert-primary" role="alert">
						Creado con exito.
					</div>
					';
				}
				if(isset($_POST["Modificar"])){	
					echo '
					<div class="alert alert-primary" role="alert">
						Modificado con exito.
					</div>
					';

				}
				if(isset($_POST["Eliminar"])){	
					echo '
					<div class="alert alert-primary" role="alert">
						Eliminado con exito.
					</div>
					';

				}
				
            ?>
			<br>
			<form>
				<button type="submit" name="btn_actualizar" class="btn btn-primary">Actualizar</button>					
			</form>
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