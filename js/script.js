$(document).ready(function(){
});

function addTarea(){
	var nombreTarea = $("#nombreTarea").val();
	var tareas = [];

	//añadimos los checkbox seleccionados al array tareas
	$(".checkbox-tarea:checked").each(function(){
			tareas.push($(this).val());
	});

	if(nombreTarea == ""){
		$("#nombreTarea").addClass('is-invalid');
	}else if(tareas.length < 1){
		$("#nombreTarea").removeClass('is-invalid');
		$("#error").show('slow').delay(3200).hide('slow');
	}else{

		var tareasJson = JSON.stringify(tareas);//convertimos el array en json

		$.ajax({
			type: 'POST',
			url: "ajax.php",
			dataType: "json",
			data: {
				action: 'add',
				nombreTarea: nombreTarea,
				tareas: tareasJson
			},
			success: function(response){
				$("#nombreTarea").removeClass('is-invalid');
				$("#nombreTarea").val("");
				$(".checkbox-tarea:checked").each(function(){
					$(this).prop('checked', false);
				});
				$("#tbody_tareas").append("<tr id='tarea_"+response+"'><td>" + nombreTarea + "</td><td style='text-align: center;'>" 
											+ pintarCategorias(tareasJson) + 
											"</td><td><input type='button' value='Eliminar' class='btn btn-danger' onclick='eliminarTarea("+response+")'></td></tr>");
				$("#valid").show('slow').delay(3200).hide('slow');

			}
		});
	}
}

function eliminarTarea(idTarea){
	$.ajax({
		type: 'POST',
		url: "ajax.php",
		dataType: "json",
		data: {
			action: 'delete',
			idTarea: idTarea
		},
		success: function(response){
			if(response == "OK"){
				$("#tarea_"+idTarea).remove();	
				$("#valid").show('slow').delay(3200).hide('slow');
			}
		}
	});
}


function pintarCategorias(tareasJson){
	var tareas = "";
	
	$.each(JSON.parse(tareasJson), function(index, value){
		tareas += "<span class='btn btn-info col-sm-4 boton-tareas'>"+value+"</span>";		
	});

	return tareas;
}