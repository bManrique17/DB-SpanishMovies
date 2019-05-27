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
	$db_host="localhost";
	$db_nombre="proyeccion_pelicula";	
	$db_usuario="root";
	$db_contra="";
	
	$arrayTrabajos[][]=array();
	$arrayPersonajes[][]=array();
	$arrayTrabajos[0][0]=1;
	
	
	$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
	mysqli_set_charset($conexion,"utf8");
	
	
	//CARGAR PROVEEDORES
	$query="SELECT * FROM personaje";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayPersonajes[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay personajes");
			window.location.href="index.php";
			</script>';
	}
	
	$query="SELECT * FROM trabajo";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayTrabajos[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
			
  ?>
  
  <!-- Titulo principal -->
  
  <h1>Asignar Trabajos</h1>  
  <p>
	En esta seccion podra crear Trabajos y asignarlos a su respectivo personaje, tambien modificar y eliminar trabajos. Tome en
	cuenta que no se puede modificar el personaje al que pertenece por cuestiones de seguridad, si desea hacerlo, elimine el
	trabajo y creelo de nuevo con su nuevo personaje.
  </p>	
	
	
  <h1 class="display-3"></h1>
  	<br>	
			<form method="post">		
        	<div class="container">
            	<section class="main row">
                    <div class="col-md-4">
						<?php
			
							for ($i = 0; $i < count($arrayPersonajes); $i++) {						
								if(isset($_POST[((string)$i)."f"])){									
									apcu_store('idPersonaje', $arrayPersonajes[$i][0]);																																
									break;
								}							
							}
							
							if(isset($_POST['Crear'])){									
	
							}
							if(isset($_POST['Modificar'])){									
								$p1 = $arrayTrabajos[(int)apcu_fetch('posActual')][0];												
								$p2 = (int)apcu_fetch('idPersonaje');								
								$p3 = $_POST['a'];							
								$query = "CALL modificarTrabajo($p1,$p2,$p3);";
								mysqli_query($conexion,$query);	
							}
							if(isset($_POST['Eliminar'])){																	
								$p1 = $arrayTrabajos[(int)apcu_fetch('posActual')][0];							
								$query = "CALL eliminarTrabajo($p1);";
								mysqli_query($conexion,$query);	
							}						
						?>
                        <h2>Personajes</h2>
                        <p>Seleccione el Personaje al cual se le asignara un trabajo.
                        </p>                                                
						<?php
							for ($i = 0; $i <count($arrayPersonajes); $i++) {																																		
								echo "<input type=submit name=".$i."f"." value=".$arrayPersonajes[$i][1]." class=list-group-item list-group-item-action>";								
							}									
						?>							
                                             
                    </div>

                    <div class="col-md-4">
						
                        <h2>Trabajos</h2>
                        <p>Seleccione un trabajo para ver su información. 
							<?php	
								if($arrayTrabajos[0][0] != 1){
									for ($i = 0; $i <count($arrayTrabajos); $i++) {																																				
										echo "<input type=submit name=".$i." value=".$arrayTrabajos[$i][2]." class=list-group-item list-group-item-action>";										
									}
								}
							?> 
						
                        
							
                    </div>
			
					<div class="col-md-4">	
						<?php					
							$posActual = 0;
							for ($i = 0; $i <count($arrayTrabajos); $i++) {	
								if(isset($_POST[(string)$i])){								
									$posActual = $i;
									apcu_store('posActual',$posActual);
									break;
								}								
							}
							if($arrayTrabajos[0][0] == 1){
								for ($i = 0; $i <10; $i++) {	
									$arrayTrabajos[$posActual][$i] = "-Seleccione-";
								}
							}
																		
							$query='SELECT `Nombre_Persona` FROM `personaje` WHERE `IdPersonaje`='.$arrayTrabajos[$posActual][1].';';							
							$personaje = mysqli_query($conexion,$query);
						
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Puesto</span>										
									<input type=text name=a value=".$arrayTrabajos[$posActual][2]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							if(!$personaje){
								echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Personaje</span>										
									<input type=text name=b value=".$arrayTrabajos[$posActual][0]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							}else{
								echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Personaje</span>										
									<input type=text name=b value=".(mysqli_fetch_row($personaje))[0]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							}							
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