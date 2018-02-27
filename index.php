<?php 

	include 'config.php';

	$tarea = new Tarea();

	if(count($tarea->listar()) > 0){
		$tareas = $tarea->listar()['datos'];
		$categorias = $tarea->listar()['categorias'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Gestor de Tareas</title>

 	<link rel="stylesheet" href="css/bootstrap.min.css">
 	<link rel="stylesheet" href="css/main.css">

</head>
<body>
	
	<div class="container py-4">
		<div class="jumbotron">
			<h1>Gestor de Tareas</h1>

		</div>

		<!-- Displays de Información -->
		<div id="error" class="alert alert-danger" role="alert" style="display: none">Al menos debe seleccionar una categoría.</div>
		<div id="valid" class="alert alert-success" role="alert" style="display: none">Cambios guardados.</div>	


		<div class="form-group row">
            <div class="col-sm-4">
            	<input type="text" name="nombreTarea" id="nombreTarea" class="form-control" placeholder="Nueva tarea...">
            </div>
            <div class="col-sm-2">
            	<div class="custom-control custom-checkbox">
	            	<input type="checkbox" class="custom-control-input checkbox-tarea" id="php" value="php">
					<label class="custom-control-label" for="php"> PHP </label>
				</div>				
            </div>
            <div class="col-sm-2">
            	<div class="custom-control custom-checkbox">
	            	<input type="checkbox" class="custom-control-input checkbox-tarea" id="javascript" value="javascript">
					<label class="custom-control-label" for="javascript"> Javascript </label>
				</div>				
            </div>
            <div class="col-sm-2">
            	<div class="custom-control custom-checkbox">
	            	<input type="checkbox" class="custom-control-input checkbox-tarea" id="css" value="css">
					<label class="custom-control-label" for="css"> CSS </label>
				</div>				
            </div>
            <div class="col-sm-2">
            	<button type="button" class="btn btn-primary" onclick="addTarea()"> Añadir </button>
            </div>
        </div>

        <div class="table-responsive">
        	<table class="table table-striped table-bordered">
				<thead class="thead">
					<tr>
						<th style="width: 55%"> Tarea </th>
						<th class="col-sm-6"> Categorías </th>
						<th class="col-sm-2"> Acciones </th>
					</tr>
				</thead>
				<tbody id="tbody_tareas">
					<?php if(isset($tareas)): ?>
						<?php foreach($tareas as $row): ?>
							<tr id="tarea_<?php echo $row['id']; ?>">
								<td><?php echo $row['nombre']; ?></td>
								<td style="text-align: center;">
									<?php  foreach ($categorias[$row['id']] as $categoria):?>
										<?php foreach ($categoria as $categ): ?>
											<span class='btn btn-info col-sm-4 boton-tareas'><?php echo $categ; ?></span>
										<?php endforeach; ?>
									<?php endforeach; ?>
								</td>
								<td><input type='button' value='Eliminar' class='btn btn-danger' onclick='eliminarTarea(<?php echo $row['id']; ?>)'></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
        </div>

	</div>	

	<footer class="footer">
		<div class="container">
			<hr />
				<p>
					Gestor de Tareas &copy; <?php echo date('Y'); ?>
				</p>
		</div>
	</footer>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>