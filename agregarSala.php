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
	
	$arraySalas[][]=array();
	$arrayCines[][]=array();
	$arraySalas[0][0]=1;
	
	
	$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
	mysqli_set_charset($conexion,"utf8");
	
	
	//CARGAR PROVEEDORES
	$query="SELECT * FROM cine";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arrayCines[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
	
	if($cont==0){
		echo '<script type="text/javascript">
			alert("No hay cines");
			window.location.href="index.php";
			</script>';
	}
	
	$query="SELECT * FROM sala";
	$resultados=mysqli_query($conexion,$query);	
	
	$cont = 0;
	while(($fila=mysqli_fetch_row($resultados))){
		for ($i = 0; $i <count($fila); $i++) {		
			$arraySalas[$cont][$i] = $fila[$i];			
		}		
		$cont++;
	}
			
  ?>
  
  <!-- Titulo principal -->
  
  <h1>Agregar Salas</h1>  
  <p>
	En esta seccion podra agregar salas y asignarlos a su respectivo cine, tambien modificar y eliminar salas. Tome en
	cuenta que no se puede modificar el cine al que pertenece por cuestiones de seguridad, si desea hacerlo, elimine la
	sala y creelo de nuevo con su nuevo cine.
  </p>	
	
	
  <h1 class="display-3"></h1>
  	<br>	
			<form method="post">		
        	<div class="container">
            	<section class="main row">
                    <div class="col-md-4">
						<?php
			
							for ($i = 0; $i < count($arrayCines); $i++) {						
								if(isset($_POST[((string)$i)."f"])){									
									apcu_store('idCine', $arrayCines[$i][0]);																																
									break;
								}							
							}
							
							if(isset($_POST['Crear'])){									
								$p1 = "null";
								$p2 = (int)apcu_fetch('idCine');
								$p3 = $_POST['a'];
								$p4	= (string)$_POST['b'];								
								$query = "CALL insertarSala($p1,$p2,$p3,$p4);";
								mysqli_query($conexion,$query);
							}
							if(isset($_POST['Modificar'])){									
								$p1 = $arraySalas[(int)apcu_fetch('posActual')][0];
								$p2 = $_POST['a'];
								$p3 = $arraySalas[(int)apcu_fetch('posActual')][2];
								$p4	= $_POST['b'];	
								$query = "CALL modificarSala($p1,$p2,$p3,$p4);";
								mysqli_query($conexion,$query);	
							}
							if(isset($_POST['Eliminar'])){																	
								$p1 = $arraySalas[(int)apcu_fetch('posActual')][0];							
								$query = "CALL eliminarSala($p1);";
								mysqli_query($conexion,$query);	
							}						
						?>
                        <h2>Cines</h2>
                        <p>Seleccione un Cine donde se estacionara la sala.
                        </p>                                                
						<?php
							for ($i = 0; $i <count($arrayCines); $i++) {																																		
								echo "<input type=submit name=".$i."f"." value=".$arrayCines[$i][1]." class=list-group-item list-group-item-action>";								
							}									
						?>							
                                             
                    </div>

                    <div class="col-md-4">
						
                        <h2>Salas</h2>
                        <p>Seleccione una sala para ver su información. 
							<?php	
								if($arraySalas[0][0] != 1){
									for ($i = 0; $i <count($arraySalas); $i++) {																																				
										echo "<input type=submit name=".$i." value=".$arraySalas[$i][2]." class=list-group-item list-group-item-action>";										
									}
								}
							?> 
	
                    </div>
			
					<div class="col-md-4">	
						<?php					
							$posActual = 0;
							for ($i = 0; $i <count($arraySalas); $i++) {	
								if(isset($_POST[(string)$i])){								
									$posActual = $i;
									apcu_store('posActual',$posActual);
									break;
								}								
							}
							if($arraySalas[0][0] == 1){
								for ($i = 0; $i <10; $i++) {	
									$arraySalas[$posActual][$i] = "-Seleccione-";
								}
							}
							 											
							$query='SELECT `NombreCine` FROM `cine` WHERE `IdCine`='.$arraySalas[$posActual][1].';';							
							$cine = mysqli_query($conexion,$query);
														
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Nombre de la sala</span>										
									<input type=text name=a value=".$arraySalas[$posActual][2]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							if(!$cine){
								echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Nombre del cine</span>										
									<input type=text name=c value=".$arraySalas[$posActual][1]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							}else{
								echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Nombre del cine</span>										
									<input type=text name=c value=".(mysqli_fetch_row($cine))[0]." class=form-control aria-describedby=basic-addon1>										
								</div>";
							}							
							echo "<div class=input-group-prepend>
									<span class=input-group-text id=basic-addon1>Aforo</span>										
									<input type=text name=b value=".$arraySalas[$posActual][3]." class=form-control aria-describedby=basic-addon1>										
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