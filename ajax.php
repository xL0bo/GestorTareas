<?php 


include 'config.php';

$tarea = new Tarea();

if(isset($_POST['action'])){

	switch ($_POST['action']) {
		case 'add':
			echo json_encode($tarea->add($_POST['nombreTarea'], $_POST['tareas']));
			break;

		case 'delete':
			echo json_encode($tarea->delete($_POST['idTarea']));
			break;
	}

}