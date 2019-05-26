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
	
	$arrayReconocimientos[][]=array();
	$arrayCertamenes[][]=array();
	$arrayPremios[][]=array();	
	$arrayTrabajos[][]=array();
	$arrayReconocimientos[0][0]=1;
	
	
	$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
	mysqli_set_charset($conexion,"utf8");
	
	
	//CARGAR PROVEEDORES
	$query="SELECT * FROM certamen";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayCertamenes[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay certamenes");
			window.location.href="index.php";
			</script>';
	}
	
	$query="SELECT * FROM premio";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayPremios[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay premios");
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
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay trabajos asignados");
			window.location.href="index.php";
			</script>';
	}
  ?>
  
  <!-- Titulo principal -->
  
  <h1>Otorgar reconocimientos</h1>  
  <p>
	En esta seccion podra otorgar reconocimientos, asegurese de escoger el premio, personaje y certamen correspondientes,
	tome en cuenta que el premio de poseer la misma tarea que el personaje para ser asignado. No podra modificar los
	reconocimientos por motivos de seguridad, si desea cambiar uno, eliminelo y cree uno nuevo con la informacion deseada.
  </p>	
	
	
  <h1 class="display-3"></h1>
  	<br>	
			<form method="post">		
        	<div class="container">
            	<section class="main row">
                    <div class="col-md-3">
						<?php				
							for ($i = 0; $i < count($arrayCertamenes); $i++) {						
								if(isset($_POST[((string)$i)."c"])){									
									apcu_store('idCertamen', $arrayCertamenes[$i][0]);																																
									break;
								}							
							}
							
							for ($i = 0; $i < count($arrayPremios); $i++) {						
								if(isset($_POST[((string)$i)."p"])){									
									apcu_store('idPremio', $arrayPremios[$i][0]);																																
									break;
								}							
							}
							
							for ($i = 0; $i < count($arrayTrabajos); $i++) {						
								if(isset($_POST[((string)$i)."t"])){									
									apcu_store('idPersonaje', $arrayTrabajos[$i][1]);																																
									break;
								}							
							}
							
							if(isset($_POST['Crear'])){									
								$p1 = "null";
								$p2 = (int)apcu_fetch('idCertamen');
								$p3 = (int)apcu_fetch('idPremio');
								$p4	= (int)apcu_fetch('idPersonaje');
								$query = "CALL insertarReconocimiento($p1,$p2,$p3,$p4);";
								mysqli_query($conexion,$query);	
							}

							if(isset($_POST['Eliminar'])){																	
								$p1 = $arrayReconocimientos[(int)apcu_fetch('posActualr')][0];							
								$query = "CALL eliminarReconocimiento($p1);";
								mysqli_query($conexion,$query);	
							}						
						?>
                        <h2>Certamenes</h2>
                        <p>Seleccione un un certamen.
                        </p>                                                
						<?php
							for ($i = 0; $i <count($arrayCertamenes); $i++) {
								
								echo "<input type=submit name=".$i."c"." value=".$arrayCertamenes[$i][1]." class=list-group-item list-group-item-action>";								
							}									
						?>							
                                             
                    </div>

                    <div class="col-md-3">
						
                        <h2>Premios por tarea</h2>
                        <p>Seleccione un premio. 
							<?php	
								for ($i = 0; $i <count($arrayPremios); $i++) {	
									$etiqueta = $arrayPremios[$i][1]."-".$arrayPremios[$i][2];
									echo "<input type=submit name=".$i."p"." value=".$etiqueta." class=list-group-item list-group-item-action>";								
								}
							?> 
	
                    </div>
			
					<div class="col-md-3">
						<h2>Personajes por tarea</h2>
                        <p>Seleccione un personaje.
						<?php			
							$posActual = 0;
							for ($i = 0; $i <count($arrayTrabajos); $i++) {	
								if(isset($_POST[((string)$i)."p"])){								
									$posActual = $i;
									apcu_store('posActual',$posActual);
									break;
								}								
							}
							for ($i = 0; $i <count($arrayTrabajos); $i++) {
								$query='SELECT `Nombre_Persona` FROM `personaje` WHERE `IdPersonaje`=
									'.$arrayTrabajos[$posActual][1].';';							
								$nombre = mysqli_query($conexion,$query);
								echo "<input type=submit name=".$i."t"." value=".(mysqli_fetch_row($nombre))[0]."-".
									$arrayTrabajos[$posActual][2]." class=list-group-item list-group-item-action>";								
							}
						?>   
						
                    </div>
					<div class="col-md-3">
						<h2>Eliminar reconocimientos</h2>
                        <p>Seleccione un reconocimiento para eliminarlo, se lista el numero de reconocimiento segun la tabla
							de reconocimientos entregados.	
						<?php			
							$posActualr = 0;
							for ($i = 0; $i <count($arrayReconocimientos); $i++) {	
								if(isset($_POST[((string)$i)."rr"])){								
									$posActualr = $i;
									apcu_store('posActualr',$posActualr);
									break;
								}								
							}
							for ($i = 0; $i <count($arrayTrabajos); $i++) {								
								echo "<input type=submit name=".$i."rr"." value=".($i+1)." class=list-group-item list-group-item-action>";								
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
					</div>
					<div class="col-md-2">									
						<input type="submit" name="Crear" value= "Crear" class="btn btn-secondary">
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
					
					if(isset($_POST["Eliminar"])){	
						echo '
						<div class="alert alert-primary" role="alert">
							Eliminado con exito.
						</div>
						';

					}
					
				?>
				<br>
				
			<?php

				echo "<h1>Reconocimientos entregados</h1> ";
				echo
				"<br><table class=table>
				  <thead>
					<tr>
					  <th scope=col>#</th>
					  <th scope=col>Festival</th>
					  <th scope=col>Certamen</th>
					  <th scope=col>Nombre premio</th>
					  <th scope=col>Personaje</th>
					  <th scope=col>Tarea</th>
					  
					</tr>
				  </thead>
				  <tbody>";
				$query="SELECT * FROM reconocimiento";
				$resultados=mysqli_query($conexion,$query);	
				
				$cont = 1;

				while(($fila=mysqli_fetch_row($resultados))){
					
					echo 
						"<tr>
						  <th scope=row>".$cont."</th>";
							
					for ($i = 1; $i <count($fila); $i++) {	
						switch($i){
							case 1:
								$data[$i] = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `NombreCertamen` 
								FROM `certamen` WHERE `IdCertamen`='
								.$fila[$i].';')))[0];
								break;
							case 2:
								$data[$i] = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `NombrePremio` 
								FROM `premio` WHERE `IdPremio`='
								.$fila[$i].';')))[0];
								break;
							case 3:
								$data[$i] = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `Nombre_Persona` 
								FROM `personaje` WHERE `IdPersonaje`='
								.$fila[$i].';')))[0];
								break;
						}
						if($i == 1){
							$idFestival = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `Organizador` 
								FROM `certamen` WHERE `IdCertamen`='
								.$fila[1].';')))[0];
								
							$nombreFestival = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `NombreFestival` 
								FROM `festival` WHERE `IdFestival`='
								.$idFestival.';')))[0];
								
							echo "<td>".$nombreFestival."</td>";
						}
						
							
					
						echo "<td>".$data[$i]."</td>";						
					}
					
						
					$nombreTarea = (mysqli_fetch_row(mysqli_query($conexion,'SELECT `Tarea` 
						FROM `premio` WHERE `IdPremio`='
						.$fila[2].';')))[0];
						
					echo "<td>".$nombreTarea."</td>";					
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
