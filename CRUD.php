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
	<form>
		<button type="submit" name="btn_actualizar" class="btn btn-primary">Actualizar</button>					
	</form>

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
		
		$array[0][0] = 1;		
		
		$conexion=mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
		mysqli_set_charset($conexion,"utf8");
		
		switch($flag){
			case 1:
				//pelicula
				echo "<h1>Peliculas</h1>";
				$query="SELECT * FROM Pelicula";
				break;
			case 2:
				//personaje
				echo "<h1>Personajes</h1>";
				$query="SELECT * FROM Personaje";	
				break;
			case 3:
				echo "<h1>Trabajos</h1>";
				$query="SELECT * FROM Trabajo";	
				break;
			case 4:
				//cine
				echo "<h1>Cines</h1>";
				$query="SELECT * FROM Cine";
				break;
			case 5:
				//festival
				echo "<h1>Proyecciones</h1>";				
				$query="SELECT * FROM Proyeccion";
				break;
			case 6:
				//premio
				echo "<h1>Premios</h1>";
				$query="SELECT * FROM Premio";
				break;						
			case 7:
				//premio
				echo "<h1>Sala</h1>";
				$query="SELECT * FROM Sala";
				break;
		};
		$resultados=mysqli_query($conexion,$query);						
		$cont = 0;
		while(($fila=mysqli_fetch_row($resultados))){
			echo "FUNMADR";
			for ($i = 0; $i <count($fila); $i++) {				
				$array[$cont][$i] = $fila[$i];						
			}		
			$cont++;
		}		
	  ?>
    
    
  <p>
	En la columna izquierda se muestran todas los items actuales, si desea crear uno, llene los campos
	y presione 'crear'. Si desea modificar, seleccione el item a modificar, cambie el dato deseado en los
	campos de texto y presione 'modificar'. Para eliminar, seleccione un item y presione 'Eliminar'.
  </p>	
	<?php
	if(isset($_POST["Modificar"])){	
		$p1 = (int)$array[(int)apcu_fetch('posActual')][0];
		switch($flag){
			case 1:															
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = (int)$_POST["c"];
				$p5 = '"'.$_POST["d"].'"';
				$p6 = '"'.$_POST["e"].'"';
				$p7 = (int)$_POST["f"];		
				$p8 = (int)$_POST["g"];				
				$query = "CALL modificarPelicula($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);";								
				break;																																
			case 2:				
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL modificarPersonaje($p1,$p2,$p3,$p4);";									
				break;				
			case 3:				
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL modificarTrabajo($p1,$p2,$p3,$p4);";									
				break;							
			case 4:				
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL modificarCine($p1,$p2,$p3,$p4);";									
				break;
			case 5:						
				$p2 = '"'.$_POST["a"].'"';
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';
				$p5 = '"'.$_POST["d"].'"';
				$p6 = (int)$_POST["e"];
				$p7 = (int)$_POST["f"];
				$p8 = (int)$_POST["g"];
				$query = "CALL modificarProyeccion($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);";													
				break;
			case 6:				
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$query = "CALL modificarPremio($p1,$p2,$p3);";																
				break;
			case 7:				
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL modificarSala($p1,$p2,$p3,$p4);";												
				break;
		}
		mysqli_query($conexion,$query);		
	}
	
	if(isset($_POST["Crear"])){						
		switch($flag){
			case 1:											
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = (int)$_POST["c"];
				$p5 = '"'.$_POST["d"].'"';
				$p6 = '"'.$_POST["e"].'"';
				$p7 = (int)$_POST["f"];		
				$p8 = (int)$_POST["g"];				
				$query = "CALL insertarPelicula($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);";								
				break;																																
			case 2:
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL insertarPersonaje($p1,$p2,$p3,$p4);";									
				break;				
			case 3:
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL insertarTrabajo($p1,$p2,$p3,$p4);";									
				break;							
			case 4:
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL insertarCine($p1,$p2,$p3,$p4);";									
				break;
			case 5:
				$p1 = "null";				
				$p2 = '"'.$_POST["a"].'"';
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';
				$p5 = '"'.$_POST["d"].'"';
				$p6 = (int)$_POST["e"];
				$p7 = (int)$_POST["f"];
				$p8 = (int)$_POST["g"];
				$query = "CALL insertarProyeccion($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);";													
				break;
			case 6:
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$query = "CALL insertarPremio($p1,$p2,$p3);";																
				break;
			case 7:
				$p1 = "null";
				$p2 = '"'.$_POST["a"].'"';					
				$p3 = '"'.$_POST["b"].'"';
				$p4 = '"'.$_POST["c"].'"';	
				$query = "CALL insertarSala($p1,$p2,$p3,$p4);";												
				break;
		}
		mysqli_query($conexion,$query);		
	}
	
	if(isset($_POST["Eliminar"])){	
		$p1 = (int)$array[(int)apcu_fetch('posActual')][0];		
		switch($flag){
			case 1:				
				$query = "CALL eliminarPelicula($p1);";
				break;
			case 2:				
				$query = "CALL eliminarPersonaje($p1);";
				break;
			case 3:				
				$query = "CALL eliminarTrabajo($p1);";
				break;
			case 4:				
				$query = "CALL eliminarCine($p1);";
				break;
			case 5:				
				$query = "CALL eliminarProyeccion($p1);";
				break;
			case 6:				
				$query = "CALL eliminarPremio($p1);";
				break;			
			case 7:
				$query = "CALL eliminarSala($p1);";
				break;
		}																
		mysqli_query($conexion,$query);	
	}
?>
	
  <h1 class="display-3"></h1>
  	<br>
        	<div class="container">
				<form method="post">
            	<section class="main row">
                    <div class="col-md-6">
                        <h2>Items</h2>
                        <p>Seleccione
                        </p>
                                                
						<?php
							if($array[0][0] != 1){																
								for ($i = 0; $i <count($array); $i++) {																										
									echo "<form method=post>";
										switch($flag){																															
											case 1:													
												echo "<input type=submit name=".$i." value="."'".$array[$i][2]."'"." class=list-group-item list-group-item-action>";
												break;
											case 2:													
												echo '<input type=submit name='.$i.' value='.'"'.$array[$i][1].'"'.' class=list-group-item list-group-item-action>';
												break;
											case 3:	
												$info = $array[$i][2].':'.$array[$i][3];
												echo "<input type=submit name=".$i." value=".'"'.$info.'"'." class=list-group-item list-group-item-action>";
												break;
											case 4:											
												echo "<input type=submit name=".$i." value=".'"'.$array[$i][1].'"'." class=list-group-item list-group-item-action>";
												break;
											case 5:			
												$info = $array[$i][3].':'.$array[$i][1].':'.$array[$i][2];
												echo "<input type=submit name=".$i." value=".'"'.$info.'"'." class=list-group-item list-group-item-action>";
												break;
											case 6	:											
												echo "<input type=submit name=".$i." value=".'"'.$array[$i][1].'"'." class=list-group-item list-group-item-action>";
												break;
											case 7:
												$info = $array[$i][1].':'.$array[$i][2];
												echo "<input type=submit name=".$i." value=".'"'.$info.'"'." class=list-group-item list-group-item-action>";
												break;
										}								
									echo "</form>";
								
								}	
							}							
						?>							
                                             
                    </div>
                    
                    <div class="col-md-6">
						
						<h2>Modificacion</h2>
						<?php	
							$posActual = 0;
							for ($i = 0; $i <count($array); $i++) {	
								if(isset($_POST[(string)$i])){								
									$posActual = $i;
									break;
								}								
							}
							if($array[0][0] == 1){
								for ($i = 0; $i <10; $i++) {	
									$array[$posActual][$i] = "-Seleccione-";
								}
							}
							apcu_store('posActual',$posActual);
							switch($flag){
								case 1:
									//pelicula
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>CIP</span>											
											<input type=text name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>											
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Titulo</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Año de producción</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Titulo en español</span>
											<input type=text name=d value=".'"'.$array[$posActual][4].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Nacionalidad</span>
											<input type=text name=e value=".'"'.$array[$posActual][5].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Presupuesto</span>
											<input type=text name=f value=".'"'.$array[$posActual][6].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Duracion</span>
											<input type=text name=g value=".'"'.$array[$posActual][7].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									break;
								case 2:
									//personaje
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Nombre</span>
											<input type=text id=a name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Nacionalidad</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Sexo</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									break;
								case 3:
									//trabajo
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>CIP</span>
											<input type=text id=a name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Nombre</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Tarea</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";																	
									break;
								case 4:
									//cine
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Nombre</span>
											<input type=text id=a name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Ciudad</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Direccion</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";							
									break;
								case 5:
									//proyeccion
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Cine</span>
											<input type=text name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Sala</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>CIP</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Fecha de estreno</span>
											<input type=text name=d value=".'"'.$array[$posActual][4].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Dias de estreno</span>
											<input type=text name=e value=".'"'.$array[$posActual][5].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Espectadores</span>
											<input type=text name=f value=".'"'.$array[$posActual][6].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Recaudacion</span>
											<input type=text name=g value=".'"'.$array[$posActual][7].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									break;
								case 6:
									//premio
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Premio</span>
											<input type=text id=a name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Tarea</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									break;	
								case 7:
									//sala
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Cine</span>
											<input type=text id=a name=a value=".'"'.$array[$posActual][1].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Sala</span>
											<input type=text name=b value=".'"'.$array[$posActual][2].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									echo "<div class=input-group-prepend>
											<span class=input-group-text id=basic-addon1>Aforo</span>
											<input type=text name=c value=".'"'.$array[$posActual][3].'"'." class=form-control aria-describedby=basic-addon1>
										</div>";
									break;
							};
						?>
						<br>
						<section class="main row">
							<div class="col-md-3">									
								<input type="submit" name="Crear" value= "Crear" id="Crear" class="btn btn-secondary">
							</div>									
							<div class="col-md-3">	
								<input type="submit" name="Modificar" value= "Modificar" id="Modificar" class="btn btn-secondary">
							</div>	
							<div class="col-md-3">		
								
								<input type="submit" name="Eliminar" value= "Eliminar" id="Eliminar" class="btn btn-secondary">
								
							</div>	
						</section>
                    </div>
					                
                </section>
				</form>

            </div>

			
			<br>
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
			

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

